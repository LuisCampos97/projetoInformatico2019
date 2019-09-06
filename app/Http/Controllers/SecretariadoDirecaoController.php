<?php

namespace App\Http\Controllers;

use App\PropostaSecretariadoDirecao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:/laragon/www/projetoinformatico/vendor/autoload.php';

class SecretariadoDirecaoController extends Controller
{
    public function getPropostasPendentes()
    {
        $propostasADevolver = [];
        $propostas = DB::table('proposta')
            ->join('proposta_proponente', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
            ->join('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
            ->join('proposta_ctc', 'proposta.proposta_ctc_id', 'proposta_ctc.id_proposta_ctc')
            ->whereNotNull('proposta.proposta_ctc_id')
            ->whereNull('proposta.proposta_secretariado_direcao_id')
            ->where('status', '!=', 'rejeitado')
            ->get();

        array_push($propostasADevolver, $propostas);

        return $propostasADevolver[0];
    }

    public function getHistoricoPropostas()
    {
        $propostasADevolver = [];

        $historicoPropostas = DB::table('proposta_proponente')
            ->leftJoin('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
            ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
            ->leftJoin('proposta_ctc', 'proposta_ctc.id_proposta_ctc', 'proposta.proposta_ctc_id')
            ->leftJoin('proposta_secretariado_direcao', 'proposta.proposta_secretariado_direcao_id', 'proposta_secretariado_direcao.id_proposta_secretariado_direcao')
            ->whereNotNull('proposta.proposta_secretariado_direcao_id')
            ->whereNull('proposta.proposta_recursos_humanos_id')
            ->get();

        array_push($propostasADevolver, $historicoPropostas);
        return $propostasADevolver[0];
    }

    public function store(Request $request)
    {
        $request->validate([
            'convite' => 'required',
            'secretariado_direcao_id' => 'required',
        ]);
        $propostaSecretariadoDirecao = new PropostaSecretariadoDirecao();
        $propostaSecretariadoDirecao->fill($request->all());

        
        $propostaSecretariadoDirecao->save();

        return response()->json($propostaSecretariadoDirecao, 200);
    }

    public function enviarEmailDocente($email, Request $request){
        //dd($request);
        $mail = new PHPMailer(true);

        try {
            //Server settings
                                                  // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'projetoinformatico2019@gmail.com';                     // SMTP username
            $mail->Password   = 'projetoinformatico';                               // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 465;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('projetoinformatico2019@gmail.com', 'ESTG');
            $mail->addAddress($email, 'Joe User');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Nova Proposta na plataforma de contratações';
            $mail->Body    = $request->convite;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //? FUNÇÕES ESTATISTICA
    public function getPropostas($secretariado_direcao_id)
    {
        $arrayPropostas = DB::table('proposta_secretariado_direcao')->where('id_proposta_secretariado_direcao', $secretariado_direcao_id)->get();

        return $arrayPropostas;
    }

}

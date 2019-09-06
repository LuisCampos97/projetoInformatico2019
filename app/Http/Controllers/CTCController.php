<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaCTC;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:/laragon/www/projetoinformatico/vendor/autoload.php';

class CTCController extends Controller
{
   public function getPropostasPendentes()
   {

      $propostasADevolver = [];
      $propostas = DB::table('proposta')
         ->join('proposta_proponente', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
         ->join('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', '=', 'proposta_diretor_uo.id_proposta_diretor_uo')
         ->whereNotNull('proposta.proposta_diretor_uo_id')
         ->whereNull('proposta.proposta_ctc_id')
         ->where('proposta_diretor_uo.parecer', 'Favoravel')
         ->get();

      array_push($propostasADevolver, $propostas);
      return $propostasADevolver[0];
   }

   public function store(Request $request)
   {
      $request->validate([
         'votos_a_favor' => 'required',
         'votos_contra' => 'required',
         'votos_brancos' => 'required',
         'votos_nulos' => 'required',
         'aprovacao' => 'required',
         'data_assinatura' => 'required',
         'ctc_id' => 'required'
      ]);
      $propostaCTC = new PropostaCTC();
      $propostaCTC->fill($request->all());
      $propostaCTC->save();

     
      return response()->json($propostaCTC, 200);
   }

   public function getTipoPropostaRole($role, $proposta_proponente_id)
   {
      $proposta_proponente_role = null;
      if ($role == "professor") {
         $proposta_proponente_role = PropostaProponenteProfessor::findOrFail($proposta_proponente_id);
      }
      if ($role == "assistente") {
         $proposta_proponente_role = PropostaProponenteAssistente::findOrFail($proposta_proponente_id);
      }
      if ($role == "monitor") {
         $proposta_proponente_role = PropostaProponenteMonitor::findOrFail($proposta_proponente_id);
      }

      return $proposta_proponente_role;
   }

   public function enviarEmailSD(){
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
          $mail->setFrom('projetoinformatico2019@gmail.com', 'Testes');
          $mail->addAddress('projetoinformatico2019@gmail.com', 'Joe User');     // Add a recipient
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
          $mail->Body    = 'Caro membro do Secretariado da Direção, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações';
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      
          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   }

   public function getHistoricoPropostasCTC()
   {
      $propostasADevolver = [];

      $historicoPropostas = DB::table('proposta_proponente')
         ->leftJoin('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
         ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
         ->leftJoin('proposta_ctc', 'proposta_ctc.id_proposta_ctc', 'proposta.proposta_ctc_id')
         ->whereNotNull('proposta.proposta_ctc_id')
         ->get();

      array_push($propostasADevolver, $historicoPropostas);

      return $propostasADevolver[0];
   }

   //? FUNÇÕES ESTATISTICA
   public function getPropostas($ctc_id)
    {
        $arrayPropostas = DB::table('proposta_ctc')->where('ctc_id', $ctc_id)->get();

        return $arrayPropostas;
    }

    public function getPropostasPorTipoParecer($ctc_id)
    {
        $propostasAprovadas = DB::table('proposta_ctc')->where('ctc_id', $ctc_id)->where('aprovacao', 'Aprovado')->count();
        $propostasNaoAprovadas = DB::table('proposta_ctc')->where('ctc_id', $ctc_id)->where('aprovacao', 'Nao Aprovado')->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasAprovadas);
        array_push($arrayADevolver, $propostasNaoAprovadas);

        return $arrayADevolver;
    }
}

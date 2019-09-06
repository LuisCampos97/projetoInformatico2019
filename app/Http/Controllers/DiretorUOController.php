<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaDiretorUO;
use Illuminate\Support\Facades\DB;
use App\PropostaProponenteProfessor;
use App\PropostaProponenteAssistente;
use App\PropostaProponenteMonitor;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:/laragon/www/projetoinformatico/vendor/autoload.php';

class DiretorUOController extends Controller
{
   public function getPropostasPendentes() 
   {
      $propostasADevolver=[];

      $propostaProponente=DB::table('proposta_proponente')
      ->join('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
      ->whereNotNull('proposta.proposta_proponente_id')
      ->whereNull('proposta.proposta_diretor_uo_id')
      ->whereNotNull('proposta_proponente.fundamentacao_coordenador_departamento')
      ->whereNotNull('proposta_proponente.fundamentacao_coordenador_curso')
      ->get();

      array_push($propostasADevolver, $propostaProponente);
      
      return $propostasADevolver[0];
   }

   public function store(Request $request){
      if($request->reconhecimento == true){
         $request->reconhecimento = 1;
      }
      else{
         $request->reconhecimento = 0;
      }
      $request->validate([
         'reconhecimento' => 'required',
         'parecer' => 'required',
         'data_assinatura' => 'required',
         'diretor_uo_id' => 'required'
      ]);

      $propostaDiretorUO = new PropostaDiretorUO();
      $propostaDiretorUO->fill($request->all());
      $propostaDiretorUO->save();

      //$this->sendEmailCTC();

      return response()->json($propostaDiretorUO, 200);
   }

   public function enviarEmailCTC(){
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
          $mail->Body    = 'Caro membro do Conselho Tecnico-Científico, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações';
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      
          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   }

   public function getTipoPropostaRole($role, $proposta_proponente_id){
      
      $proposta_proponente_role = null;
      if($role == "professor"){
         $proposta_proponente_role = DB::table('proposta_proponente_professor')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }
      if($role == "assistente"){
         $proposta_proponente_role = DB::table('proposta_proponente_assistente')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }
      if($role == "monitor"){
         $proposta_proponente_role = DB::table('proposta_proponente_monitor')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }

      return $proposta_proponente_role;
   }

   public function getUCSPropostaSelecionada($proposta_proponente_id){
      $ucs = DB::table('ucs_proposta_proponente')->where('proposta_proponente_id', $proposta_proponente_id)->get();
      return $ucs;
   }

   public function getHistoricoPropostas(){
      $propostasADevolver=[];

      $historicoPropostas=DB::table('proposta_proponente')
      ->leftJoin('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
      ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
      ->whereNotNull('proposta.proposta_diretor_uo_id')
      ->get();

      array_push($propostasADevolver, $historicoPropostas);
      
      return $propostasADevolver[0];
   }

   //? FUNÇÕES ESTATISTICA
   public function getPropostas($diretor_id)
    {
        $arrayPropostas = DB::table('proposta_diretor_uo')->where('diretor_uo_id', $diretor_id)->get();

        return $arrayPropostas;
    }

    public function getPropostasPorTipoParecer($diretor_id)
    {
        $propostasFavoraveis = DB::table('proposta_diretor_uo')->where('diretor_uo_id', $diretor_id)->where('parecer', 'Favoravel')->count();
        $propostasDesfavoraveis = DB::table('proposta_diretor_uo')->where('diretor_uo_id', $diretor_id)->where('parecer', 'Desfavoravel')->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasFavoraveis);
        array_push($arrayADevolver, $propostasDesfavoraveis);

        return $arrayADevolver;
    } 
}

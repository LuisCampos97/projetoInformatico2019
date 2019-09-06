<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:/laragon/www/projetoinformatico/vendor/autoload.php';

class NovoDocenteController extends Controller
{
    public function getProposta($emailDocente){
        $propostaProponente =DB::table('proposta_proponente')->where('email', $emailDocente)->get();
        //dd($propostaProponente);
        $proposta = DB::table('proposta')->join('proposta_proponente', 'proposta.proposta_proponente_id', 'proposta_proponente.id_proposta_proponente')->
                    where('proposta.proposta_proponente_id', $propostaProponente[0]->id_proposta_proponente)->
                    where('proposta.docente_inseriu_ficheiros', '!=', 1)->get();
        return $proposta;
    }

    public function enviarMailRH(){
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
            $mail->Body    = 'Caro membro dos Recursos Humanos, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

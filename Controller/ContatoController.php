<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once 'config.php';

    // Ação para exibir a página principal
    class ContatoController {
        

        public function sendEmailContact($content, $title)
        {
            require_once("../libs/phpmailer/vendor/autoload.php");

            if (session_status() === PHP_SESSION_NONE) { session_start(); }

            $senderEmail = 'refeicao@leds.net.br';
            $senderPassword = '';
            //$title = 'Email de contato';
            $recipientName = 'Refeição IFBA Seabra';
            $senderName = $_SESSION['name'];
            $host = 'email-ssl.com.br';

            $content = '
            <!DOCTYPE html>
            <html>
            <p style="color:black;">
                Olá, Você recebeu uma nova mensagem do formulário de contato.<br><br>
                Nome: '. $_SESSION['name'] .' <br>
                Email: '. $_SESSION['email'] .' <br>
                Telefone: '. $_SESSION['telefone'] .'<br>
                Matricula: '. $_SESSION['enrollment'] .' <br>
                <br>
                '. $content .'
            </p>
            </html>
            ';

            try
            {
                
                $mail = new PHPMailer();

                // Definindo idioma para o português
                $mail->setLanguage('pt_br', '../libs/phpmailer/vendor/phpmailer/phpmailer/language/');
                $mail->CharSet = 'UTF-8'; // definindo o conjunto de caracteres

                $mail->isSMTP(); // protocolo de transferência de e-mail
                $mail->Host = $host; // servidor de e-mail
                $mail->SMTPAuth = true;
                $mail->Port = 465;

                $mail->Username = $senderEmail;  // e-mail do rementente (SMPT)
                $mail->setFrom($senderEmail, $senderName);
                $mail->Password = $senderPassword; // senha do e-mail do remetente (SMPT)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

                $mail->addAddress($senderEmail, $recipientName);
                $mail->isHTML(true); // é se o formato do e-mail é HTML
                $mail->Subject = $title; // titulo do e-mail (assunto)
                $mail->Body = $content; // conteúdo do e-mail
                
                $mail->send();

                return true;
            }
            catch (Exception $e)
            {
                return false;
            }
        }
    }
?>
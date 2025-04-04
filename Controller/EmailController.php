<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once("../libs/phpmailer/vendor/autoload.php");

    class EmailController
    {
        public $mail;

        public function __construct()
        {
            $this->mail = new PHPMailer();
        }



        public function sendEmail($senderEmail, $senderName, $senderPassword, $recipientEmail, $recipientName, $title, $content, $host="email-ssl.com.br",)
        {
            try
            {
                // Definindo idioma para o português
                $this->mail->setLanguage('pt_br', '../libs/phpmailer/vendor/phpmailer/phpmailer/language/');
                $this->mail->CharSet = 'UTF-8'; // definindo o conjunto de caracteres

                $this->mail->isSMTP(); // protocolo de transferência de e-mail
                $this->mail->Host = $host; // servidor de e-mail
                $this->mail->SMTPAuth = true;
                $this->mail->Port = 465;

                $this->mail->Username = $senderEmail;  // e-mail do rementente (SMPT)
                $this->mail->setFrom($senderEmail, $senderName);
                $this->mail->Password = $senderPassword; // senha do e-mail do remetente (SMPT)
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

                $this->mail->addAddress($recipientEmail, $recipientName);
                $this->mail->isHTML(true); // é se o formato do e-mail é HTML
                $this->mail->Subject = $title; // titulo do e-mail (assunto)
                $this->mail->Body = $content; // conteúdo do e-mail
                
                $this->mail->send();

                return true;
            }
            catch (Exception $e)
            {
                return false;
            }
        }

        public function sendEmailLunch($recipientEmail, $recipientName)
        {
            date_default_timezone_set('America/Sao_Paulo');
            $currente_day = date('d/m/Y');

            $senderEmail = '';
            $senderName = 'Refeição IFBA Seabra';
            $senderPassword = '';
            $title = 'Indicação de alimentação no campus - IFBA Seabra';
            
            $content = '
            <!DOCTYPE html>
            <html>
            <p style="color:black;">
                Olá,<br><br>
                Sua confirmação para o almoço no IFBA Campus Seabra para a data de '. $currente_day .' foi realizada com sucesso! <br><br>
                Em caso de dúvidas ou para relatar algum problema, envie um novo e-mail para este endereço.<br><br>
                Atenciosamente,<br>
                Suporte Almoço IFBA Seabra
            </p>
            </html>
            ';
            
            return (new EmailController())->sendEmail($senderEmail, $senderName, $senderPassword, $recipientEmail, $recipientName, $title, $content);
        }

    }

?>

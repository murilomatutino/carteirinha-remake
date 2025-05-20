<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once __DIR__ . '/../Model/model.php';

    class CardapioController {
        public $model;

        public function __construct() {
            $this->model = new Model();
        }

        public function getCardapio() {
            return $this->model->getCardapio();
        }

        public function getTime() {
            return $this->model->getTime();
        }

        public function hasRefeicao($idUser, $current_day) {
            return $this->model->hasRefeicao($idUser, $current_day);
        }

        public function hasTransferencia($idUser) {
            return $this->model->transferenciaIsActive($idUser);
        }

        public function getRefeicaoById($idUser) {
            return $this->model->getRefeicaoById($idUser);
        }
 
        public function getCardapioById($idCardapio) {
            return $this->model->getCardapioById($idCardapio);
        }

        public function getIdCardapio($diaDaSemana) {
            return $this->model->getIdCardapio($diaDaSemana);
        }

        public function processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana) {
            date_default_timezone_set('America/Sao_Paulo');
            $idCardapio = $this->model->getIdCardapio($diaDaSemana);
            $statusRef = 1;
            $dataSolicitacao = date("Y-m-d");
            $horaSolicitacao = date("H:i:s");

            $result = $this->model->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);

            if ($result) {
                return ['status' => true, 'message' => 'Refeição agendada com sucesso!'];
            } else {
                return ['status'=> false, 'message'=> 'Houve um problema ao agendar a sua refeição. Por favor, tente novamente mais tarde!'];
            }
        }

        public function cancelarReserva($idUser, $motivo) {
            // Primeiramente, verificamos se a reserva existe e está ativa
            if ($this->model->isActive($idUser)) {
                if ($this->model->cancelarReserva($idUser, $motivo)) {
                    return ['status' => true, 'message' => 'Reserva cancelada com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao cancelar a reserva'];
                }
            } else {
                return ['status' => false, 'message' => 'Reserva não encontrada ou já foi cancelada'];
            }
        }
        
        public function transferirReserva($idUser, $motivo, $matriculaAlvo) {
            if ($this->model->isActive($idUser)) {
                if ($this->model->transferirReserva($idUser, $motivo, $matriculaAlvo)['success']) {
                    return ['status' => true, 'message' => 'Reserva transferida com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao transferir reserva'];
                }
            } else {
                return ['status' => false, 'message' => 'Reserva não encontrada!'];
            }
        }

        public function excluirCardapio() {
            if ($this->model->excluirCardapio()) {
                return ['status' => true, 'message' => 'Cardápio excluído com sucesso!'];
            } else {
                return ['status' => false, 'message' => 'Falha ao excluir cardápio!'];
            }
        }


        public function sendEmailLunch($recipientEmail, $recipientName)
        {
            require_once("../libs/phpmailer/vendor/autoload.php");

            date_default_timezone_set('America/Sao_Paulo');
            $currente_day = date('d/m/Y');

            $senderEmail = 'refeicao@leds.net.br';
            $senderName = 'Refeição IFBA Seabra';
            $senderPassword = '';
            $title = 'Indicação de alimentação no campus - IFBA Seabra';
            $host = 'email-ssl.com.br';
            
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

                $mail->addAddress($recipientEmail, $recipientName);
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

        public function getIdByMatricula($matricula){
            return $this->model->getIdByMatricula($matricula);
        }

        // Buscar tags de criação do cardapio
        public function getTagsCardapio() {
            return $this->model->getTagsCardapio();
        }

        // Cadastrar nova tag no banco de dados
        public function criarTag($tagName, $restricoes, $gluten, $lactose) {
            return $this->model->criarTag($tagName, $restricoes, $gluten, $lactose);
        }

        // Criar cardápio
        public function salvarCardapioSemana($dados) {
            return $this->model->salvarCardapioSemana($dados);
        }
    }
?>
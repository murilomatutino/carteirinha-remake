<?php
    require_once( __DIR__ . '/../Model/classes/NotificationModel.php');

    // Ação para exibir a página principal
    class NotificationController {
        public $model;
        public function __construct() {
            $this->model = new NotificationModel();
        }

        public function hasNotification($userId) {
            $hasNotification = $this->model->hasNotification($userId);
            return $hasNotification;
        }

        public function hasNewNotification($userId) {
            $hasNotification = $this->model->hasNewNotification($userId);
            return $hasNotification;
        }

        public function getNotification($userId, $idNotification = null){
            $notificacoes = $this->model->getNotification($userId, $idNotification);

            date_default_timezone_set('America/Sao_Paulo');
            $horaAtual = date("H:i:s");

            if ($horaAtual > "12:00:00") {
                $lista = [];

                foreach ($notificacoes as $n)
                {
                    $n['transferencia'] = 0;
                    array_push($lista, $n);
                }

                return $lista;
            }

            return $notificacoes;
        }

        private function getIdRemetente($idDestinatario): int {
            return $this->model->getTransferenciaData($idDestinatario);
        }

        public function aceitarRefeicao($idDestinatario) {
            $idRemetente = $this->getIdRemetente($idDestinatario);
            if (empty($idRemetente)){return ['status' => false, 'message' => 'Falha ao aceitar refeição'];}
            
            if (!$this->model->isActive($idDestinatario) && $this->model->isActive($idRemetente)) {
                if ($this->model->aceitarRefeicao($idDestinatario, $idRemetente)) {
                    return ['status' => true, 'message' => 'Refeição aceita com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao aceitar refeição'];
                }
            } else {
                return ['status' => false, 'message' => 'Já existe reserva ativa no id do destinatário ou do remetente'];
            }
        }

        public function cancelarTransferencia($idDestinatario)
        {
            $idRemetente = $this->getIdRemetente($idDestinatario);
            if (empty($idRemetente)){return false;}

            return $this->model->changeNotificacaoType($idRemetente);

        }

        public function readNotification($idDestinatario, $idNotification) {
            if ($this->model->readNotification($idDestinatario, $idNotification)) {
                return ['status'=> true, 'message'=> 'Notificação lida'];
            } else {
                return ['status'=> false, 'message'=> 'Erro ao ler notificação'];
            }
        }

        public function createNotificacao($idRemetente, $idAlvo, $assunto, $mensagem, $tipo)
        {
            return $this->model->createNotificacao($idRemetente, $idAlvo, $assunto, $mensagem, $tipo);
        }
    }
?>
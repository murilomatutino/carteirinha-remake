<?php
    require_once __DIR__ . '/../Model/model.php';

    // Ação para exibir a página principal
    class NotificationController {
        public $model;
        public function __construct() {
            $this->model = new Model();
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
            return $this->model->getNotification($userId, $idNotification);
        }

        private function getIdRemetente($idDestinatario): int {
            return $this->model->getTransferenciaData($idDestinatario);
        }

        public function aceitarRefeicao($idDestinatario) {
            $idRemetente = $this->getIdRemetente($idDestinatario);
            if (!$this->model->isActive($idDestinatario) && $this->model->isActive($idRemetente)) {
                if ($this->model->aceitarRefeicao($idDestinatario, $idRemetente)['status']) {
                    return ['status' => true, 'message' => 'Refeição aceita com sucesso'];
                } else {
                    return ['status' => false, 'message' => 'Falha ao aceitar refeição'];
                }
            } else {
                return ['status' => false, 'message' => 'Já existe reserva ativa no id do destinatário ou do remetente'];
            }
        }

        public function readNotification($idDestinatario, $idNotification) {
            if ($this->model->readNotification($idDestinatario, $idNotification)) {
                return ['status'=> true, 'message'=> 'Notificação lida'];
            } else {
                return ['status'=> false, 'message'=> 'Erro ao ler notificação'];
            }
        }
    }
?>
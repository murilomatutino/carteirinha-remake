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

        public function getAssunto($userId) {
            $assunto = $this->model->getAssunto($userId);
            return $assunto;
        }

        public function getNotification($userId) {
            return $this->model->getNotification($userId);
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
    }
?>
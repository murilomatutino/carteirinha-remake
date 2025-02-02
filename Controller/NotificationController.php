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

        public function aceitarRefeicao($idUser) {
            if ($this->model->isActive($idUser)) {
                if ($this->model->aceitarRefeicao($idUser)) {
                    echo json_encode(['status'=> 'success', 'message' => 'Refeição aceita com sucesso']); exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao aceitar refeição']); exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Reserva não encontrada!']); exit();
            }
        }
    }
?>
<?php
    require_once __DIR__ . '/../Model/model.php';

    // Ação para exibir a página principal
    class NotificationController {
        public $model;
        public function __construct() {
            $this->model = new Model();
        }

        public function hasNotification() {
            $userId = $_SESSION['id'];
            $hasNotification = $this->model->hasNotification($userId);
            return $hasNotification;
        }

        public function getAssunto($userId) {
            $assunto = $this->model->getAssunto($userId);
            return $assunto;
        }
    }
?>
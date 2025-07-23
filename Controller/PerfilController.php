<?php
    require_once( __DIR__ . '/../Model/classes/PerfilModel.php');

    class PerfilController
    {
        public $model;

        public function __construct()
        {
            $this->model = new PerfilModel();
        }

        public function setPassword($newPassword, $idUser)
        {
            return $this->model->setPassword($newPassword, $idUser);
        }
    }
?>
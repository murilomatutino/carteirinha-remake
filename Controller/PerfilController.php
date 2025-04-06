<?php
    require_once('../Model/model.php');

    class PerfilController
    {
        public $model;

        public function __construct()
        {
            $this->model = new Model();
        }

        public function setPassword($newPassword, $idUser)
        {
            return $this->model->setPassword($newPassword, $idUser);
        }
    }
?>
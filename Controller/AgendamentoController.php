<?php
    require_once( __DIR__ . '/../Model/classes/AgendamentoModel.php');

    class AgendamentoController
    {
        public $model;

        public function __construct()
        {
            $this->model = new AgendamentoModel();
        }

        public function hasAgendamento($dia, $idUser)
        {
            return $this->model->hasAgendamento($dia, $idUser);
        }

        public function retirarAlmoco($dia, $idUser)
        {
            return $this->model->retirarAlmoco($dia, $idUser);
        }
    }
?>
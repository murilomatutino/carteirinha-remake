<?php
    require_once( __DIR__ . '/../../Model/classes/RelatorioModel.php');

    class RelatorioController
    {
        public $model;

        public function __construct()
        {
            $this->model = new RelatorioModel();
        }

        public function getRelatorioFaltas($day)
        {
            return $this->model->getRelatorioFaltas($day);
        }

        public function getNameById($id)
        {
            return $this->model->getNameById($id);
        }

        public function getCardapioByInterval($inicio, $fim)
        {
            return $this->model->getCardapioByInterval($inicio, $fim);
        }
    }
?>
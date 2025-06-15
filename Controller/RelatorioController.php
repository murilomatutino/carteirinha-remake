<?php
    require_once('../Model/model.php');

    class RelatorioController
    {
        public $model;

        public function __construct()
        {
            $this->model = new Model();
        }

        public function getRelatorioFaltas($day)
        {
            return $this->model->getRelatorioFaltas($day);
        }
    }
?>
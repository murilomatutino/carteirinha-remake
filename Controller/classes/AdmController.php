<?php
    require_once( __DIR__ . '/../../Model/classes/AdmModel.php');

    class AdmController {
        public $model;
        public function __construct() {
            $this->model = new AdmModel();
        }

        public function editarHorario($hora) {
            $response = $this->model->editarHorario($hora);

            if ($response) {
                return ['status' => true, 'message' => 'Horário editado com sucesso'];
            } else {
                return ['status' => false, 'message' => 'Erro ao editar horário'];
            }
        }
    }
?>
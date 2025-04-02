<?php
    require_once __DIR__ . '/../Model/model.php';

    class AdmController {
        public $model;
        public function __construct() {
            $this->model = new Model();
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
<?php
    require_once 'AuthController.php';
    require_once 'config.php';

    // Ação para exibir a página principal
    class HomeController {
        public function index() {
            header(PATH . "/View/landpage.php"); exit();
        }

        public function indexAdm() {
            header(PATH . "/View/painel-administrador.php"); exit();
        }
    }
?>
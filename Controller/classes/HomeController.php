<?php
    require_once __DIR__ . '/AuthController.php';
    require_once __DIR__ . '/../config.php';

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
<?php
    require_once 'AuthController.php';
    require_once 'config.php';

    // Ação para exibir a página principal
    class HomeController {
        public function index() {
            header(PATH . "/View/landpage.php"); exit();
        }
    }
?>
<?php session_start();
    require_once 'HomeController.php';
    require_once 'config.php';
    require_once __DIR__ . '/../Model/model.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $authController = new AuthController();

            if ($_POST['action'] == 'login') {
                $matricula = $_POST['matricula'];
                $pass = $_POST['password'];

                $authController->login($matricula, $pass);
            } else {
                // $authController = new AuthController();
                $authController->logout();
            }      
        }  
    }   
?>

<?php
    class AuthController {
        public $homeController;
        public $model;

        public function __construct() {
            $this->homeController = new HomeController();
            $this->model = new Model();
        }

        // Verificar se o usuário está logado
        public function isLoggedIn() {
            if (!isset($_SESSION['user'])) {
                $this->showLogin();
            } else {
                $this->homeController->index();
            }
        }

        // Exibir a página de login
        public function showLogin() {
            header(PATH . '/View/login.php'); exit();
        }

        // Ação de login
        public function login($user, $pass) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $matricula = $_POST['matricula'];
                $password = $_POST['password'];

                if ($this->model->login($matricula, $password)) {
                    $data = $this->model->getDataByMatricula($matricula);
                    if ($data !== false) {
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['name'] = $data['nome'];
                        $_SESSION['email'] = $data['email'];
                        $_SESSION['enrollment'] = $data['matricula'];
                        $_SESSION['category'] = $data['categoria'];
                        $_SESSION['logged_in'] = true;
                        echo "logged"; exit();
                    }  
                } else {
                    echo "error"; exit();
                }
            }
        }

        // Ação de logout
        public function logout() {
            session_destroy();
            header(PATH); exit();
        }
    }
?>
<?php session_start();
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    require_once(__DIR__ . '/HomeController.php');
    require_once(__DIR__ . '/../config.php');
    require_once( __DIR__ . '/../../Model/classes/AuthModel.php');
?>

<?php
    class AuthController {
        public $homeController;
        public $model;

        public function __construct() {
            $this->homeController = new HomeController();
            $this->model = new AuthModel();
        }

        // Verificar se o usuário está logado
        public function isLoggedIn() {
            if (!isset($_SESSION['logged_in'])) {
                $this->showLogin();
            } else {
                if ($_SESSION['category'] === 'adm') {
                    $this->homeController->indexAdm();
                } else {
                    $this->homeController->index();
                }
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
                        $_SESSION['telefone'] = $data['telefone'];
                        $_SESSION['enrollment'] = $data['matricula'];
                        $_SESSION['category'] = $data['categoria'];
                        $_SESSION['logged_in'] = true;
                        return ['status' => true, 'message' => 'sucesso']; 
                    }  
                } else {
                    return ['status' => false, 'message' => 'Credenciais inválidas'];
                }
            }
        }

        // Ação de logout
        public function logout() {
            session_destroy(); 
            header(PATH);
        }
    }
?>
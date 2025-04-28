<?php 
    require_once 'CardapioController.php';
    require_once 'NotificationController.php';
    require_once 'AuthController.php';
    require_once 'FeedbackController.php';
    require_once 'AdmController.php';

    function cancelarReserva($idUser, $motivo) {
        $response = (new CardapioController)->cancelarReserva($idUser, $motivo);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function transferirReserva($idUser, $motivo, $matriculaAlvo) {
        $response = (new CardapioController)->transferirReserva($idUser, $motivo, $matriculaAlvo);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function aceitarRefeicao($idDestinatario) {
        $response = (new NotificationController)->aceitarRefeicao($idDestinatario);
        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response["message"]]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response["message"]]); exit();
        }
    }

    function getNotification($idUser, $idNotification) {
        $response = (new NotificationController)->getNotification($idUser, $idNotification);

        if ($response !== null) {
            echo json_encode(['status'=> 'success', 'array' => $response]); exit();
        } else {
            echo json_encode(['status'=> 'error', 'message' => 'Nenhuma notificação encontrada']); exit();
        }
    }

    function readNotification($idDestinatario, $idNotification) {
        $response = (new NotificationController)->readNotification($idDestinatario, $idNotification);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function login($matricula, $pass) {
        $response = (new AuthController())->login($matricula, $pass);

        if ($response['status']) {
            echo json_encode(['status' => 'success', 'message' => $response['message']]); exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $response['message']]); exit();
        }
    }

    function sendFeedback($nota, $idUser, $idCardapio) {
        $response = (new FeedbackController)->sendFeedback($nota, $idUser, $idCardapio);

        if ($response !== null && $response) {
            echo json_encode(['status'=> 'success', 'array' => $response['message']]); exit();
        } else {
            echo json_encode(['status'=> 'error', 'message' => $response['message']]); exit();
        }
    }

    function excluirCardapio() {
        $response = (new CardapioController)->excluirCardapio();

        if ($response !== null && $response['success']) {
            echo json_encode(['status'=> 'success', 'array' => $response['message']]); exit();
        } else {
            echo json_encode(['status'=> 'error', 'message' => $response['message']]); exit();
        }
    }

    function editarHorario($hora) {
        $response = (new AdmController)->editarHorario($hora);
        $encodedMessage = base64_encode($response['message']);

        if ($response !== null && $response['status']) {
            header("Location: ../View/painel-administrador.php?status=success&message=" . urlencode($encodedMessage)); exit();
        } else {
            header("Location: ../View/editar-horario.php?status=error&message=" . urlencode($encodedMessage)); exit();
        }
    }

    function enviarNotificacao($idUser, $motivo, $matriculaAlvo)
    {

        $idAlvo = (new CardapioController())->getIdByMatricula($matriculaAlvo);

        $return = (new NotificationController())->createNotificacao($idUser, $idAlvo, 'Transferencia de almoço', "Motivo da transferência: " . $motivo, 1);
        
        if ($idAlvo === false){
            echo json_encode(['status'=> 'error', 'message' => 'Erro ao pegar id por matricula']); exit();
        }
        else if ($return === false)
        {
            echo json_encode(['status'=> 'error', 'message' => 'Erro ao criar notificação']); exit();
        }
        else
        {
            echo json_encode(['status'=> 'success', 'array' => 'sucesso ao criar notificação']); exit();
        }
    }

    function cancelarTransferencia($idDestinatario)
    {
        $response = (new NotificationController)->cancelarTransferencia($idDestinatario);
        if ($response) {
            echo json_encode(['status' => 'success']); exit();
        } else {
            echo json_encode(['status' => 'error']); exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['operacao'])) {
        switch ($_POST['operacao']) {
            case 'cancelarReserva': cancelarReserva($_POST['idUser'], $_POST['motivo']); break;
            case 'transferirReserva': transferirReserva($_POST['idUser'], $_POST['motivo'], $_POST['matriculaAlvo']); break;
            case 'aceitarRefeicao': aceitarRefeicao($_POST['idDestinatario']); break;
            case 'getNotification': getNotification($_POST['idUser'], $_POST['idNotificacao']); break;
            case 'readNotification': readNotification($_POST['idDestinatario'], $_POST['idNotificacao']); break;
            case 'enviarFeedback': sendFeedback($_POST['nota'], $_POST['idUser'], $_POST['idCardapio']); break;
            case 'excluir': excluirCardapio(); break;
            case 'editarHorario': editarHorario($_POST['hora']); break;
            case 'enviarNotificacao': enviarNotificacao($_POST['idUser'], $_POST['motivo'], $_POST['matriculaAlvo']); break;
            case 'cancelarTransferencia': cancelarTransferencia($_POST['idDestinatario']); break;
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            $matricula = $_POST['matricula'];
            $pass = $_POST['password'];

            login($matricula, $pass);
        } else {
            (new AuthController())->logout();
        }
    } else {
        $idJustificativa = 0;
        $justificativa = $_POST['justificativa'];
        $idUser = $_POST['idUser'];
        $diaDaSemana = $_POST['diaDaSemana'];

        if ($justificativa == "outro") {
            $idJustificativa = 4;
            $justificativa = $_POST["outro"];
        } else {
            $idJustificativa = match ($justificativa) {
                "contra-turno" => 1,
                "transporte"   => 2,
                "projeto"      => 3,
                default        => null,
            };
        }
        
        $response = (new CardapioController)->processarReserva($idUser, $idJustificativa, $justificativa, $diaDaSemana);

        if ($response['status']) {
            
            // enviar um e-mail de confirmação
            $return = (new CardapioController())->sendEmailLunch($_SESSION['email'], $_SESSION['name']);
            if (!$return){header("Location: ../View/cardapio.php?agendamento=emailerror"); exit();}

            header("Location: ../View/cardapio.php?agendamento=success"); exit();
        } else {
            header("Location: ../View/cardapio.php?agendamento=error"); exit();
        }
    }
?>
<!-- if (isset($_POST['operacao'])) {
            if ($_POST['operacao'] === 'cancelarReserva') {
                $idUser = $_POST['idUser'];
                $motivo = $_POST['motivo'];

                (new CardapioController)->cancelarReserva($idUser, $motivo);
            } else if ($_POST['operacao'] === 'transferirReserva') {
                $idUser = $_POST['idUser'];
                $motivo = $_POST['motivo'];
                $matricula = $_POST['matriculaAlvo'];

                (new CardapioController)->transferirReserva($idUser, $motivo, $matricula);
            }
        } -->

<?php 
    if (isset($_POST['operacao'])) {
        require_once 'CardapioController.php';
        require_once 'NotificationController.php';

        if ($_POST['operacao'] === 'cancelarReserva') {
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];

            (new CardapioController)->cancelarReserva($idUser, $motivo);
        } else if ($_POST['operacao'] === 'transferirReserva') {
            $idUser = $_POST['idUser'];
            $motivo = $_POST['motivo'];
            $matricula = $_POST['matriculaAlvo'];

            (new CardapioController)->transferirReserva($idUser, $motivo, $matricula);
        } else if ($_POST['operacao'] === 'aceitarRefeicao') {
            $idUser = $_POST['idUser'];

            (new NotificationController())->aceitarRefeicao($idUser);
        }
    }
?>
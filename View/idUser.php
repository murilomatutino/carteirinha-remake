<?php
session_start();
if (isset($_SESSION['id'])) {
    echo $_SESSION['id'];  // Retorna o ID do usuário armazenado na sessão
}
?>
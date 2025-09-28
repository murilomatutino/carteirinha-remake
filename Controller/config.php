<?php

    $base = 'http://localhost/carteirinha-remake';

    // Caminho absoluto
    define('PATH', 'Location: ' . $base);

    // Caminho absoluto sem Location
    define('WPATH', $base);

    // Caminho absoluto cardapio
    define('MENU', $base . '/View/cardapio.php');

    // Caminho absoluto landpage user
    define('LANDPAGE', $base . '/View/landpage.php');

    // Caminho absoluto landpage adm
    define('LANDPAGEADM', $base . '/View/painel-administrador.php');

    // Caminho absoluto logou
    define('LOGOUT', $base . '/View/logout.php');

    // Caminho absoluto login
    define('LOGIN', $base . '/View/login.php');

    // Caminho absoluto sobre
    define('ABOUT', $base . '/View/sobre.php');

    // Caminho absoluto entre em contato
    define('CONTATO', $base . '/View/entre-em-contato.php');

    // Caminho absoluto perfil
    define('PROFILE', $base . '/View/perfil.php');

    // Caminho absoluto qr-code img
    define('QRCODEIMG', $base . '/View/assets/qr-code.png');

    // Caminho absoluto qr-code link
    define('QRCODE', $base . '/View/qr-code.php');

    // Caminho absoluto qr-code estudante
    define('QRCODREAD', $base . '/View/qr-code-estudante.php');

    // Caminho absoluto profile img
    define('PROFILEPIC', $base . '/View/assets/perfilPadrao.jpeg');
?>

<?php 
  require_once '../Controller/NotificationController.php';
  $notController = new NotificationController();

  if ($notController->hasNotification(2)) { 
    $response = $notController->getNotification(2);
    usort($response, function($a, $b) {
      return ($a['lida'] == 0 && $b['lida'] == 1) ? -1 : (($a['lida'] == 1 && $b['lida'] == 0) ? 1 : 0);
    });

    foreach ($response as $key => $value) {
      $type = $value['transferencia'] != 0 ? 'transfer' : 'default'; 
      $read = $value['lida'] == 0 ? '' : 'lida';
      echo "<div class='notification-item visible {$type} {$read} id='{$value['id']}'>";
      echo "<img src='assets/alert.png' alt='icone de alerta'>";
      echo "<div class='notification-content'>";
      echo "<div class='assunto {$read}'><h2 class='title'>{$value['assunto']}</h2><span>Lida</span></div>";
      echo "<p id='notification-text'>{$value['mensagem']}</p>";
      echo "</div>";
      if ($value['transferencia'] == 1) echo "<button class='validar' id='validar-transferencia'>Confirmar</button>";
      echo "</div>";
    }
  } else { 
    echo "<h1>Sem notificações</h1>"; 
  }
?>

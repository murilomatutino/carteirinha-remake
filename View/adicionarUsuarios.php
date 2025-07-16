<!DOCTYPE html>
<html>
<head>
	<title>Importação</title>
	<link rel="stylesheet" href="css/adicionarUsuarios.css">
</head>
<body>
	<header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>
	<main>
		<h1>Adicionar usuarios através de planilha</h1>
		<form method="POST" action="../Controller/processarUsuarios.php" enctype="multipart/form-data">
			<div>
				<label>Arquivo</label>
				<input type="file" name="file" id="file">
			</div>	

			<p>OBS: a planilha deve seguir a seguinte estrutura, na ordem: matricula, nome, email e telefone.</p>
			
			<input type="submit" value="enviar" name="submit">
		</form>
	</main>
	<?php include('footer.php')?>
</body>
</html>
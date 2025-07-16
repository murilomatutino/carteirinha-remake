<!DOCTYPE html>
<html>
<head>
	<title>Importacao</title>
</head>
<body>
	<h1>Upload do arquivo</h1>
	<form method="POST" action="../Controller/processarUsuarios.php" enctype="multipart/form-data">
		<div>
			<label>Arquivo</label>
			<input type="file" name="file" id="file">
		</div>	
		
		<input type="submit" value="enviar" name="submit">
	</form>

</body>
</html>
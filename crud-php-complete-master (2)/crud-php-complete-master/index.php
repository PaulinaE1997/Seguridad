<?php session_start(); ?>
<html>
<head>
	<title>Principal</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div ID="header">
		Gestor de proyectos
	</div>
	<?php
	if(isset($_SESSION['valid'])) {			
		include("connection.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
	?>
				
		Hola, <?php echo $_SESSION['Nombre'] ?> ! <a href='logout.php'>Salir</a><br/>
		<br/>
		<a href='view.php'>Agregar proyecto</a>
		<br/><br/>
	<?php	
	} else {
		echo "Tienes que iniciar sesión para observar esta pagina.<br/><br/>";
		echo "<a href='login.php'>Login</a> | <a href='register.php'>Registrate</a>";
	}
	?>
	<div ID="footer">
	</div>
</body>
</html>

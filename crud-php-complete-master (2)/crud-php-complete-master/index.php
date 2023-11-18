<?php session_start(); ?>
<html>
<head>
	<title>Principal</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
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
		echo "You must be logged in to view this page.<br/><br/>";
		echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
	}
	?>
	<div id="footer">
	</div>
</body>
</html>

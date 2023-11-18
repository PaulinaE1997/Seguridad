
<html>
<head>
	<title>Registrar</title>
</head>

<body>
<a href="index.php">Inicio</a> <br />
<?php

$connectionString = "Driver={ODBC Driver 18 for SQL Server};Server=tcp:eliastorres2.database.windows.net,1433;Database=FinalSeg;Uid=EliasTorres;Pwd=Contraseña00$;Encrypt=yes;TrustServerCertificate=no;Connection Timeout=30;";
$odbcConnection = odbc_connect($connectionString, 'EliasTorres', 'Contraseña00$');

if (!$odbcConnection) {
    die('Error de conexión: ' . odbc_errormsg());
} else {
    echo 'Conexión establecida correctamente.';
}
include("connection.php");

if(isset($_POST['submit'])) {
	$name = $_POST['Nombre'];
	$email = $_POST['Correo'];
	$pName = $_POST['ApellidoPat'];
	$mName = $_POST['ApellidoMat'];
	$pass = $_POST['Password'];

	if($pass == "" || $name == "" || $email == "" || $mName == ""|| $pName == "") {
		echo "Todos los campos requieren ser llenados. ";
		echo "<br/>";
		echo "<a href='register.php'>Regresar</a>";
	} else {
		$query = "INSERT INTO login(Nombre, ApellidoMat, ApellidoPat, Correo, Password) VALUES('$name', '$email', '$pName','$mName', '$pass')";
		$result = odbc_exec($odbcConnection, $query);

		if (!$result) {
			die('Error en la consulta: ' . odbc_errormsg());
		}

		echo "Registro completo";
		echo "<br/>";
		echo "<a href='login.php'>Iniciar Sesion</a>";
	}
} else {
?>
	<p><font size="+2">Registrar</font></p>
	<form name="form1" method="post" action="">
		<table width="75%" border="0">
			<tr> 
				<td width="10%">Nombre</td>
				<td><input type="text" name="Nombre"></td>
			</tr>
			<tr> 
				<td>Apellido Paterno</td>
				<td><input type="text" name="ApellidoPat"></td>
			</tr>
			<tr> 
				<td>Apellido Materno</td>
				<td><input type="text" name="ApellidoMat"></td>
			</tr>
			<tr> 
				<td>Correo Electronico</td>
				<td><input type="text" name="Correo"></td>
			</tr>			
			
			<tr> 
				<td>Contraseña</td>
				<td><input type="password" name="Password"></td>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="submit"></td>
			</tr>
		</table>
	</form>
<?php
}
?>
</body>
</html>

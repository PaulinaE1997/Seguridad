<?php session_start(); ?>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>

<body>
<a href="index.php">Inicio</a> <br />
<?php
include("connection.php");

if (isset($_POST['submit'])) {
    $user = $_POST['Correo'];
    $pass = $_POST['Password'];

    if ($user == "" || $pass == "") {
        echo "Alguno de los campos está vacío.";
        echo "<br/>";
        echo "<a href='login.php'>Regresa</a>";
    } else {
		$query = "SELECT * FROM login WHERE Correo=? AND Password=?";
		$params = array($user, $pass);
		
		$result = sqlsrv_query($conn, $query, $params);
		
		if ($result) {
			$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		
			if ($row) {
					$validuser = $row['Correo'];
					$_SESSION['valid'] = $validuser;
		
					if (isset($_SESSION['valid'])) {
						header('Location: view.php');
					}
				
			} else {
				echo "Correo o contraseña incorrectos lalaland .";
				echo "<br/>";
				echo "<a href='login.php'>Regresar</a>";
			}
		} else {
			die(print_r(sqlsrv_errors(), true));
		}
		
    }
} else {
    ?>
    <p><font size="+2">Inicia Sesión</font></p>
    <form name="form1" method="post" action="">
        <table width="75%" border="0">
            <tr>
                <td width="10%">Correo</td>
                <td><input type="text" name="Correo"></td>
            </tr>
            <tr>
                <td>Contraseña</td>
                <td><input type="password" name="Password"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
    <?php
}
?>
</body>
</html>
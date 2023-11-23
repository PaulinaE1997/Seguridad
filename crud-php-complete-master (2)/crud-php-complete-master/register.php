<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>

<body>
<a href="index.php">Inicio</a> <br />

<?php
include("connection.php");

try {
    $conn = new PDO("sqlsrv:server = tcp:eliastorres2.database.windows.net,1433; Database = FinalSeg", "EliasTorres", "Contraseña00$");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión establecida correctamente.<br/>";
} catch (PDOException $e) {
    echo "Error conectando a SQL Server: " . $e->getMessage();
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['Nombre'];
    $email = $_POST['Correo'];
    $pName = $_POST['ApellidoPat'];
    $mName = $_POST['ApellidoMat'];
    $pass = $_POST['Password'];

    if ($pass == "" || $name == "" || $email == "" || $mName == "" || $pName == "") {
        echo "Todos los campos deben ser llenados. ";
        echo "<br/>";
        echo "<a href='register.php'>Regresar</a>";
    } else {
        $query = "INSERT INTO login(Nombre, ApellidoMat, ApellidoPat, Correo, Password) VALUES('$name', '$pName','$mName', '$email', '$pass')";
        
        try {
            $result = $conn->query($query);
        } catch (PDOException $e) {
            die('Error en la consulta: ' . $e->getMessage());
        }

        echo "Registro completo";
        echo "<br/>";
        echo "<a href='login.php'>Iniciar Sesión</a>";
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
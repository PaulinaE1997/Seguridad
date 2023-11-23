<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>

<html>
<head>
    <title>Agregar Datos</title>
</head>

<body>
<?php
// Incluye el archivo de conexión a la base de datos
include_once("connection.php");

if (isset($_POST['Submit'])) {
    // Procesar la imagen
    $imagen = $_FILES['Imagen']['name'];
    $tempName = $_FILES['Imagen']['tmp_name'];
    $imgPath = "uploads/" . $imagen;

    move_uploaded_file($tempName, $imgPath);

    // Obtener datos del formulario
    $NombreProyecto = $_POST['NombreProyecto'];
    $Descripcion = $_POST['Descripcion'];
    $Departamento = $_POST['Departamento'];
    $Fecha = $_POST['Fecha'];

    // Verifica campos vacíos
    if (empty($imagen) || empty($NombreProyecto) || empty($Descripcion) || empty($Departamento) || empty($Fecha)) {

        if (empty($imagen)) {
            echo "<font color='red'>El campo Imagen está vacío.</font><br/>";
        }

        if (empty($NombreProyecto)) {
            echo "<font color='red'>El campo Nombre del proyecto está vacío.</font><br/>";
        }

        if (empty($Descripcion)) {
            echo "<font color='red'>El campo Descripción está vacío.</font><br/>";
        }
        if (empty($Departamento)) {
            echo "<font color='red'>El campo Departamento está vacío.</font><br/>";
        }
        if (empty($Fecha)) {
            echo "<font color='red'>El campo Fecha está vacío.</font><br/>";
        }
        // Vincula a la página anterior
        echo "<br/><a href='javascript:self.history.back();'>Regresar</a>";
    } else {
        // Si todos los campos están llenos (no vacíos)

        // Inserta datos en la base de datos
        $query = "INSERT INTO Proyectos(Imagen, NombreProyecto, Descripcion, Departamento, Fecha) VALUES(?, ?, ?, ?, ?)";
        $params = array($imgPath, $NombreProyecto, $Descripcion, $Departamento, $Fecha);

        $result = sqlsrv_query($conn, $query, $params);

        // Muestra mensaje de éxito
        echo "<font color='green'>Datos agregados exitosamente.";
        echo "<br/><a href='view.php'>Ver Resultados</a>";
    }
}
?>
</body>
</html>

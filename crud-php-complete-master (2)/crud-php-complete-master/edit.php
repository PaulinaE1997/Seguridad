<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// incluyendo el archivo de conexión a la base de datos
include_once("connection.php");

if(isset($_POST['update']))
{	
	// verificando si $_POST['ID'] está definido antes de asignarlo
	$ID = isset($_POST['ID']) ? $_POST['ID'] : null;

	$NombreProyecto = $_POST['NombreProyecto'];
    $Descripcion = $_POST['Descripcion'];
    $Departamento = $_POST['Departamento'];
    $Fecha = $_POST['Fecha'];
	
	// verificando campos vacíos
	if(empty($Imagen) || empty($NombreProyecto) || empty($Descripcion) || empty($Departamento) || empty($Fecha)) {
        // código de validación y mensajes de error...
	} else {	
		// actualizando la tabla
		$params = array($NombreProyecto, $Descripcion, $Departamento, $Fecha, $ID);
		$result = sqlsrv_query($conn, "UPDATE Proyectos SET NombreProyecto=?, Descripcion=?, Departamento=?, Fecha=? WHERE ID=?", $params);
		
		// redirigiendo a la página de visualización. En nuestro caso, es view.php
		header("Location: view.php");
	}

	
}
?>
<?php
// obteniendo el id desde la URL
$ID = isset($_GET['ID']) ? $_GET['ID'] : null;

// seleccionando datos asociados a este id particular
$params = array($ID);
$result = sqlsrv_query($conn, "SELECT * FROM Proyectos WHERE ID=?", $params);

while($res = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{
	$Imagen = $res['Imagen'];
	$NombreProyecto = $res['NombreProyecto'];
	$Descripcion = $res['Descripcion'];
	$Departamento = $res['Departamento'];
	$Fecha = $res['Fecha'];
}
?>
<html>
<head>	
	<title>Editar Datos</title>
</head>

<body>
	<a href="index.php">Inicio</a> | <a href="view.php">Ver Proyectos</a> | <a href="logout.php">Cerrar Sesión</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
		<tr> 
                <td>Imagen</td>
                <td><input type="file" name="Imagen"></td>
            </tr>
            <tr> 
                <td>Nombre del proyecto</td>
                <td><input type="text" name="NombreProyecto" value="<?php echo $NombreProyecto; ?>"></td>
            </tr>
            <tr> 
                <td>Descripción</td>
                <td><input type="text" name="Descripcion" value="<?php echo $Descripcion; ?>"></td>
            </tr>
            <tr> 
                <td>Departamento</td>
                <td><input type="text" name="Departamento" value="<?php echo $Departamento; ?>"></td>
            </tr>
            <tr> 
                <td>Fecha</td>
                <td><input type="date" name="Fecha" value="<?php echo $Fecha; ?>"></td>
            </tr>
            <tr> 
                <td></td>
                <td>
                    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                    <input type="submit" name="update" value="Actualizar">
                </td>
            </tr>
		</table>
	</form>
</body>
</html>

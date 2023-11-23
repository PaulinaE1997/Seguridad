<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>

<?php
// Incluye el archivo de conexión a la base de datos
include_once("connection.php");

// Recupera datos en orden descendente (última entrada primero)
$result = sqlsrv_query($conn, "SELECT * FROM Proyectos");

?>

<html>
<head>
    <title>Inicio</title>
</head>

<body>
    <a href="index.php">Inicio</a> | <a href="add.html">Agregar Nuevo</a> | <a href="logout.php">Cerrar Sesión</a>
    <br/><br/>

    <table width='80%' border=0>
        <tr bgcolor='#CCCCCC'>
			<td>ID</td>
            <td>Imagen</td>
            <td>Nombre del Proyecto</td>
            <td>Descripción</td>
            <td>Departamento</td>
            <td>Fecha</td>
        </tr>
        <?php
        while ($res = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            // Mostrar la imagen en miniatura
            echo "<td><img src='{$res['Imagen']}' width='50' height='50'></td>";
            echo "<td>" . $res['NombreProyecto'] . "</td>";
            echo "<td>" . $res['Descripcion'] . "</td>";
            echo "<td>" . $res['Departamento'] . "</td>";

            // Check if the "Fecha" key exists in the array before using it
            $formattedDate = isset($res['Fecha']) ? $res['Fecha']->format('Y-m-d H:i:s') : 'N/A';
            echo "<td>" . $formattedDate . "</td>";

            // Check if the "id" key exists in the array before using it
            $editLink = isset($res['ID']) ? "edit.php?ID={$res['ID']}" : '#';
            $deleteLink = isset($res['ID']) ? "delete.php?ID={$res['ID']}" : '#';

            echo "<td><a href=\"$editLink\">Editar</a> | <a href=\"$deleteLink\" onClick=\"return confirm('¿Estás seguro de que quieres eliminar?')\">Eliminar</a></td>";
        }
        ?>
    </table>
</body>
</html>

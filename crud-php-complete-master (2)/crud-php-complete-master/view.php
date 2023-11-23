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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
            background-color: #f8d7da; /* Fondo rosita */
            padding: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
        }

        a {
            color: #dc3545; /* Rojo oscuro */
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <a href="index.php">Inicio</a> | <a href="add.html">Agregar Nuevo</a> | <a href="logout.php">Cerrar Sesión</a>
    <br/><br/>

    <table>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre del Proyecto</th>
            <th>Descripción</th>
            <th>Departamento</th>
            <th>Fecha</th>
            <th>Acciones</th> <!-- Agregada una columna para acciones -->
        </tr>

        <?php
        while ($res = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            // Mostrar la imagen en miniatura

            echo "<td>" . $res['ID'] . "</td>";
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

            // Usar iconos de Bootstrap en lugar de texto
            echo "<td>
                    <a href=\"$editLink\" class=\"btn btn-warning\"><i class=\"bi bi-pencil\"></i></a>
                    <a href=\"$deleteLink\" class=\"btn btn-danger\" onClick=\"return confirm('¿Estás seguro de que quieres eliminar?')\"><i class=\"bi bi-trash\"></i></a>
                  </td>";
        }
        ?>
    </table>

    <!-- Incluir script de Bootstrap para los iconos -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Proyecto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sans-Serif';
            background-color: #f8d7da; /* Fondo rosita */
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff; /* Fondo blanco */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .btn-danger {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="index.php" class="btn btn-secondary">Inicio</a> <br />

        <?php
        session_start();

        if (!isset($_SESSION['valid'])) {
            header('Location: login.php');
        }

        // Incluyendo el archivo de conexión a la base de datos
        include("connection.php");

        // Obteniendo el ID de los datos desde la URL
        $ID = $_GET['ID'];

        // Preparando la consulta para eliminar el registro
        $query = "DELETE FROM Proyectos WHERE ID = ?";
        $params = array($ID);
        $result = sqlsrv_query($conn, $query, $params);

        // Verificando si la eliminación fue exitosa
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo '<div class="alert alert-success mt-3" role="alert">';
        echo 'Proyecto eliminado exitosamente.';
        echo '</div>';

        // Redirigiendo a la página de visualización (view.php en este caso)
        ?>
        <a href="view.php" class="btn btn-danger">Volver a la Vista de Proyectos</a>
    </div>
</body>
</html>
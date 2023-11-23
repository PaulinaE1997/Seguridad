<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Datos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
            background-color: #f8d7da; /* Fondo rosita */
            padding: 20px;
        }

        #form-container {
            max-width: 600px;
            margin: auto;
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>

<body>
    <div id="form-container">
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
                echo "<font color='red'>Por favor, complete todos los campos.</font><br/>";

                // Vincula a la página anterior
                echo "<br/><a href='javascript:self.history.back();'>Regresar</a>";
            } else {
                // Si todos los campos están llenos (no vacíos)

                // Inserta datos en la base de datos
                $query = "INSERT INTO Proyectos(Imagen, NombreProyecto, Descripcion, Departamento, Fecha) VALUES(?, ?, ?, ?, ?)";
                $params = array($imgPath, $NombreProyecto, $Descripcion, $Departamento, $Fecha);

                $result = sqlsrv_query($conn, $query, $params);
                if ($result === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                
                // Muestra mensaje de éxito
                echo "<font color='green'>Datos agregados exitosamente.";
                echo "<br/><a href='view.php' class='btn btn-primary'>Ver Resultados</a>";
            }
        }
        ?>
    </div>
</body>
</html>

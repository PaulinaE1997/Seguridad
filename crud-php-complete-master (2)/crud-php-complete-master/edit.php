<?php
session_start();
$ID = $NombreProyecto = $Descripcion = $Departamento = $RutaImagen = $Fecha = '';

if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

$ID = isset($_GET['ID']) ? $_GET['ID'] : null;

if (isset($_POST['update'])) {
    $ID = $_POST['ID'];
    $NombreProyecto = $_POST['NombreProyecto'];
    $Descripcion = $_POST['Descripcion'];
    $Departamento = $_POST['Departamento'];
    $newImage = $_FILES['newImage'];

    if (empty($NombreProyecto) || empty($Descripcion) || empty($Departamento)) {
        echo "<font color='red'>NombreProyecto, Descripcion, and Departamento are required.</font><br/>";
    } else {
        if ($newImage['size'] > 0) {
            $imgPath = "uploads/" . $newImage['name'];
            move_uploaded_file($newImage['tmp_name'], $imgPath);

            $sql = "UPDATE Proyectos SET NombreProyecto=?, Descripcion=?, Departamento=?, RutaImagen=?, Fecha=? WHERE ID=?";
            $params = array($NombreProyecto, $Descripcion, $Departamento, $imgPath, $Fecha, $ID);
            $stmt = sqlsrv_prepare($conn, $sql, $params);

            if (!sqlsrv_execute($stmt)) {
                die(print_r(sqlsrv_errors(), true));
            }

            sqlsrv_free_stmt($stmt);

        } else {
            try {
                $sql = "UPDATE Proyectos SET NombreProyecto=?, Descripcion=?, Departamento=?, Fecha=? WHERE ID=?";
                $params = array($NombreProyecto, $Descripcion, $Departamento, $Fecha, $ID);
                $stmt = sqlsrv_prepare($conn, $sql, $params);

                if (!sqlsrv_execute($stmt)) {
                    die(print_r(sqlsrv_errors(), true));
                }

                sqlsrv_free_stmt($stmt);

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        header("Location: view.php");
        exit();
    }
}

if ($ID !== null) {
    $params = array($ID);
    $result = sqlsrv_query($conn, "SELECT * FROM Proyectos WHERE ID=?", $params);

    while ($res = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $NombreProyecto = $res['NombreProyecto'];
        $Descripcion = $res['Descripcion'];
        $Departamento = $res['Departamento'];
        $RutaImagen = $res['RutaImagen'];
        $Fecha = $res['Fecha'];
    }
} else {
    echo "Project ID not specified.";
}
?>
<html>

<head>
    <title>Edit Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
            background-color: #f8d7da;
            padding: 20px;
        }

        a {
            color: #dc3545;
        }

        table {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        input {
            width: 100%;
        }

        .btn-update {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <a href="index.php" class="btn btn-secondary">Home</a> |
    <a href="view.php" class="btn btn-secondary">View Projects</a> |
    <a href="logout.php" class="btn btn-secondary">Logout</a>
    <br /><br />

    <form name="form1" method="post" action="edit.php" enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <td>Nombre del proyecto</td>
                <td><input type="text" name="NombreProyecto" value="<?php echo $NombreProyecto; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Descripción</td>
                <td><input type="text" name="Descripcion" value="<?php echo $Descripcion; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td><input type="text" name="Departamento" value="<?php echo $Departamento; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>New Image</td>
                <td><input type="file" name="newImage" class="form-control-file"></td>
            </tr>

            <tr>
                <td><input type="hidden" name="ID" value=<?php echo $ID; ?>></td>
                <td><input type="submit" name="update" value="Update" class="btn btn-update"></td>
            </tr>
        </table>
    </form>
</body>

</html>

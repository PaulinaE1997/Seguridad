<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

        .btn-submit {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="index.php" class="btn btn-secondary">Inicio</a> <br />

        <?php
        include("connection.php");

        if (isset($_POST['submit'])) {
            $user = $_POST['Correo'];
            $pass = $_POST['Password'];

            if ($user == "" || $pass == "") {
                echo "Alguno de los campos está vacío.";
                echo "<br/>";
                echo "<a href='login.php' class='btn btn-secondary'>Regresa</a>";
            } else {
                // Consulta para obtener el hash de la contraseña
                $query = "SELECT * FROM login WHERE Correo=?";
                $params = array($user);

                $result = sqlsrv_query($conn, $query, $params);

                if ($result) {
                    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                    if ($row) {
                        // Verificar la contraseña hasheada
                        $hashedPassword = $row['Password'];
                        if (password_verify($pass, $hashedPassword)) {
                            $validuser = $row['Correo'];
                            $_SESSION['valid'] = $validuser;

                            if (isset($_SESSION['valid'])) {
                                header('Location: view.php');
                            }
                        } else {
                            echo "Correo o contraseña incorrectos.";
                            echo "<br/>";
                            echo "<a href='login.php' class='btn btn-secondary'>Regresar</a>";
                        }
                    } else {
                        echo "Correo o contraseña incorrectos.";
                        echo "<br/>";
                        echo "<a href='login.php' class='btn btn-secondary'>Regresar</a>";
                    }
                } else {
                    die(print_r(sqlsrv_errors(), true));
                }
            }
        } else {
            ?>
            <p><font size="+2">Inicia Sesión</font></p>
            <form name="form1" method="post" action="">
                <div class="form-group">
                    <label for="Correo">Correo</label>
                    <input type="text" name="Correo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Password">Contraseña</label>
                    <input type="password" name="Password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Iniciar Sesión" class="btn btn-submit">
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html
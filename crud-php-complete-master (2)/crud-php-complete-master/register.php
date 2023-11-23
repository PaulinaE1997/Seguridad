<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
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

        try {
            $conn = new PDO("sqlsrv:server = tcp:eliastorres2.database.windows.net,1433; Database = FinalSeg", "EliasTorres", "Contraseña00$");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           //  echo "Conexión establecida correctamente.<br/>";
        } catch (PDOException $e) {
          //   echo "Error conectando a SQL Server: " . $e->getMessage();
            exit();
        }

        if (isset($_POST['submit'])) {
            $name = $_POST['Nombre'];
            $email = $_POST['Correo'];
            $pName = $_POST['ApellidoPat'];
            $mName = $_POST['ApellidoMat'];
            $pass = $_POST['Password']; // Cambiado el nombre del campo a 'Password'

            // Validaciones adicionales usando expresiones regulares
            $uppercaseRegex = '/[A-Z]/';
            $specialCharRegex = '/[^a-zA-Z0-9]/';

            if (
                $pass == "" ||
                $name == "" ||
                $email == "" ||
                $mName == "" ||
                $pName == "" ||
                !preg_match($uppercaseRegex, $pass) ||
                !preg_match($specialCharRegex, $pass)
            ) {
                echo "Todos los campos deben ser llenados y la contraseña debe contener al menos una mayúscula y un carácter especial.";
                echo "<br/>";
                echo "<a href='register.php' class='btn btn-secondary'>Regresar</a>";
            } else {
                // Aplica hash a la contraseña
                $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

                $query = "INSERT INTO login(Nombre, ApellidoMat, ApellidoPat, Correo, Password) VALUES('$name', '$pName','$mName', '$email', '$hashedPassword')";

                try {
                    $result = $conn->query($query);
                } catch (PDOException $e) {
                    die('Error en la consulta: ' . $e->getMessage());
                }

                echo "Registro completo";
                echo "<br/>";
                echo "<a href='login.php' class='btn btn-success'>Iniciar Sesión</a>";
            }
        } else {
            ?>
            <p><font size="+2">Registrar</font></p>
            <form name="form1" method="post" action="">
                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ApellidoPat">Apellido Paterno</label>
                    <input type="text" name="ApellidoPat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ApellidoMat">Apellido Materno</label>
                    <input type="text" name="ApellidoMat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Correo">Correo Electrónico</label>
                    <input type="text" name="Correo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Password">Contraseña</label>
                    <input type="password" name="Password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Registrar" class="btn btn-submit">
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Sans-Serif', sans-serif; /* Cambiado a Sans Serif */
            background-color: #f8d7da; /* Fondo rosita */
            padding: 20px;
        }

        #header {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
            padding: 10px;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #footer {
            margin-top: 20px;
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
            padding: 10px;
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff; /* Fondo blanco */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-logout {
            background-color: #dc3545; /* Rojo oscuro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="header">
            Gestor de proyectos
        </div>

        <?php
        session_start();

        if (isset($_SESSION['valid'])) {
            include("connection.php");
            $result = sqlsrv_query($conn, "SELECT * FROM login");
        ?>

        <p>
            <?php echo isset($_SESSION['Nombre']) ? '¡Hola, ' . $_SESSION['Nombre'] . '!' : '¡Hola, Usuario!'; ?> |
           
        </p>

        <br/>
        <a href='view.php' class='btn btn-primary'>Ver proyectos</a>
        <br/><br/>

        <?php
        } else {
            echo "Tienes que iniciar sesión para observar esta página.<br/><br/>";
            echo "<a href='login.php' class='btn btn-primary'>Login</a> |
                  <a href='register.php' class='btn btn-secondary'>Regístrate</a>";
        }
        ?>

        <div id="footer">
		<a href='logout.php' class='btn btn-logout'>Salir</a>
        </div>
    </div>
</body>
</html>

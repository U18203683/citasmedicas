<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Citas Médicas</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background: url('img/principal.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        header {
            width: 25%;
            background-color: #0076c8;
            color: white;
            font-size: 30px;
            border-radius: 10px;
            text-align: center;
            padding: 10px 0;
            box-shadow: none;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            background-color: transparent;
            padding: 20px;
            border: none;
            box-shadow: none;
            margin-top: 100px; /* Espacio debajo del encabezado */
        }
        .options {
            display: flex;
            justify-content: space-between;
            margin-top: 1cm;
        }
        .left-column, .right-column {
            flex: 1;
            text-align: center;
            color: #0076c8;
        }
        .right-column {
            color: white;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: transparent;
            color: inherit;
            text-decoration: none;
            border: 2px solid currentColor;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .button:hover {
            background-color: white;
            color: #0076c8;
        }
        .register-link {
            font-size: 14px;
            text-decoration: none;
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: inherit;
        }
        .register-link a {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        Sistema de Gestión de Citas
    </header>
    <div class="container">
        <div class="options">
            <div class="left-column">
                <a href="admin/login.php" class="button">Inicio de sesión (Administrador)</a>
                <div class="register-link">No tiene cuenta, regístrese <a href="admin/registro.php"> aquí</a></div>
            </div>
            <div class="right-column">
                <a href="afiliado/login.php" class="button">Inicio de sesión (Afiliado)</a>
                <div class="register-link">No tiene cuenta, regístrese <a href="afiliado/registro.php"> aquí</a></div>
            </div>
        </div>
    </div>
</body>
</html>

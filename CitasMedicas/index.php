<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Citas Médicas</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #e0f0ff; /* Azul claro */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .options {
            display: flex;
            justify-content: space-between;
        }
        .left-column, .right-column {
            flex: 1;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .register-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Sistema de Gestión de Citas</h1>
        </div>
        <div class="options">
            <div class="left-column">
                <a href="admin/login.php" class="button">Inicio de sesión (Administrador)</a>
                <a href="admin/registro.php" class="register-link">No tiene cuenta, regístrese aquí</a>
            </div>
            <div class="right-column">
                <a href="afiliado/login.php" class="button">Inicio de sesión (Afiliado)</a>
                <a href="afiliado/registro.php" class="register-link">No tiene cuenta, regístrese aquí</a>
            </div>
        </div>
    </div>
</body>
</html>

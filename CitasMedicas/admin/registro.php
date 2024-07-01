<?php
// Incluir la conexión a la base de datos
include_once '../includes/db_connection.php';

// Variables para almacenar mensajes
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    // Validar que las contraseñas coincidan
    if ($password != $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Consultar si el correo electrónico ya existe en la base de datos
        $query = "SELECT * FROM Administradores WHERE Email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $error = "Usuario ya existe.";
        } else {
            // Insertar el nuevo administrador en la base de datos
            $password_hash = password_hash($password, PASSWORD_BCRYPT); // Encriptar la contraseña
            $insert_query = "INSERT INTO Administradores (Nombre, Apellido, Email, Contraseña) VALUES ('$nombre', '$apellido', '$email', '$password_hash')";

            if ($conn->query($insert_query) === TRUE) {
                $success = "Su cuenta ha sido creada, ingrese con sus credenciales.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <link rel="stylesheet" href="../css/styles.css">
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
            max-width: 400px;
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 100%;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Registro de Administrador</h1>
        </div>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
            <a href="login.php" class="button">Iniciar Sesión</a>
        <?php else: ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="button">Registrar</button>
                <a href="../index.php" class="button">Cancelar</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

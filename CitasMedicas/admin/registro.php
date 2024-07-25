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
            background-image: url('../img/registro.png');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white; /* Color de todos los textos */
        }
        .container {
            width: 100%;
            max-width: 1200px;
            background-color: transparent;
            padding: none;
            border-radius: none;
            box-shadow: none;
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
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1.5px solid white; /* Color de los bordes de los inputs */
            border-radius: 5px;
            background: transparent;
            color: white; /* Color del texto dentro de los inputs */
        }
        .button {
            padding: 10px 50px;
            background-color: white;
            color: #0076c8;
            border: 1.5px solid white;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0076c8;
            color: white;
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
        table {
            width: 100%;
            height: 100%;
            table-layout: fixed;
        }
        td {
            vertical-align: top;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <div class="content">
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
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php
// Incluir la conexión a la base de datos
include_once '../includes/db_connection.php';

// Variables para almacenar mensajes
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Consultar en la base de datos si el correo y la contraseña son correctos
    $query = "SELECT * FROM Administradores WHERE Email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Contraseña'])) {
            // Inicio de sesión exitoso, redireccionar a la interfaz del administrador
            header("Location: index_admin.php");
            exit();
        } else {
            $error = "Correo o contraseña incorrecta.";
        }
    } else {
        $error = "Correo o contraseña incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Administrador</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Iniciar Sesión - Administrador</h1>
        </div>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Iniciar Sesión</button>
            <a href="recuperar_clave.php" class="button">Recuperar Clave</a>
            <a href="../index.php" class="button">Cancelar</a>
        </form>
    </div>
</body>
</html>

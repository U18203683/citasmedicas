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
    <title>Login Administrador</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background: url('../img/inicio_sesion.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            display: flex;
            width: 100%;
            background: transparent;
            box-shadow: none;
        }
        .left-side, .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
            background: transparent;
        }
        .login-box h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: white;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 2px solid white;
            border-radius: 10px;
            background: transparent;
            color: white;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 80px;
            background-color: white;
            color: #007BFF;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #dcdcdc;
        }
        .login-box a {
            color: 007BFF;
            text-decoration: none;
        }
        .login-box b {
            color: 007BFF;
            text-decoration: none;
        }
        .login-box b:hover {
            text-decoration: underline;
        }
        .login-box p {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="login-box">
                <h2>Login Administrador</h2>
                <p>Inicie sesión para continuar</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="email">email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn">Login</button>
                        <a href="../index.php" class="btn">Cancelar</a>
                    </div>
                </form>
                <p>Olvidó su contraseña, haga clic <a href="recuperar_clave.php">aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html>

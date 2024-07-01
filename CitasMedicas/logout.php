<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Función para limpiar y destruir la sesión
function logout() {
    // Limpiar todas las variables de sesión
    $_SESSION = array();

    // Destruir la sesión
    session_destroy();
}

// Verificar el tipo de usuario que está cerrando sesión
if (isset($_SESSION['admin_id'])) {
    // Administrador
    logout();
    $message = "Se ha cerrado sesión correctamente como administrador.";
    $redirect = "../index.php"; // Redireccionar a la página principal
} elseif (isset($_SESSION['afiliado_id'])) {
    // Afiliado
    logout();
    $message = "Se ha cerrado sesión correctamente como afiliado.";
    $redirect = "../index.php"; // Redireccionar a la página principal
} else {
    // No se identificó ningún tipo de sesión válida, redireccionar a la página principal
    $redirect = "../index.php";
    header("Location: $redirect");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background-color: #f0f0f0; /* Fondo gris claro */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Azul */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <?php echo $message; ?>
        </div>
        <a href="<?php echo $redirect; ?>" class="button">Volver a la Página Principal</a>
    </div>
</body>
</html>

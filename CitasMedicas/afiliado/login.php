<?php
session_start();
include_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = $_POST['dni'];

    // Verificar el DNI en la base de datos
    $query = "SELECT AfiliadoID, Nombre, Apellidos FROM Afiliados WHERE DNI = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Afiliado encontrado
        $afiliado = $result->fetch_assoc();
        $_SESSION['afiliado_id'] = $afiliado['AfiliadoID'];
        $_SESSION['afiliado_nombre'] = $afiliado['Nombre'] . ' ' . $afiliado['Apellidos'];
        header("Location: index_afiliado.php");
    } else {
        $message = "Usuario incorrecto o no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Afiliado</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background: url('../img/inicio_sesion2.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            display: flex;
            width: 100%;
            background: transparent;
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
            margin-bottom: 5px;
            color: white;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid white;
            border-radius: 5px;
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
            padding: 10px 20px;
            background-color: white;
            color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #dcdcdc;
        }
        .message {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="login-box">
                <h2>Inicio de Sesión - Afiliado</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="number" id="dni" name="dni" maxlength="8" inputmode="number" pattern="[0-9]*" /> 
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn">Iniciar Sesión</button>
                        <a href="../index.php" class="btn">Cancelar</a>
                    </div>
                </form>
                <?php if (isset($message)) : ?>
                    <div class="message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

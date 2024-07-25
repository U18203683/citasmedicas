<?php
// Incluir la conexión a la base de datos
include_once '../includes/db_connection.php';

// Variables para almacenar mensajes
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $dni = $conn->real_escape_string($_POST['dni']);

    // Validar el campo DNI
    if (!preg_match('/^[0-9]{8}$/', $dni)) {
        $error = "El DNI debe ser un número de 8 dígitos.";
    } else {
        // Consultar si el DNI ya existe en la base de datos
        $query = "SELECT * FROM Afiliados WHERE DNI = '$dni'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $error = "Usuario ya existe.";
        } else {
            // Insertar el nuevo afiliado en la base de datos
            $insert_query = "INSERT INTO Afiliados (Nombre, Apellidos, DNI) VALUES ('$nombre', '$apellidos', '$dni')";

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
    <title>Registro de Afiliado</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background: url('../img/registro.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white; /* Color de los textos */
        }
        .container {
            width: 80%;
            max-width: 900px;
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
            margin-bottom: 5px;
            color: white; /* Color de los textos */
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1.5px solid white; /* Color del borde */
            background: transparent;
            color: white; /* Color del texto del input */
        }
        .button {
            padding: 10px 40px;
            background-color: white;
            color: #0076c8;
            border: 1.5px solid white;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0076c8;
            border: 1.5px solid white;
            color:white;
        }
        .error, .success {
            color: white;
            margin-bottom: 15px;
            text-align: center;
        }
        .table-container {
            width: 80%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
        td:last-child {
            width: 400px; /* Asegura que la tercera columna tenga suficiente espacio */
        }
    </style>
</head>
<body>
    <div class="table-container">
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <div class="container">
                        <div class="title">
                            <h1>Registro de Afiliado</h1>
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
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" id="apellidos" name="apellidos" required>
                                </div>
                                <div class="form-group">
                                    <label for="dni">DNI</label>
                                    <input type="text" id="dni" name="dni" required pattern="\d{8}" title="El DNI debe ser un número de 8 dígitos">
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

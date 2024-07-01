<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Obtener ID del afiliado desde la URL
$afiliado_id = $_GET['id'];

// Obtener datos del afiliado
$query_afiliado = "SELECT * FROM Afiliados WHERE AfiliadoID = $afiliado_id";
$result_afiliado = $conn->query($query_afiliado);

if ($result_afiliado->num_rows > 0) {
    $afiliado = $result_afiliado->fetch_assoc();
} else {
    echo "<script>alert('Afiliado no encontrado.'); window.location.href='lista_afiliados.php';</script>";
    exit();
}

// Procesamiento del formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y limpiar datos ingresados
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $dni = htmlspecialchars(trim($_POST['dni']));

    // Verificar si el DNI ya existe en la base de datos para otro afiliado
    $query_check_dni = "SELECT * FROM Afiliados WHERE DNI = '$dni' AND AfiliadoID != $afiliado_id";
    $result_check_dni = $conn->query($query_check_dni);

    if ($result_check_dni->num_rows > 0) {
        $error = "El número de DNI '$dni' ya está registrado.";
    } else {
        // Actualizar datos del afiliado
        $query_update_afiliado = "UPDATE Afiliados 
                                  SET Nombre = '$nombre', Apellidos = '$apellidos', DNI = '$dni' 
                                  WHERE AfiliadoID = $afiliado_id";

        if ($conn->query($query_update_afiliado) === TRUE) {
            echo "<script>alert('Afiliado actualizado correctamente.'); window.location.href='lista_afiliados.php';</script>";
        } else {
            $error = "Error al actualizar el afiliado: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Afiliado</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background-color: #f0f0f0; /* Fondo gris claro */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff; /* Azul */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
        .error {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Afiliado</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$afiliado_id"; ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $afiliado['Nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $afiliado['Apellidos']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?php echo $afiliado['DNI']; ?>" pattern="\d{8}" title="El DNI debe contener 8 dígitos" required>
            </div>
            <div class="btn-container">
                <button type="submit" name="submit" class="btn">Guardar Cambios</button>
                <a href="lista_afiliados.php" class="btn">Cancelar</a>
            </div>
        </form>
        <?php if (!empty($error)) : ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

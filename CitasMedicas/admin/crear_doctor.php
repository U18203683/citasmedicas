<?php
// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y limpiar datos ingresados
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad_id = $_POST['especialidad'];

    // Insertar doctor en la base de datos
    $query_insert_doctor = "INSERT INTO Doctores (Nombre, Apellido, EspecialidadID)
                            VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($query_insert_doctor)) {
        $stmt->bind_param("ssi", $nombre, $apellido, $especialidad_id);
        if ($stmt->execute()) {
            $message = "Doctor agregado correctamente.";
        } else {
            $message = "Error al agregar el doctor: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error al preparar la consulta: " . $conn->error;
    }
}

// Consultar especialidades disponibles
$query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
$result_especialidades = $conn->query($query_especialidades);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Doctor</title>
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
        .form-group input, .form-group select {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Agregar Doctor</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="especialidad">Especialidad:</label>
                <select id="especialidad" name="especialidad" required>
                    <option value="">Seleccionar Especialidad</option>
                    <?php
                    while ($row_especialidad = $result_especialidades->fetch_assoc()) {
                        echo '<option value="' . $row_especialidad['EspecialidadID'] . '">' . $row_especialidad['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Agregar</button>
                <a href="lista_doctor.php" class="btn">Cancelar</a>
            </div>
        </form>
        <?php if (isset($message)) : ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>

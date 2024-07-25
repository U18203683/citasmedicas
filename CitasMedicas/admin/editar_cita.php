<?php
include_once '../includes/db_connection.php';

// Verificar si se recibió un ID válido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cita_id = $_GET['id'];

    // Obtener la información actual de la cita
    $query_cita = "SELECT c.FechaHora, c.EspecialidadID, c.DoctorID, e.Nombre AS NombreEspecialidad, d.Nombre AS NombreDoctor, d.Apellido AS ApellidoDoctor
                   FROM Citas c
                   INNER JOIN Especialidades e ON c.EspecialidadID = e.EspecialidadID
                   INNER JOIN Doctores d ON c.DoctorID = d.DoctorID
                   WHERE CitaID = ?";
    $stmt = $conn->prepare($query_cita);
    $stmt->bind_param("i", $cita_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fecha_actual = $row['FechaHora'];
        $especialidad_id_actual = $row['EspecialidadID'];
        $doctor_id_actual = $row['DoctorID'];
        $nombre_especialidad_actual = $row['NombreEspecialidad'];
        $nombre_doctor_actual = $row['NombreDoctor'];
        $apellido_doctor_actual = $row['ApellidoDoctor'];
    } else {
        die("La cita no existe.");
    }

    // Consultar especialidades disponibles
    $query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
    $result_especialidades = $conn->query($query_especialidades);

    // Consultar doctores disponibles según la especialidad actual
    $query_doctores = "SELECT DoctorID, Nombre, Apellido FROM Doctores WHERE EspecialidadID = ?";
    $stmt_doctores = $conn->prepare($query_doctores);
    $stmt_doctores->bind_param("i", $especialidad_id_actual);
    $stmt_doctores->execute();
    $result_doctores = $stmt_doctores->get_result();
} else {
    die("ID de cita no válido");
}

// Procesamiento del formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y limpiar datos ingresados
    $fecha = $_POST['fecha'];
    $especialidad_id = $_POST['especialidad'];
    $doctor_id = $_POST['doctor'];

    // Actualizar la cita en la base de datos
    $query_update_cita = "UPDATE Citas SET FechaHora = ?, EspecialidadID = ?, DoctorID = ? WHERE CitaID = ?";
    $stmt_update = $conn->prepare($query_update_cita);
    $stmt_update->bind_param("siii", $fecha, $especialidad_id, $doctor_id, $cita_id);

    if ($stmt_update->execute()) {
        $message = "Cita actualizada correctamente.";
    } else {
        $message = "Error al actualizar la cita: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2.5cm 0 0 0;
            background: url('../img/secundaria.png') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #0076c8; /* Color de los textos */
        }
        .form-group select, .form-group input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #0076c8; /* Color de los bordes */
            border-radius: 5px;
            color: #0076c8; /* Color del texto */
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
            color: #0076c8; /* Color del mensaje */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #0076c8;">Editar Cita</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $cita_id; ?>" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $fecha_actual; ?>" required>
            </div>
            <div class="form-group">
                <label for="especialidad">Especialidad:</label>
                <select id="especialidad" name="especialidad" required>
                    <option value="<?php echo $especialidad_id_actual; ?>"><?php echo $nombre_especialidad_actual; ?></option>
                    <?php
                    while ($row_especialidad = $result_especialidades->fetch_assoc()) {
                        if ($row_especialidad['EspecialidadID'] != $especialidad_id_actual) {
                            echo '<option value="' . $row_especialidad['EspecialidadID'] . '">' . $row_especialidad['Nombre'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="doctor">Doctor:</label>
                <select id="doctor" name="doctor" required>
                    <option value="<?php echo $doctor_id_actual; ?>"><?php echo $nombre_doctor_actual . ' ' . $apellido_doctor_actual; ?></option>
                    <?php
                    while ($row_doctor = $result_doctores->fetch_assoc()) {
                        echo '<option value="' . $row_doctor['DoctorID'] . '">' . $row_doctor['Nombre'] . ' ' . $row_doctor['Apellido'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Guardar Cambios</button>
                <a href="lista_citas.php" class="btn">Regresar</a>
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
// Cerrar la conexión y liberar recursos
if (isset($stmt)) {
    $stmt->close();
}
if (isset($stmt_update)) {
    $stmt_update->close();
}
$conn->close();
?>

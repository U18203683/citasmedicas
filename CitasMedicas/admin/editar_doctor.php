<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Verificar si se recibió el parámetro del ID del doctor a editar
if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Obtener los datos del doctor a partir de su ID
    $query_doctor = "SELECT * FROM Doctores WHERE DoctorID = $doctor_id";
    $result_doctor = $conn->query($query_doctor);

    if ($result_doctor->num_rows == 1) {
        $doctor = $result_doctor->fetch_assoc();
    } else {
        // Si no se encuentra el doctor, redirigir a la lista de doctores
        echo "<script>alert('Doctor no encontrado.'); window.location.href='lista_doctor.php';</script>";
    }
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidadID = $_POST['especialidad'];

    // Actualizar los datos del doctor en la base de datos
    $query_update = "UPDATE Doctores SET Nombre = '$nombre', Apellido = '$apellido', EspecialidadID = $especialidadID 
                     WHERE DoctorID = $doctor_id";

    if ($conn->query($query_update) === TRUE) {
        echo "<script>alert('Doctor actualizado correctamente.'); window.location.href='lista_doctor.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el doctor: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Doctor</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2.5cm 0 0 0;
            background-image: url('../img/secundaria.png');
            background-size: cover;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, label, input, select {
            color: #0076c8; /* Color del texto */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            border-color: #0076c8; /* Color del borde del label */
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #0076c8; /* Color del borde de los inputs */
            border-radius: 4px;
        }
        .btn-container {
            text-align: right;
        }
        .btn {
            padding: 8px 15px;
            background-color: #0076c8; /* Azul */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        .btn:hover {
            background-color: white; /* Blanco */
        }
        .btn-cancel {
            background-color: #dc3545; /* Rojo */
        }
        .btn-cancel:hover {
            background-color: #c82333; /* Rojo más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Doctor</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $doctor['Nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $doctor['Apellido']; ?>" required>
            </div>
            <div class="form-group">
                <label for="especialidad">Especialidad:</label>
                <select id="especialidad" name="especialidad" required>
                    <?php
                    // Obtener lista de especialidades para la lista desplegable
                    $query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
                    $result_especialidades = $conn->query($query_especialidades);

                    if ($result_especialidades->num_rows > 0) {
                        while ($row = $result_especialidades->fetch_assoc()) {
                            $selected = ($row['EspecialidadID'] == $doctor['EspecialidadID']) ? 'selected' : '';
                            echo "<option value='" . $row['EspecialidadID'] . "' $selected>" . $row['Nombre'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn" name="submit">Guardar Cambios</button>
                <a href="lista_doctor.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

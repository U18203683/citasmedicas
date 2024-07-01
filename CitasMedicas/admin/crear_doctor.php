<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $hospital = $_POST['hospital'];

    // Insertar nuevo doctor en la base de datos
    $query_insert = "INSERT INTO Doctores (Nombre, Apellido, Especialidad, HospitalID) VALUES ('$nombre', '$apellido', '$especialidad', $hospital)";

    if ($conn->query($query_insert) === TRUE) {
        echo "<script>alert('Doctor creado correctamente.'); window.location.href='lista_doctor.php';</script>";
    } else {
        echo "<script>alert('Error al crear el doctor: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Doctor</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Estilos adicionales según necesidad */
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Nuevo Doctor</h2>
        <form action="" method="POST">
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
                    <!-- Aquí se generan dinámicamente las opciones de especialidades desde la base de datos -->
                    <?php
                    $query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
                    $result_especialidades = $conn->query($query_especialidades);

                    if ($result_especialidades->num_rows > 0) {
                        while ($row = $result_especialidades->fetch_assoc()) {
                            echo "<option value='" . $row['EspecialidadID'] . "'>" . $row['Nombre'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hospital">Hospital:</label>
                <select id="hospital" name="hospital" required>
                    <option value="">Seleccionar Hospital</option>
                    <!-- Aquí se generan dinámicamente las opciones de hospitales desde la base de datos -->
                    <?php
                    $query_hospitales = "SELECT HospitalID, Nombre FROM Hospitales";
                    $result_hospitales = $conn->query($query_hospitales);

                    if ($result_hospitales->num_rows > 0) {
                        while ($row = $result_hospitales->fetch_assoc()) {
                            echo "<option value='" . $row['HospitalID'] . "'>" . $row['Nombre'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary" name="submit">Crear Doctor</button>
                <a href="lista_doctor.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

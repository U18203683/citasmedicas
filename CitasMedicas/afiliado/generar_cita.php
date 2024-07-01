<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si el afiliado está autenticado
// Aquí puedes implementar tu lógica de autenticación, como comprobar la sesión, cookies, etc.
// Por simplicidad, aquí asumimos que ya se ha realizado la autenticación.

// Ejemplo de autenticación básica:
// Suponemos que $afiliado_id contiene el ID del afiliado autenticado
$afiliado_id = 1; // Este valor debe ser obtenido de tu sistema de autenticación

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Consultar hospitales disponibles
$query_hospitales = "SELECT HospitalID, Nombre FROM Hospitales";
$result_hospitales = $conn->query($query_hospitales);

// Consultar especialidades disponibles
$query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
$result_especialidades = $conn->query($query_especialidades);

// Consultar doctores disponibles
$query_doctores = "SELECT DoctorID, Nombre, Apellido FROM Doctores";
$result_doctores = $conn->query($query_doctores);

// Procesamiento del formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y limpiar datos ingresados
    $fecha = $_POST['fecha'];
    $hospital_id = $_POST['hospital'];
    $especialidad_id = $_POST['especialidad'];
    $doctor_id = $_POST['doctor'];

    // Insertar cita en la base de datos
    $query_insert_cita = "INSERT INTO Citas (AfiliadoID, DoctorID, EspecialidadID, Estado, FechaHora)
                          VALUES ($afiliado_id, $doctor_id, $especialidad_id, 'Registrada', '$fecha')";

    if ($conn->query($query_insert_cita) === TRUE) {
        $message = "Cita generada correctamente.";
    } else {
        $message = "Error al generar la cita: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cita</title>
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
        .form-group select, .form-group input[type="date"] {
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
        <h2>Generar Cita</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="hospital">Hospital:</label>
                <select id="hospital" name="hospital" required>
                    <option value="">Seleccionar Hospital</option>
                    <?php
                    while ($row_hospital = $result_hospitales->fetch_assoc()) {
                        echo '<option value="' . $row_hospital['HospitalID'] . '">' . $row_hospital['Nombre'] . '</option>';
                    }
                    ?>
                </select>
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
            <div class="form-group">
                <label for="doctor">Doctor:</label>
                <select id="doctor" name="doctor" required>
                    <option value="">Seleccionar Doctor</option>
                    <?php
                    while ($row_doctor = $result_doctores->fetch_assoc()) {
                        echo '<option value="' . $row_doctor['DoctorID'] . '">' . $row_doctor['Nombre'] . ' ' . $row_doctor['Apellido'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" name="submit" class="btn">Generar</button>
                <a href="index_afiliado.php" class="btn">Cancelar</a>
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

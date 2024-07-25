<?php
// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Verificar si el afiliado está autenticado
session_start();
if (!isset($_SESSION['afiliado_id'])) {
    header("Location: login_afiliado.php");
    exit();
}

// Obtener el ID del afiliado autenticado
$afiliado_id = $_SESSION['afiliado_id'];

// Consultar especialidades disponibles
$query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
$result_especialidades = $conn->query($query_especialidades);

// Procesamiento del formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y limpiar datos ingresados
    $fecha = $_POST['fecha'];
    $especialidad_id = $_POST['especialidad'];
    $doctor_id = $_POST['doctor'];

    // Insertar cita en la base de datos
    $query_insert_cita = "INSERT INTO Citas (AfiliadoID, DoctorID, EspecialidadID, Estado, FechaHora)
                          VALUES (?, ?, ?, 'Registrada', ?)";
    
    $stmt = $conn->prepare($query_insert_cita);
    $stmt->bind_param("iiis", $afiliado_id, $doctor_id, $especialidad_id, $fecha);
    
    if ($stmt->execute()) {
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
            background: url('../img/secundaria.png') no-repeat center top fixed;
            background-size: cover;
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
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #0076c8; /* Color de texto para etiquetas */
        }
        .form-group select, .form-group input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #0076c8; /* Borde de input */
            border-radius: 5px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #0076c8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: #0076c8; /* Color de texto para mensaje */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("especialidad").addEventListener("change", function() {
                var especialidadID = this.value;
                var doctorSelect = document.getElementById("doctor");

                if (especialidadID) {
                    fetch('get_doctores.php?especialidad_id=' + especialidadID)
                        .then(response => response.json())
                        .then(data => {
                            doctorSelect.innerHTML = '<option value="">Seleccionar Doctor</option>';
                            data.forEach(doctor => {
                                var option = document.createElement('option');
                                option.value = doctor.DoctorID;
                                option.textContent = doctor.Nombre + ' ' + doctor.Apellido;
                                doctorSelect.appendChild(option);
                            });
                        });
                } else {
                    doctorSelect.innerHTML = '<option value="">Seleccionar Doctor</option>';
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2 style="color: #0076c8;">Generar Cita</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
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

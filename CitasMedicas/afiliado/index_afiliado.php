<?php
session_start();
include_once '../includes/db_connection.php';

// Verificar si el afiliado está autenticado
if (!isset($_SESSION['afiliado_id'])) {
    header("Location: login_afiliado.php");
    exit();
}

// Obtener el ID del afiliado autenticado
$afiliado_id = $_SESSION['afiliado_id'];

// Consultar citas del afiliado autenticado
$query_citas = "
    SELECT c.FechaHora, d.Nombre AS DoctorNombre, d.Apellido AS DoctorApellido, 
           e.Nombre AS EspecialidadNombre, c.Estado
    FROM Citas c
    JOIN Doctores d ON c.DoctorID = d.DoctorID
    JOIN Especialidades e ON c.EspecialidadID = e.EspecialidadID
    WHERE c.AfiliadoID = ?
    ORDER BY c.FechaHora DESC";

$stmt = $conn->prepare($query_citas);
$stmt->bind_param("i", $afiliado_id);
$stmt->execute();
$result_citas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Afiliado</title>
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
            width: 80%;
            margin: 2.5cm auto 20px auto; /* 2.5cm de espacio arriba */
            padding: 40px;
            border-radius: 8px;
            box-shadow: none;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco semi-transparente */
            color: #0076c8; /* Color de texto */
        }
        h2, h3 {
            text-align: center;
            color: #0076c8; /* Color de texto */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #0076c8; /* Borde azul */
        }
        th, td {
            padding: 10px;
            text-align: center;
            color: #0076c8; /* Color de texto */
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #0076c8; /* Azul */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo $_SESSION['afiliado_nombre']; ?></h2>
        <div class="btn-container">
            <a href="generar_cita.php" class="btn">Generar Cita</a>
            <a href="../logout.php" class="btn">Cerrar Sesión</a>
        </div>
        <h3>Tus Citas</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Doctor</th>
                    <th>Especialidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_cita = $result_citas->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row_cita['FechaHora']; ?></td>
                        <td><?php echo $row_cita['DoctorNombre'] . ' ' . $row_cita['DoctorApellido']; ?></td>
                        <td><?php echo $row_cita['EspecialidadNombre']; ?></td>
                        <td><?php echo $row_cita['Estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Incluir la conexión a la base de datos
include_once '../includes/db_connection.php';

// Verificar si el afiliado está autenticado
// Aquí puedes implementar tu lógica de autenticación, como comprobar la sesión, cookies, etc.
// Por simplicidad, aquí asumimos que ya se ha realizado la autenticación.

// Ejemplo de autenticación básica:
// Suponemos que $afiliado_id contiene el ID del afiliado autenticado
$afiliado_id = 1; // Este valor debe ser obtenido de tu sistema de autenticación

// Consultar el nombre del afiliado
$query_afiliado = "SELECT Nombre FROM Afiliados WHERE AfiliadoID = $afiliado_id";
$result_afiliado = $conn->query($query_afiliado);
if ($result_afiliado->num_rows == 1) {
    $row_afiliado = $result_afiliado->fetch_assoc();
    $nombre_afiliado = $row_afiliado['Nombre'];
} else {
    // Manejar el caso donde no se encuentre el afiliado (esto no debería suceder si la autenticación es correcta)
    $nombre_afiliado = "Afiliado";
}

// Consultar las citas generadas por el afiliado
$query_citas = "SELECT c.FechaHora, d.Nombre AS Doctor, e.Nombre AS Especialidad, h.Nombre AS Hospital, c.Estado
                FROM Citas c
                INNER JOIN Doctores d ON c.DoctorID = d.DoctorID
                INNER JOIN Especialidades e ON c.EspecialidadID = e.EspecialidadID
                INNER JOIN Hospitales h ON d.HospitalID = h.HospitalID
                WHERE c.AfiliadoID = $afiliado_id";
$result_citas = $conn->query($query_citas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz del Afiliado</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background-color: #f0f0f0; /* Fondo gris claro */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .welcome {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .user-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .citas-list {
            margin-top: 20px;
        }
        .citas-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .citas-list table th,
        .citas-list table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .logout-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            text-align: center;
            background-color: #dc3545; /* Rojo */
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333; /* Rojo más oscuro */
        }
        .generate-btn {
            display: block;
            width: 150px;
            margin: 20px auto;
            text-align: center;
            background-color: #007bff; /* Azul */
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .generate-btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Bienvenido, <?php echo $nombre_afiliado; ?></h1>
        </div>
        <div class="user-info">
            <p>Aquí puedes ver tus citas y generar nuevas.</p>
        </div>
        <div class="citas-list">
            <h2>Tus Citas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Hospital</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar las citas del afiliado
                    while ($row_cita = $result_citas->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_cita['FechaHora'] . "</td>";
                        echo "<td>" . $row_cita['Doctor'] . "</td>";
                        echo "<td>" . $row_cita['Especialidad'] . "</td>";
                        echo "<td>" . $row_cita['Hospital'] . "</td>";
                        echo "<td>" . $row_cita['Estado'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="../logout.php" class="logout-btn">Cerrar Sesión</a>
        <a href="generar_cita.php" class="generate-btn">Generar Cita</a>
    </div>
</body>
</html>
      
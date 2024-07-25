<?php
include_once '../includes/db_connection.php';

$query = "SELECT c.CitaID, c.FechaHora, e.Nombre AS Especialidad, CONCAT(d.Nombre, ' ', d.Apellido) AS Doctor,
                 a.Nombre AS AfiliadoNombre, a.Apellidos AS AfiliadoApellidos, c.Estado
          FROM Citas c
          INNER JOIN Especialidades e ON c.EspecialidadID = e.EspecialidadID
          INNER JOIN Doctores d ON c.DoctorID = d.DoctorID
          INNER JOIN Afiliados a ON c.AfiliadoID = a.AfiliadoID
          ORDER BY c.FechaHora DESC";

$result = $conn->query($query);

if (!$result) {
    die("Error al consultar citas: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url('../img/secundaria.png');
            background-size: cover;
            position: relative;
        }
        .container {
            width: 80%;
            margin: 2.5cm auto 20px auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: none;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #0076c8;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: none;
            box-shadow: none;
            color: #0076c8;
        }
        .estado-registrada {
            color: #0076c8;
            font-weight: bold;
        }
        .estado-confirmada {
            color: green;
            font-weight: bold;
        }
        .estado-cancelada {
            color: red;
            font-weight: bold;
        }
        .btn {
            padding: 6px 7px;
            background-color: #0076c8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        h2 {
            color: #0076c8;
        }
        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="home-button">
        <a href="../admin/index_admin.php" class="btn">Home</a>
    </div>
    <div class="container">
        <h2>Lista de Citas</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Especialidad</th>
                    <th>Doctor</th>
                    <th>Afiliado</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['FechaHora']; ?></td>
                    <td><?php echo $row['Especialidad']; ?></td>
                    <td><?php echo $row['Doctor']; ?></td>
                    <td><?php echo $row['AfiliadoNombre'] . ' ' . $row['AfiliadoApellidos']; ?></td>
                    <td class="<?php echo 'estado-' . strtolower($row['Estado']); ?>"><?php echo $row['Estado']; ?></td>
                    <td>
                        <a href="editar_cita.php?id=<?php echo $row['CitaID']; ?>" class="btn">Editar</a>
                        <a href="cambiar_estado.php?id=<?php echo $row['CitaID']; ?>" class="btn">Cambiar Estado</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$result->free();
$conn->close();
?>

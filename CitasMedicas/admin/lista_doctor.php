<?php
// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Consultar lista de doctores y sus especialidades
$query_doctores = "SELECT d.DoctorID, d.Nombre, d.Apellido, e.Nombre AS Especialidad 
                   FROM Doctores d
                   JOIN Especialidades e ON d.EspecialidadID = e.EspecialidadID";
$result_doctores = $conn->query($query_doctores);

// Procesar eliminación de doctor
if (isset($_GET['delete'])) {
    $doctor_id = $_GET['delete'];
    $query_delete = "DELETE FROM Doctores WHERE DoctorID = ?";
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    header("Location: lista_doctor.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Doctores</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background: url('../img/secundaria.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2.5cm 0 0 0;
            color: #0076c8;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: transparent; /* Fondo transparente */
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #0076c8; /* Borde azul */
            text-align: left;
            color: #0076c8; /* Color de texto azul */
        }
        th {
            background-color: transparent; /* Fondo transparente */
        }
        .btn-container {
            text-align: right;
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
            text-decoration: none; /* Quitar subrayado en el caso de los enlaces */
            margin-right: 10px; /* Espaciado entre botones */
        }
        .btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #0076c8;">Lista de Doctores</h2>
        <table>
            <thead>
                <tr>
                    <th style="color: #0076c8;">Nombre</th>
                    <th style="color: #0076c8;">Apellido</th>
                    <th style="color: #0076c8;">Especialidad</th>
                    <th style="color: #0076c8;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_doctor = $result_doctores->fetch_assoc()) : ?>
                    <tr>
                        <td style="color: #0076c8;"><?php echo $row_doctor['Nombre']; ?></td>
                        <td style="color: #0076c8;"><?php echo $row_doctor['Apellido']; ?></td>
                        <td style="color: #0076c8;"><?php echo $row_doctor['Especialidad']; ?></td>
                        <td>
                            <a href="editar_doctor.php?id=<?php echo $row_doctor['DoctorID']; ?>" class="btn">Editar</a>
                            <a href="lista_doctor.php?delete=<?php echo $row_doctor['DoctorID']; ?>" class="btn" onclick="return confirm('¿Está seguro de eliminar este doctor?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="crear_doctor.php" class="btn">Agregar Doctor</a>
            <a href="index_admin.php" class="btn">Home</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

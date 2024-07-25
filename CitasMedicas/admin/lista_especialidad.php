<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Obtener lista de especialidades
$query_especialidades = "SELECT EspecialidadID, Nombre FROM Especialidades";
$result_especialidades = $conn->query($query_especialidades);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Eliminar especialidad
    $delete_id = $_POST['delete_id'];
    $query_delete = "DELETE FROM Especialidades WHERE EspecialidadID = $delete_id";

    if ($conn->query($query_delete) === TRUE) {
        echo "<script>alert('Especialidad eliminada correctamente.'); window.location.href='lista_especialidad.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la especialidad: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Especialidades</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2.5cm 0 0 0;
            padding: 0;
            background: url('../img/secundaria.png') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #0076c8;
        }
        table, th, td {
            border: 1px solid #0076c8;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 5px 10px;
            background-color: #0076c8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: white;
            color: #0076c8;                 /* Color de texto #0076c8 */
            border: 1.5px solid #0076c8;    /* Color y ancho de borde #0076c8  1.5px */
            border-radius: 5px;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: white;
            color: #c82333;                 /* Color de texto rojo */
            border: 1px solid #c82333;    /* Color y ancho de borde rojo  1.5px */
            border-radius: 5px;
        }
        .btn-home, .btn-add {
            background-color: #0076c8;
        }
        .btn-home:hover, .btn-add:hover {   /* Diseño al colocar cursor*/
            background-color: white;        /* Fondo blanco */
            color: #0076c8;                 /* Color de texto #0076c8 */
            border: 1.5px solid #0076c8;    /* Color y ancho de borde #0076c8  1.5px */
            border-radius: 5px;
        }
        .button-container {
            margin-bottom: 20px;
            text-align: right;
        }
    </style>
    <script>
        function confirmDelete(especialidadID) {
            if (confirm('¿Está seguro que desea eliminar esta especialidad?')) {
                document.getElementById('deleteForm').delete_id.value = especialidadID;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <a href="index_admin.php" class="btn btn-home">Home</a>
            <a href="crear_especialidad.php" class="btn btn-add">Agregar Especialidad</a>
        </div>
        <h2 style="color: #0076c8;">Lista de Especialidades</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Nombre de Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_especialidades->num_rows > 0) {
                    $item = 1;
                    while ($row = $result_especialidades->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $item++ . "</td>";
                        echo "<td>" . $row['Nombre'] . "</td>";
                        echo "<td>
                                <a href='editar_especialidad.php?id=" . $row['EspecialidadID'] . "' class='btn'>Editar</a>
                                <button class='btn btn-delete' onclick='confirmDelete(" . $row['EspecialidadID'] . ")'>Eliminar</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No se encontraron especialidades.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <form id="deleteForm" method="POST" action="">
            <input type="hidden" name="delete_id" value="">
        </form>
    </div>
</body>
</html>

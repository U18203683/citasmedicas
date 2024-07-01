<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Obtener lista de afiliados
$query_afiliados = "SELECT AfiliadoID, Nombre, Apellidos, DNI FROM Afiliados";
$result_afiliados = $conn->query($query_afiliados);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Eliminar afiliado
    $delete_id = $_POST['delete_id'];
    $query_delete = "DELETE FROM Afiliados WHERE AfiliadoID = $delete_id";

    if ($conn->query($query_delete) === TRUE) {
        echo "<script>alert('Afiliado eliminado correctamente.'); window.location.href='lista_afiliados.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el afiliado: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Afiliados</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 5px 10px;
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
        .btn-delete {
            background-color: #dc3545; /* Rojo */
        }
        .btn-delete:hover {
            background-color: #c82333; /* Rojo más oscuro */
        }
        .btn-home {
            background-color: #28a745; /* Verde */
        }
        .btn-home:hover {
            background-color: #218838; /* Verde más oscuro */
        }
        .button-container {
            margin-bottom: 20px;
            text-align: right;
        }
    </style>
    <script>
        function confirmDelete(afiliadoID) {
            if (confirm('¿Está seguro que desea eliminar este afiliado?')) {
                document.getElementById('deleteForm').delete_id.value = afiliadoID;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <a href="index_admin.php" class="btn btn-home">Home</a>
        </div>
        <h2>Lista de Afiliados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_afiliados->num_rows > 0) {
                    while ($row = $result_afiliados->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Nombre'] . "</td>";
                        echo "<td>" . $row['Apellidos'] . "</td>";
                        echo "<td>" . $row['DNI'] . "</td>";
                        echo "<td>
                                <a href='editar_afiliado.php?id=" . $row['AfiliadoID'] . "' class='btn'>Editar</a>
                                <button class='btn btn-delete' onclick='confirmDelete(" . $row['AfiliadoID'] . ")'>Eliminar</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron afiliados.</td></tr>";
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

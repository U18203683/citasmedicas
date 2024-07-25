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
            background-image: url('../img/secundaria.png'); /* Fondo de imagen */
            background-size: cover;
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
            box-shadow: none;
            margin-top: 2.5cm; /* Espacio de 2.5cm en la parte superior */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #0076c8; /* Color de borde */
            color: #0076c8; /* Color del texto */
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
        <h2 style="color: #0076c8;">Lista de Afiliados</h2>
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

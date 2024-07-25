<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

// Obtener datos de la especialidad
$especialidad_id = $_GET['id'];
$query = "SELECT * FROM Especialidades WHERE EspecialidadID = $especialidad_id";
$result = $conn->query($query);
$especialidad = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];

    // Actualizar especialidad
    $query_update = "UPDATE Especialidades SET Nombre = '$nombre' WHERE EspecialidadID = $especialidad_id";

    if ($conn->query($query_update) === TRUE) {
        echo "<script>alert('Especialidad actualizada correctamente.'); window.location.href='lista_especialidad.php';</script>";
    } else {
        $error = "Error al actualizar la especialidad: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Especialidad</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background-image: url('../img/secundaria.png'); /* Fondo de imagen */
            background-size: cover; /* Ajustar la imagen al tamaño de la pantalla */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 2.5cm auto 20px auto; /* Espacio superior de 2.5cm */
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #0076c8; /* Color de texto */
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #0076c8; /* Color del borde */
        }
        h2 {
            color: #0076c8; /* Color del título */
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
        .btn-container {
            text-align: right;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Especialidad</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $especialidad['Nombre']; ?>" required>
            </div>
            <div class="btn-container">
                <button type="submit" name="submit" class="btn">Guardar Cambios</button>
                <a href="lista_especialidad.php" class="btn">Cancelar</a>
            </div>
        </form>
        <?php if (!empty($error)) : ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>


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
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 15px;
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

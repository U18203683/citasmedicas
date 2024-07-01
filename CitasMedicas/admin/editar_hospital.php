<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

if (isset($_GET['id'])) {
    $hospital_id = $_GET['id'];

    // Obtener datos del hospital
    $query_hospital = "SELECT * FROM Hospitales WHERE HospitalID = $hospital_id";
    $result_hospital = $conn->query($query_hospital);

    if ($result_hospital->num_rows > 0) {
        $hospital = $result_hospital->fetch_assoc();
    } else {
        echo "<script>alert('Hospital no encontrado.'); window.location.href='lista_hospital.php';</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    // Actualizar datos del hospital
    $query_update = "UPDATE Hospitales SET Nombre = '$nombre', Direccion = '$direccion' WHERE HospitalID = $hospital_id";

    if ($conn->query($query_update) === TRUE) {
        echo "<script>alert('Hospital actualizado correctamente.'); window.location.href='lista_hospital.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el hospital: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hospital</title>
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
            margin: 50px auto;
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
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-container {
            text-align: right;
        }
        .btn {
            padding: 8px 15px;
            background-color: #007bff; /* Azul */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        .btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
        .btn-cancel {
            background-color: #dc3545; /* Rojo */
        }
        .btn-cancel:hover {
            background-color: #c82333; /* Rojo más oscuro */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Hospital</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo isset($hospital['Nombre']) ? $hospital['Nombre'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo isset($hospital['Direccion']) ? $hospital['Direccion'] : ''; ?>" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn" name="submit">Actualizar</button>
                <a href="lista_hospital.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

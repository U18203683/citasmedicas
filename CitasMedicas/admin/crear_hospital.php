<?php
session_start();

// Incluir archivo de conexión a la base de datos
include_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    // Insertar nuevo hospital
    $query_insert = "INSERT INTO Hospitales (Nombre, Direccion) VALUES ('$nombre', '$direccion')";

    if ($conn->query($query_insert) === TRUE) {
        echo "<script>alert('Hospital creado correctamente.'); window.location.href='lista_hospital.php';</script>";
    } else {
        echo "<script>alert('Error al crear el hospital: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Hospital</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background: url('../img/secundaria.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2cm 0 0 0;
            color: #0076c8;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background: transparent;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #0076c8;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #0076c8;
            border-radius: 4px;
            color: #0076c8;
        }
        .btn-container {
            text-align: right;
        }
        .btn {
            padding: 8px 15px;
            background-color: transparent;
            color: #0076c8;
            border: 2px solid #0076c8;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-left: 10px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0076c8;
            color: white;
        }
        .btn-cancel {
            border-color: #dc3545; /* Rojo */
            color: #dc3545;
        }
        .btn-cancel:hover {
            background-color: #dc3545; /* Rojo */
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Hospital</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Crear</button>
                <a href="lista_hospital.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>


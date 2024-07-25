<?php
include_once '../includes/db_connection.php';

// Verificar si se recibió un ID válido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cita_id = $_GET['id'];
    
    // Verificar si se recibió un estado válido por POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['estado'])) {
        $estado = $_POST['estado'];

        // Actualizar el estado de la cita en la base de datos
        $query_update_estado = "UPDATE Citas SET Estado = ? WHERE CitaID = ?";
        $stmt = $conn->prepare($query_update_estado);
        $stmt->bind_param("si", $estado, $cita_id);

        if ($stmt->execute()) {
            header("Location: lista_citas.php");
            exit();
        } else {
            die("Error al actualizar el estado de la cita: " . $conn->error);
        }
    }
} else {
    die("ID de cita no válido");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Estado de Cita</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2.5cm 0 0 0;
            background-image: url('../img/secundaria.png');
            background-size: cover;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background-color: transparent;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #0076c8; /* Color de texto para los labels */
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #0076c8; /* Color de fondo del botón */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #0076c8;">Cambiar Estado de Cita</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $cita_id; ?>" method="POST">
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="Registrada">Registrada</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Guardar Cambios</button>
                <a href="lista_citas.php" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

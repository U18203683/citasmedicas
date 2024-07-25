<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si el administrador está autenticado
// Aquí puedes implementar tu lógica de autenticación, como comprobar la sesión, cookies, etc.
// Por simplicidad, aquí asumimos que ya se ha realizado la autenticación.

// Ejemplo de autenticación básica:
// Suponemos que $admin_id contiene el ID del administrador autenticado
$admin_id = 1; // Este valor debe ser obtenido de tu sistema de autenticación

// Consultar el nombre del administrador
include_once '../includes/db_connection.php'; // Incluir archivo de conexión a la base de datos

$query_admin = "SELECT Nombre, Apellido FROM Administradores WHERE AdminID = $admin_id";
$result_admin = $conn->query($query_admin);

if ($result_admin->num_rows == 1) {
    $row_admin = $result_admin->fetch_assoc();
    $nombre_admin = $row_admin['Nombre'] . " " . $row_admin['Apellido'];
} else {
    // Manejar el caso donde no se encuentre el administrador (esto no debería suceder si la autenticación es correcta)
    $nombre_admin = "Administrador";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz del Administrador</title>
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
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            background: transparent;
            box-shadow: none;
        }
        .welcome {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .user-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .logout-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            text-align: center;
            background-color: #0076c8;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #0076c8;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: white;
            color: #0076c8;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .button-container a {
            display: block;
            width: 200px;
            padding: 15px;
            text-align: center;
            background-color: transparent;
            color: #0076c8;
            border-radius: 5px;
            border: 2px solid #0076c8;
            text-decoration: none;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .button-container a:hover {
            background-color: #0076c8;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Bienvenido, <?php echo $nombre_admin; ?></h1>
        </div>
        <div class="user-info">
            <p>Aquí puedes administrar hospitales, doctores y especialidades.</p>
        </div>
        <div class="button-container">
            <a href="lista_hospital.php">Hospitales</a>
            <a href="lista_doctor.php">Doctores</a>
            <a href="lista_especialidad.php">Especialidades</a>
            <a href="lista_afiliados.php">Afiliados</a>
            <a href="lista_citas.php">Citas</a>
        </div>
        <a href="../logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</body>
</html>

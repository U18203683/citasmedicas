<?php
// Datos de conexión a la base de datos
$servername = "localhost";  // Nombre de servidor
$username = "root";
$password = "";  // No hay contraseña para el usuario "root" en este caso
$database = "Integrador_DB";  // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Función para verificar la conexión
function checkConnection($conn) {
    if ($conn->ping()) {
        return true;  // Conexión establecida correctamente
    } else {
        return false; // Error al conectar
    }
}

// Verificar la conexión al incluir este archivo
if (!checkConnection($conn)) {
    die("Error: La conexión no está activa."); // Mostrar mensaje de error si la conexión no está activa
}

// Establecer el juego de caracteres a UTF-8 (opcional)
if (!$conn->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $conn->error);
    exit();
}



?>

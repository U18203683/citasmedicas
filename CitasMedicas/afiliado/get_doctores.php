<?php
include_once '../includes/db_connection.php';

$especialidad_id = $_GET['especialidad_id'];

$query_doctores = "SELECT DoctorID, Nombre, Apellido FROM Doctores WHERE EspecialidadID = ?";
$stmt = $conn->prepare($query_doctores);
$stmt->bind_param("i", $especialidad_id);
$stmt->execute();
$result = $stmt->get_result();

$doctores = [];
while ($row = $result->fetch_assoc()) {
    $doctores[] = $row;
}

echo json_encode($doctores);

$stmt->close();
$conn->close();
?>

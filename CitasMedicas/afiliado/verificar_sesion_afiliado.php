<?php
session_start();

if (!isset($_SESSION['afiliado_id'])) {
    header("Location: login_afiliado.php");
    exit();
}
?>

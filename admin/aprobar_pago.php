<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $pago_id = $_GET['id'];
    
    // Primero obtenemos el miembro_id antes de aprobar
    $pago_info = $conn->query("SELECT miembro_id FROM pagos WHERE id = $pago_id")->fetch_assoc();
    $miembro_id = $pago_info['miembro_id'];
    
    // Aprobamos el pago
    $conn->query("UPDATE pagos SET estado = 'aprobado' WHERE id = $pago_id");
    
    // Actualizamos el estado del miembro a "activo"
    $conn->query("UPDATE miembros SET estado = 'activo' WHERE id = $miembro_id");
}

header('Location: pagos.php');
exit();
?>
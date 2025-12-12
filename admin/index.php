<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Estadísticas
$total_miembros = $conn->query("SELECT COUNT(*) as total FROM miembros")->fetch_assoc()['total'];
$total_pagos = $conn->query("SELECT COUNT(*) as total FROM pagos")->fetch_assoc()['total'];
$pagos_aprobados = $conn->query("SELECT COUNT(*) as total FROM pagos WHERE estado = 'aprobado'")->fetch_assoc()['total'];
$ingresos_totales = $conn->query("SELECT SUM(monto) as total FROM pagos WHERE estado = 'aprobado'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: #f5f5f5; padding: 1.5rem; border-radius: 5px; text-align: center; }
        .stat-number { font-size: 2rem; font-weight: bold; color: var(--blue); }
        .menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
        .menu-card { background: var(--blue); color: white; padding: 2rem; text-align: center; border-radius: 5px; text-decoration: none; }
        .menu-card:hover { background: var(--orange); }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Panel Administrativo - LBGYM</h1>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= $total_miembros ?></div>
                <div>Total Miembros</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $total_pagos ?></div>
                <div>Total Pagos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $pagos_aprobados ?></div>
                <div>Pagos Aprobados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?= number_format($ingresos_totales, 0, ',', '.') ?></div>
                <div>Ingresos Totales</div>
            </div>
        </div>
        
        <div class="menu">
            <a href="miembros.php" class="menu-card">
                <h3>Gestión de Miembros</h3>
                <p>Administrar miembros registrados</p>
            </a>
            <a href="pagos.php" class="menu-card">
                <h3>Gestión de Pagos</h3>
                <p>Ver y aprobar pagos</p>
            </a>
            <a href="../index.php" class="menu-card">
                <h3>Volver al Sitio</h3>
                <p>Ir al sitio principal</p>
            </a>
            <a href="logout.php" class="menu-card">
                <h3>Cerrar Sesión</h3>
                <p>Salir del panel admin</p>
            </a>
        </div>
    </div>
</body>
</html>
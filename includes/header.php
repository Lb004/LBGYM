<?php
// includes/header.php - Session start aquí
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LBGYM - Gimnasio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <header>
        <a href="index.php" class="logo">
            <i class="fa-solid fa-dumbbell"></i>
            <span>LB</span>GYM
        </a>
        <nav id="navbar">
            <a href="index.php">Inicio</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="galeria.php">Galería</a>
            <a href="planes.php">Precios</a>
            <a href="equipo.php">Equipo</a>
            <a href="contacto.php">Contacto</a>
            <?php if(isset($_SESSION['admin'])): ?>
                <a href="admin/index.php" style="color: var(--orange);">Admin</a>
            <?php endif; ?>
        </nav>
        <div id="menu-icon" class="fa-solid fa-bars"></div>
    </header>
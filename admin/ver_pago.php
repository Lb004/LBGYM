<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: pagos.php');
    exit();
}

$pago_id = $_GET['id'];
$pago = $conn->query("
    SELECT p.*, m.nombre as miembro_nombre, m.email, m.telefono, m.fecha_nacimiento, m.direccion,
           pl.nombre as plan_nombre, pl.duracion_meses, pl.descripcion as plan_descripcion
    FROM pagos p 
    JOIN miembros m ON p.miembro_id = m.id 
    JOIN planes pl ON p.plan_id = pl.id 
    WHERE p.id = $pago_id
")->fetch_assoc();

if (!$pago) {
    header('Location: pagos.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Pago - Admin LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-container { max-width: 800px; margin: 0 auto; padding: 2rem; }
        .payment-info { background: #f8f9fa; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .info-item { margin-bottom: 0.5rem; }
        .info-label { font-weight: bold; color: #555; }
        .status-badge { padding: 0.3rem 0.8rem; border-radius: 15px; font-weight: bold; display: inline-block; }
        .status-aprobado { background: #d4edda; color: #155724; }
        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-rechazado { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Detalles del Pago</h2>
        <a href="pagos.php" style="margin-bottom: 1rem; display: inline-block;">← Volver a Pagos</a>
        
        <div class="payment-info">
            <h3>Información del Pago #<?= $pago['id'] ?></h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Miembro:</span><br>
                    <?= $pago['miembro_nombre'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span><br>
                    <?= $pago['email'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Plan:</span><br>
                    <?= $pago['plan_nombre'] ?> (<?= $pago['duracion_meses'] ?> meses)
                </div>
                <div class="info-item">
                    <span class="info-label">Monto:</span><br>
                    $<?= number_format($pago['monto'], 0, ',', '.') ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Método de Pago:</span><br>
                    <?= ucfirst($pago['metodo_pago']) ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Estado:</span><br>
                    <span class="status-badge status-<?= $pago['estado'] ?>">
                        <?= ucfirst($pago['estado']) ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha de Pago:</span><br>
                    <?= $pago['fecha_pago'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Código de Transacción:</span><br>
                    <?= $pago['codigo_transaccion'] ?>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <h3>Información del Miembro</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Teléfono:</span><br>
                    <?= $pago['telefono'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha de Nacimiento:</span><br>
                    <?= $pago['fecha_nacimiento'] ?: 'No especificada' ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Dirección:</span><br>
                    <?= $pago['direccion'] ?: 'No especificada' ?>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <h3>Descripción del Plan</h3>
            <p><?= $pago['plan_descripcion'] ?></p>
        </div>

        <div style="margin-top: 2rem;">
            <?php if ($pago['estado'] == 'pendiente'): ?>
            <a href="aprobar_pago.php?id=<?= $pago['id'] ?>" class="btn-small btn-success">Aprobar Pago</a>
            <a href="rechazar_pago.php?id=<?= $pago['id'] ?>" class="btn-small btn-warning">Rechazar Pago</a>
            <?php endif; ?>
            <a href="pagos.php?eliminar=<?= $pago['id'] ?>" class="btn-small btn-danger" 
               onclick="return confirm('¿Estás seguro de eliminar este pago?')">Eliminar Pago</a>
        </div>
    </div>
</body>
</html>
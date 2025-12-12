<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: miembros.php');
    exit();
}

$miembro_id = $_GET['id'];
$miembro = $conn->query("SELECT * FROM miembros WHERE id = $miembro_id")->fetch_assoc();

if (!$miembro) {
    header('Location: miembros.php');
    exit();
}

// Obtener historial de pagos del miembro
$pagos = $conn->query("
    SELECT p.*, pl.nombre as plan_nombre 
    FROM pagos p 
    JOIN planes pl ON p.plan_id = pl.id 
    WHERE p.miembro_id = $miembro_id 
    ORDER BY p.fecha_pago DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Miembro - Admin LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
        .member-info { background: #f8f9fa; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .info-item { margin-bottom: 0.5rem; }
        .info-label { font-weight: bold; color: #555; }
        .payment-history { margin-top: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.8rem; text-align: left; border-bottom: 1px solid #ddd; }
        .estado-aprobado { color: green; font-weight: bold; }
        .estado-pendiente { color: orange; font-weight: bold; }
        .estado-rechazado { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Información del Miembro</h2>
        <a href="miembros.php" style="margin-bottom: 1rem; display: inline-block;">← Volver a Miembros</a>
        
        <div class="member-info">
            <h3><?= $miembro['nombre'] ?></h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Email:</span><br>
                    <?= $miembro['email'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Teléfono:</span><br>
                    <?= $miembro['telefono'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha de Nacimiento:</span><br>
                    <?= $miembro['fecha_nacimiento'] ?: 'No especificada' ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Dirección:</span><br>
                    <?= $miembro['direccion'] ?: 'No especificada' ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha de Registro:</span><br>
                    <?= $miembro['fecha_registro'] ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Estado:</span><br>
                    <?= ucfirst($miembro['estado']) ?>
                </div>
            </div>
        </div>

        <div class="payment-history">
            <h3>Historial de Pagos</h3>
            <?php if($pagos->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Pago</th>
                            <th>Plan</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Código Transacción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($pago = $pagos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $pago['id'] ?></td>
                            <td><?= $pago['plan_nombre'] ?></td>
                            <td>$<?= number_format($pago['monto'], 0, ',', '.') ?></td>
                            <td><?= ucfirst($pago['metodo_pago']) ?></td>
                            <td class="estado-<?= $pago['estado'] ?>"><?= ucfirst($pago['estado']) ?></td>
                            <td><?= $pago['fecha_pago'] ?></td>
                            <td><?= $pago['codigo_transaccion'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay pagos registrados para este miembro.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
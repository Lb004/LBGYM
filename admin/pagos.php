<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Procesar eliminación de pago
if (isset($_GET['eliminar'])) {
    $pago_id = $_GET['eliminar'];
    
    // Primero obtenemos el miembro_id antes de eliminar
    $pago_info = $conn->query("SELECT miembro_id FROM pagos WHERE id = $pago_id")->fetch_assoc();
    $miembro_id = $pago_info['miembro_id'];
    
    // Eliminamos el pago
    $conn->query("DELETE FROM pagos WHERE id = $pago_id");
    
    // Actualizamos el estado del miembro a "inactivo"
    $conn->query("UPDATE miembros SET estado = 'inactivo' WHERE id = $miembro_id");
    
    header('Location: pagos.php?success=1');
    exit();
}

$pagos = $conn->query("
    SELECT p.*, m.nombre as miembro_nombre, m.email as miembro_email, pl.nombre as plan_nombre 
    FROM pagos p 
    JOIN miembros m ON p.miembro_id = m.id 
    JOIN planes pl ON p.plan_id = pl.id 
    ORDER BY p.fecha_pago DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagos - Admin LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/pagos_miembros.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Gestión de Pagos</h1>
            <a href="index.php" class="admin-back-link">← Volver al Panel</a>
        </div>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="admin-success">Pago eliminado correctamente y miembro marcado como inactivo.</div>
        <?php endif; ?>
        
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Miembro</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($pago = $pagos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $pago['id'] ?></td>
                        <td class="nombre-cell"><?= htmlspecialchars($pago['miembro_nombre']) ?></td>
                        <td class="email-cell" title="<?= htmlspecialchars($pago['miembro_email']) ?>">
                            <?= htmlspecialchars($pago['miembro_email']) ?>
                        </td>
                        <td><?= htmlspecialchars($pago['plan_nombre']) ?></td>
                        <td class="monto-cell">$<?= number_format($pago['monto'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($pago['metodo_pago']) ?></td>
                        <td>
                            <span class="estado-badge estado-<?= $pago['estado'] ?>-badge">
                                <?= ucfirst($pago['estado']) ?>
                            </span>
                        </td>
                        <td><?= $pago['fecha_pago'] ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="ver_pago.php?id=<?= $pago['id'] ?>" class="btn-small btn-info">Ver</a>
                                <?php if ($pago['estado'] == 'pendiente'): ?>
                                <a href="aprobar_pago.php?id=<?= $pago['id'] ?>" class="btn-small btn-success">Aprobar</a>
                                <a href="rechazar_pago.php?id=<?= $pago['id'] ?>" class="btn-small btn-warning">Rechazar</a>
                                <?php endif; ?>
                                <a href="pagos.php?eliminar=<?= $pago['id'] ?>" class="btn-small btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar este pago? El miembro será marcado como INACTIVO.')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
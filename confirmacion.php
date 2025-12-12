<?php
include 'includes/config.php';

if (!isset($_GET['pago_id'])) {
    header('Location: planes.php');
    exit();
}

$pago_id = $_GET['pago_id'];
$pago = $conn->query("
    SELECT p.*, m.nombre, m.email, pl.nombre as plan_nombre 
    FROM pagos p 
    JOIN miembros m ON p.miembro_id = m.id 
    JOIN planes pl ON p.plan_id = pl.id 
    WHERE p.id = $pago_id
")->fetch_assoc();

if (!$pago) {
    header('Location: planes.php');
    exit();
}
?>

<?php include 'includes/header.php'; ?>

<section style="padding: 4rem 0; text-align: center;">
    <div class="container">
        <div style="background: #f5f5f5; padding: 2rem; border-radius: 10px; max-width: 500px; margin: 0 auto;">
            <?php if($pago['estado'] == 'aprobado'): ?>
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: green; margin-bottom: 1rem;"></i>
                <h2>¡Pago Exitoso!</h2>
            <?php else: ?>
                <i class="fa-solid fa-clock" style="font-size: 4rem; color: orange; margin-bottom: 1rem;"></i>
                <h2>¡Registro Completado!</h2>
                <p>Tu pago está pendiente de aprobación</p>
            <?php endif; ?>
            
            <p><strong>Nombre:</strong> <?= $pago['nombre'] ?></p>
            <p><strong>Plan:</strong> <?= $pago['plan_nombre'] ?></p>
            <p><strong>Monto:</strong> $<?= number_format($pago['monto'], 0, ',', '.') ?></p>
            <p><strong>Estado:</strong> <?= ucfirst($pago['estado']) ?></p>
            <p><strong>Código de transacción:</strong> <?= $pago['codigo_transaccion'] ?></p>
            <p><strong>Método de pago:</strong> <?= ucfirst($pago['metodo_pago']) ?></p>
            
            <div style="margin-top: 2rem;">
                <button class="btn" onclick="location.href='index.php'">Volver al Inicio</button>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
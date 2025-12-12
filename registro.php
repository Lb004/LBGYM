<?php
include 'includes/config.php';

if (!isset($_GET['plan_id'])) {
    header('Location: planes.php');
    exit();
}

$plan_id = $_GET['plan_id'];
$plan = $conn->query("SELECT * FROM planes WHERE id = $plan_id")->fetch_assoc();

if (!$plan) {
    header('Location: planes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro - LBGYM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section style="padding: 4rem 0; background: #f8f9fa; min-height: 100vh;">
        <div class="container">
            <h2 class="title">Completa tu Registro</h2>
            
            <?php if(isset($_GET['error']) && $_GET['error'] == 'email_existente'): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 2rem; text-align: center; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <strong>Error:</strong> El email ya está registrado. Por favor usa otro email.
                </div>
            <?php endif; ?>
            
            <div class="registration-form">
                <!-- Resumen del Plan -->
                <div class="plan-summary">
                    <h3>Plan Seleccionado: <?= $plan['nombre'] ?></h3>
                    <p><strong>Precio:</strong> $<?= number_format($plan['precio'], 0, ',', '.') ?> / mes</p>
                    <p><strong>Duración:</strong> <?= $plan['duracion_meses'] ?> meses</p>
                    <p><strong>Descripción:</strong> <?= $plan['descripcion'] ?></p>
                </div>

                <form action="procesar_pago.php" method="POST">
                    <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" required placeholder="Ingresa tu teléfono">
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ingresa tu dirección">
                    </div>
                    
                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago *</label>
                        <select id="metodo_pago" name="metodo_pago" required>
                            <option value="">Seleccionar método de pago</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                            <option value="mercadopago">Mercado Pago</option>
                        </select>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; padding: 1rem; font-size: 1.1rem;">
                        <i class="fa-solid fa-credit-card"></i> Continuar al Pago - $<?= number_format($plan['precio'], 0, ',', '.') ?>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>
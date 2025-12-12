<?php
include 'includes/config.php';

if ($_POST) {
    // Verificar si el email ya existe
    $email = $_POST['email'];
    $check_email = $conn->query("SELECT id FROM miembros WHERE email = '$email'");
    
    if ($check_email->num_rows > 0) {
        // El email ya existe, redirigir con error
        header("Location: registro.php?plan_id=" . $_POST['plan_id'] . "&error=email_existente");
        exit();
    }
    
    // Registrar el miembro con estado "pendiente" (será activado cuando se apruebe el pago)
    $stmt = $conn->prepare("INSERT INTO miembros (nombre, email, telefono, fecha_nacimiento, direccion, estado) VALUES (?, ?, ?, ?, ?, 'pendiente')");
    $stmt->bind_param("sssss", $_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['fecha_nacimiento'], $_POST['direccion']);
    
    if ($stmt->execute()) {
        $miembro_id = $stmt->insert_id;
        
        // Registrar el pago
        $plan_id = $_POST['plan_id'];
        $plan = $conn->query("SELECT * FROM planes WHERE id = $plan_id")->fetch_assoc();
        
        $stmt = $conn->prepare("INSERT INTO pagos (miembro_id, plan_id, monto, metodo_pago, estado, codigo_transaccion) VALUES (?, ?, ?, ?, 'pendiente', ?)");
        $codigo_transaccion = 'PAGO_' . time() . '_' . $miembro_id;
        $stmt->bind_param("iidss", $miembro_id, $plan_id, $plan['precio'], $_POST['metodo_pago'], $codigo_transaccion);
        
        if ($stmt->execute()) {
            $pago_id = $stmt->insert_id;
            
            // Para métodos diferentes a mercadopago, marcar como aprobado directamente
            if ($_POST['metodo_pago'] != 'mercadopago') {
                $conn->query("UPDATE pagos SET estado = 'aprobado' WHERE id = $pago_id");
                // Y activar el miembro
                $conn->query("UPDATE miembros SET estado = 'activo' WHERE id = $miembro_id");
            }
            
            header("Location: confirmacion.php?pago_id=$pago_id");
            exit();
        }
    }
    
    header("Location: planes.php?error=1");
    exit();
} else {
    header("Location: planes.php");
    exit();
}
?>
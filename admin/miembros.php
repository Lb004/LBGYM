<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $miembro_id = $_GET['eliminar'];
    $conn->query("DELETE FROM miembros WHERE id = $miembro_id");
    header('Location: miembros.php?success=eliminado');
    exit();
}

// Procesar cambio de estado
if (isset($_GET['cambiar_estado'])) {
    $miembro_id = $_GET['cambiar_estado'];
    $nuevo_estado = $_GET['estado'];
    $conn->query("UPDATE miembros SET estado = '$nuevo_estado' WHERE id = $miembro_id");
    header('Location: miembros.php?success=estado');
    exit();
}

$miembros = $conn->query("SELECT * FROM miembros ORDER BY fecha_registro DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Miembros - Admin LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/pagos_miembros.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Gestión de Miembros</h1>
            <a href="index.php" class="admin-back-link">← Volver al Panel</a>
        </div>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="admin-success">
                <?php if($_GET['success'] == 'eliminado'): ?>
                    Miembro eliminado correctamente.
                <?php else: ?>
                    Estado del miembro actualizado correctamente.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($miembro = $miembros->fetch_assoc()): ?>
                    <tr>
                        <td><?= $miembro['id'] ?></td>
                        <td class="nombre-cell"><?= htmlspecialchars($miembro['nombre']) ?></td>
                        <td class="email-cell" title="<?= htmlspecialchars($miembro['email']) ?>">
                            <?= htmlspecialchars($miembro['email']) ?>
                        </td>
                        <td class="telefono-cell"><?= htmlspecialchars($miembro['telefono']) ?></td>
                        <td><?= $miembro['fecha_registro'] ?></td>
                        <td>
                            <span class="estado-badge estado-<?= $miembro['estado'] ?>-badge">
                                <?= ucfirst($miembro['estado']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="ver_miembro.php?id=<?= $miembro['id'] ?>" class="btn-small btn-info">Ver</a>
                                
                                <?php if($miembro['estado'] == 'activo'): ?>
                                    <a href="miembros.php?cambiar_estado=<?= $miembro['id'] ?>&estado=inactivo" class="btn-small btn-warning">Desactivar</a>
                                <?php else: ?>
                                    <a href="miembros.php?cambiar_estado=<?= $miembro['id'] ?>&estado=activo" class="btn-small btn-success">Activar</a>
                                <?php endif; ?>
                                
                                <a href="miembros.php?eliminar=<?= $miembro['id'] ?>" class="btn-small btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar a <?= htmlspecialchars($miembro['nombre']) ?>?')">Eliminar</a>
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
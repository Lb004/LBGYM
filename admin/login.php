<?php
session_start();
include '../includes/config.php';

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - LBGYM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .login-container { max-width: 400px; margin: 100px auto; padding: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px; }
        .error { color: red; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin LBGYM</h2>
        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Usuario:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Ingresar</button>
        </form>
        
        <p style="margin-top: 1rem; text-align: center; font-size: 0.8rem;">
            Usuario: admin / Contraseña: admin123
        </p>
    </div>
</body>
</html>
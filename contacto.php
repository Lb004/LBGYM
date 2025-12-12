<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<section style="padding: 4rem 0;">
    <div class="container">
        <h2 class="title">Contacto</h2>
        <div style="max-width: 600px; margin: 0 auto; padding: 2rem;">
            <form action="procesar_contacto.php" method="POST">
                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" name="telefono">
                </div>
                
                <div class="form-group">
                    <label>Mensaje *</label>
                    <textarea name="mensaje" rows="5" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%;">
                    Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</section>

<style>
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}
.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 5px;
}
</style>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- equipo -->
<section id="equipo">
    <h2 class="title">Equipo</h2>

    <div class="row container">
        <?php
        $entrenadores = $conn->query("SELECT * FROM entrenadores WHERE estado = 'activo'");
        while($entrenador = $entrenadores->fetch_assoc()):
        ?>
        <div class="box">
            <div class="image">
                <img src="./img/<?= $entrenador['foto'] ?>" alt="<?= $entrenador['nombre'] ?>" />
            </div>
            <div class="content">
                <div class="social-network">
                    <i class="fa-brands fa-square-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-square-x-twitter"></i>
                </div>
                <h3><?= $entrenador['nombre'] ?></h3>
                <h4><?= $entrenador['especialidad'] ?></h4>
                <p><?= $entrenador['horario_trabajo'] ?></p>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
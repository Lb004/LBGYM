<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Planes -->
<section id="precios">
    <h2 class="title">Elige tu Plan</h2>
    <div class="row container">
        <?php
        $planes = $conn->query("SELECT * FROM planes WHERE estado = 'activo' ORDER BY precio ASC");
        while($plan = $planes->fetch_assoc()):
        ?>
        <div class="price-box">
            <h4>Plan <?= $plan['nombre'] ?></h4>
            <h3>$<span><?= number_format($plan['precio'], 0, ',', '.') ?></span>/Mes</h3>
            <p><?= $plan['duracion_meses'] ?> meses</p>
            
            <?php
            $beneficios_incluidos = explode(',', $plan['beneficios']);
            ?>
            
            <ul class="activities">
                <?php 
                $todos_beneficios = [
                    'crossfit' => 'Crossfit',
                    'yoga' => 'Yoga', 
                    'clases particulares' => 'Clases Particulares', 
                    'asesoria personalizacion' => 'Asesoría Personalización', 
                    'plan de alimentacion' => 'Plan de Alimentación', 
                    'acceso a toda la familia' => 'Acceso a Toda la Familia'
                ];
                
                foreach($todos_beneficios as $key => $beneficio): 
                    $incluido = in_array($key, $beneficios_incluidos);
                ?>
                <li>
                    <i class="fa-regular fa-circle-<?= $incluido ? 'check' : 'xmark' ?>"></i>
                    <?= $beneficio ?>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <form action="registro.php" method="GET" style="margin-top: 20px;">
                <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                <button type="submit" class="btn" style="width: 100%;">
                    Seleccionar Plan
                </button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
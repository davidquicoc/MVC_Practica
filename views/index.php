<?php
require_once __DIR__ . '/../controllers/DashboardController.php';
$tituloPagina = "Inicio | Biblioteca";
$cssFile = "I";
include __DIR__ . '/layout/header.php';
$contLibrosNoDisponible = 0;
$contLibrosDisponible = 0;
?>
<section>
    <div class="stats">
        <div class="left-stats">
            <div>
                <h3>Usuarios registrados</h3>
                <p><?= $totalUsuarios; ?></p>
            </div>
            <div>
                <h3>Total de préstamos existentes</h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="right-stats">
            <div>
                <h3>Libros totales</h3>
                <p><?= $totalLibros; ?></p>
            </div>
            <div>
                <h3>Libros disponibles</h3>
                <p><?= $totalLibrosDisponibles; ?></p>
            </div>
            <div>
                <h3>Libros no disponibles</h3>
                <p><?= $totalLibrosNoDisponibles; ?></p>
            </div>
        </div>
    </div>
    <?php if (empty($_SESSION['user'])) {?>
    <div class="login-div">
        <p>Inicia sesión para gestionar esta biblioteca. <a href="index.php?action=login">Pincha aquí</a></p>
    </div>
    <?php } ?>
</section>
<?php
include __DIR__ . '/layout/footer.php';
?>
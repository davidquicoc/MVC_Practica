<?php
require_once __DIR__ . '/../controllers/DashboardController.php';
$tituloPagina = "Inicio | Biblioteca";
$cssFile = "I";
include __DIR__ . '/layout/header.php';
?>
<section>
    <div class="libros-dispnibles">
        <h3>Libros disponibles</h3>
        <p><?= $totalLibros; ?></p>
    </div>
    <div>
        <h3>Usuarios registrados</h3>
        <p><?= $totalUsuarios; ?></p>
    </div>
    <?php if (empty($_SESSION['user'])) {?>
    <div>
        <p>Inicia sesión para gestionar esta biblioteca.</p>
        <p></p>
        <a href="index.php?action=login">Pincha aquí</a>
    </div>
    <?php } ?>
</section>
<?php
include __DIR__ . '/layout/footer.php';
?>
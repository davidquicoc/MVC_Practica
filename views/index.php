<?php
require_once __DIR__ . '/../controllers/DashboardController.php';
$tituloPagina = "Inicio | Biblioteca";
$cssFile = "I";
include __DIR__ . '/layout/header.php';

$totalUsuarios = $totalUsuariosExistentes ?? 0;
$totalLibros = $totalLibrosExistentes ?? 0;
$totalPrestamos = $totalPrestamosExistentes ?? 0;

$numLibrosDisp = $totalLibrosDisponibles ?? 0;
$numLibrosNoDisp = $totalLibrosNoDisponibles ?? 0;

$usuarioPrestamos = $prestamosDelUsuario ?? [];
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
                <p><?= $totalPrestamos; ?></p>
            </div>
        </div>
        <div class="right-stats">
            <div>
                <h3>Libros totales</h3>
                <p><?= $totalLibros; ?></p>
            </div>
            <div>
                <h3>Libros disponibles</h3>
                <p><?= $numLibrosDisp; ?></p>
            </div>
            <div>
                <h3>Libros no disponibles</h3>
                <p><?= $numLibrosNoDisp; ?></p>
            </div>
        </div>
        <?php if (isset($_SESSION['user'])) { ?>
        <div class="prestamo-stats">
            <h3>Preśtamos del usuario <?= $_SESSION['user']['nombre']; ?></h3>
                <?php if (!empty($usuarioPrestamos)) {
                        foreach($usuarioPrestamos as $prestamos) {
                            $tieneMulta = ($prestamos['fecha_devolucion'] > date('Y-m-d')) ? true : false; 
                ?>
                <div class="prestamo-data <?= ($tieneMulta) ? "multa" : "sin_multa"; ?>">
                    <p><?= $prestamos['titulo']; ?></p>
                    <p><?= $prestamos['fecha_devolucion']; ?></p>
                    <?php if ($tieneMulta) { ?>
                    <p>Multa a pagar: <?= $prestamos['multa']; ?></p>
                    <?php } else { ?>
                    <li>Multa: <?= $prestamos['multa']; ?></li>
                    <?php } ?>
                </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php if (!isset($_SESSION['user'])) {?>
    <div class="login-div">
        <p>Inicia sesión para gestionar esta biblioteca. <a href="index.php?action=login">Pincha aquí</a></p>
    </div>
    <?php } ?>
</section>
<?php
include __DIR__ . '/layout/footer.php';
?>
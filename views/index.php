<?php
require_once __DIR__ . '/../controllers/DashboardController.php';
$tituloPagina = "Inicio | Biblioteca";
$cssFile = "I";
include __DIR__ . '/layout/header.php';

$listadoLibros = $listaDeLibros ?? [];

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
        <div class="libros-stats">
            <h3>Disponibildad de libros</h3>
            <?php if (isset($libros['error'])) { ?>
            <p class="error">Error al acceder a la base de datos:" <?= $libros['error']; ?> </p>
            <?php } ?>
            <?php foreach($listadoLibros as $libros) { ?>
            <ul>
                <li class="lista-libros <?= ($libros['disponibilidad']) ? "disponible" : "no-disponible" ?>"><?= $libros['titulo'] ?></li>
            </ul>
            <?php } ?>
        </div>
        <?php if (isset($_SESSION['user']) && !empty($usuarioPrestamos)) { ?>
        <div class="prestamo-stats">
            <h3>Preśtamos del usuario <?= $_SESSION['user']['nombre']; ?></h3>
                <?php
                    foreach($usuarioPrestamos as $prestamos) {
                        $tieneMulta = date('Y-m-d') > $prestamos['fecha_devolucion']; 
                ?>
                <div class="prestamo-data <?= ($tieneMulta) ? "multa" : "sin_multa"; ?>">
                    <p>Libro: <span><?= $prestamos['titulo']; ?></span></p>
                    <p>Fecha de préstamo: <span><?= $prestamos['fecha_prestamo']; ?></span></p>
                    <p>Fecha de devolución: <span><?= $prestamos['fecha_devolucion']; ?></span></p>
                    <?php if ($tieneMulta) { ?>
                    <p>Multa a pagar: <span><?= $prestamos['multa']; ?></span></p>
                    <?php } ?>
                </div>
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
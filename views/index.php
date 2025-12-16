<?php
require_once __DIR__ . '/../controllers/DashboardController.php';
$tituloPagina = "Inicio | Biblioteca";
$cssFile = "I";
include __DIR__ . '/layout/header.php';

$libros = $listaDeLibros ?? [];

$totUsuarios = $totalUsuariosExistentes ?? 0;
$totLibros = $totalLibrosExistentes ?? 0;
$totPrestamos = $totalPrestamosExistentes ?? 0;

$numLibrosDisp = $totalLibrosDisponibles ?? 0;
$numLibrosNoDisp = $totalLibrosNoDisponibles ?? 0;

$usuarioPrestamos = $prestamosDelUsuario ?? [];
?>
<section>
    <div class="stats">
        <div class="left-stats">
            <div>
                <h3>Usuarios registrados en la base de datos</h3>
                <p><?= $totUsuarios; ?></p>
            </div>
            <div>
                <h3>Total de préstamos existentes</h3>
                <p><?= $totPrestamos; ?></p>
            </div>
        </div>
        <div class="right-stats">
            <div>
                <h3>Total de libros en la base de datos</h3>
                <p><?= $totLibros; ?></p>
            </div>
            <div>
                <h3>Nº de libros sin prestar</h3>
                <p><?= $numLibrosDisp; ?></p>
            </div>
            <div>
                <h3>Nº de libros prestados</h3>
                <p><?= $numLibrosNoDisp; ?></p>
            </div>
        </div>

        <div class="libros-stats">
            <h3>Estado de los libros</h3>
            <?php if (isset($libros['error'])) { ?>
                <p class="error">Error al acceder a la base de datos:" <?= $libros['error']; ?> </p>
            <?php } ?>
            <?php foreach ($libros as $libro) { ?>
                <ul>
                    <li class="lista-libros <?= ($libro['disponibilidad']) ? "disponible" : "no-disponible" ?>"><?= $libro['titulo'] ?></li>
                </ul>
            <?php } ?>
        </div>
        <?php if (isset($_SESSION['user']) && !empty($usuarioPrestamos)) { ?>
            <div class="prestamo-stats">
                <h3>Preśtamos del usuario <?= $_SESSION['user']['nombre']; ?></h3>
                <?php
                foreach ($usuarioPrestamos as $prestamo) {
                    //  Definir la fecha límite. Si no existe, se usa la fecha de devolución normal
                    $limite = $prestamo['fecha_devolucion_limite'] ?? '';
                    //  Comparar hoy con la fecha límite para saber si hay retraso                    
                    $tieneMulta = date('Y-m-d') > $limite;
                ?>
                    <div class="prestamo-data <?= ($tieneMulta) ? "multa" : "sin_multa"; ?>">
                        <p>Libro: <span><?= $prestamo['titulo']; ?></span></p>
                        <p>Fecha de préstamo: <span><?= $prestamo['fecha_prestamo']; ?></span></p>
                        <p>Fecha límite: <span><?= $limite; ?></span></p>
                        <?php if ($tieneMulta) { ?>
                            <p>Multa a pagar: <span><?= $prestamo['multa']; ?></span></p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?php if (!isset($_SESSION['user'])) { ?>
        <div class="login-div">
            <p>Inicia sesión para gestionar esta biblioteca. <a href="index.php?action=login">Pincha aquí</a></p>
        </div>
    <?php } ?>
</section>
<?php
include __DIR__ . '/layout/footer.php';
?>
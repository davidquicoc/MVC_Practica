<?php
$tituloPagina = "Préstamos | Biblioteca";
$cssFile = "P";
include __DIR__ . '/../layout/header.php';

$prestamo_error = $_SESSION['prestamo-error'] ?? '';
$prestamo_mensaje = $_SESSION['prestamo-mensaje'] ?? '';

unset($_SESSION['prestamo-error']);
unset($_SESSION['prestamo-mensaje']);

$usuarioLoginPrestamos = $librosPrestados ?? [];
$prestamosExistentes = $prestamos ?? [];
?>
<section>
    <?php if (!empty($prestamo_error) || !empty($prestamo_mensaje)) { ?>
        <div class="div-mensaje">
            <?php if (!empty($prestamo_error)) { ?>
                <p class="mensaje error"><?= $prestamo_error; ?></p>
            <?php } elseif (!empty($prestamo_mensaje)) { ?>
                <p class="mensaje correcto"><?= $prestamo_mensaje; ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="data-div">
        <div class="user-data">
            <?php if (!empty($usuarioLoginPrestamos)) { ?>
                <h2>Libros prestados por el usuario '<span><?= $_SESSION['user']['nombre']; ?></span>'</h2>
                <ul>
                    <?php foreach ($usuarioLoginPrestamos as $librosUser) { ?>
                        <li><?= $librosUser['titulo']; ?> - <small>Devolver antes de: <?= $librosUser['fecha_devolucion']; ?></small></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>El usuario '<?= $_SESSION['user']['nombre'] ?>' no tiene ningún préstamo.</p>
            <?php } ?>
        </div>
        <div class="form-prestamo">
            <h2>Prestar libro</h2>
            <form method="POST" action="<?= BASE_PATH ?>/index.php?action=sacar-libro">
                <table>
                    <thead>
                        <tr>
                            <th><label for="usuario_id">Usuario</label></th>
                            <th><label for="libro_id">Libro</label></th>
                            <th><label for="fecha_prestamo">Fecha de préstamo</label></th>
                            <th><label for="fecha_devolucion">Fecha de devolución</label></th>
                            <th><label for="multa">Multa (€)</label></th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select id="usuario_id" name="usuario_id">
                                    <option value="">-- Elige un usuario --</option>
                                    <?php
                                    foreach ($usuariosActuales as $usuario) {
                                        if ($_SESSION['user']['id'] === $usuario['id']) {
                                    ?>
                                            <option value="<?= $usuario['id']; ?>" selected><?= $usuario['nombre']; ?></option>
                                        <?php   } else { ?>
                                            <option value="<?= $usuario['id']; ?>"><?= $usuario['nombre']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select id="libro_id" name="libro_id">
                                    <option value="">-- Elige un libro --</option>
                                    <?php foreach ($librosDisponibles as $libro) { ?>
                                        <option value="<?= $libro['id']; ?>"><?= $libro['titulo'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="date" name="fecha_prestamo" id="fecha_prestamo">
                            </td>
                            <td>
                                <input type="date" name="fecha_devolucion" id="fecha_devolucion">
                            </td>
                            <td>
                                <input type="number" name="multa" id="multa" step="0.01">
                            </td>
                            <td>
                                <div class="input-button">
                                    <input type="submit" value="Prestar libro">
                                    <input type="reset" value="Reiniciar">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="prestamos-existentes">
            <?php if (!empty($prestamosExistentes)) { ?>
                <h2>Préstamos existentes</h2>
                <?php foreach ($prestamosExistentes as $prestamo) { ?>
                    <div>
                        <p>Usuario: <span><?= $prestamo['nombre_usuario']; ?></span></p>
                        <p>Título del libro: <span><?= $prestamo['titulo_libro']; ?></span></p>
                        <p>Fecha de préstamo: <span><?= $prestamo['fecha_prestamo']; ?></span></p>
                        <p>Fecha de devolución: <span><?= $prestamo['fecha_devolucion']; ?></span></p>
                        <p>Multa: <span><?= $prestamo['multa']; ?> €</span></p>
                        <p>Estado: <span><?= ($prestamo['fecha_devolucion'] < date('Y-m-d')) ? "Retrasado" : "Prestado"; ?></span></p>
                        <form method="POST" action="<?= BASE_PATH ?>/index.php?action=devolver-libro">
                            <input type="hidden" name="prestamo_id" value="<?= $prestamo['prestamo_id']; ?>">
                            <input type="hidden" name="libro_id" value="<?= $prestamo['libro_id']; ?>">
                            <input type="submit" value="Devolver libro">
                        </form>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay préstamos registrados en la base de datos.</p>
            <?php } ?>
        </div>
    </div>
</section>
<?php
include __DIR__ . '/../layout/footer.php';
?>
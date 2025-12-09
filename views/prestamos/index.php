<?php
$tituloPagina = "Préstamos | Biblioteca";
$cssFile = "P";
include __DIR__ . '/../layout/header.php';
?>
<!--SEGUIR MÁS ADELANTE :D-->
<section>
    <?php if ($librosPrestados) { ?>
    <div class="user-data">
        <h2>Libros prestados por el usuario</h2>
    </div>
    <?php } ?>
    <div class="form">
        <h2>Prestar libro</h2>
        <table border="1">
            <thead>
                <tr>
                    <th><label for="usuario_id">Usuario</label></th>
                    <th><label for="libro_id">Libro</label></th>
                    <th><label for="fecha_prestamo">Fecha de préstamo</label></th>
                    <th><label for="fecha_devolucion">Fecha de devolución</label></th>
                    <th><label for="multa">Multa</label></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <form method="POST" action="index.php?action=sacar-libro">
            <tbody>
                    <tr>
                        <td>
                            <select id="usuario_id" name="usuario_id">
                                <option value="">-- Elige un usuario --</option>
                                <?php
                                    foreach($usuariosActuales as $usuario) {
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
                                <?php foreach($librosDisponibles as $libro) { ?>
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
            </form>
        </table>
    </div>
    <div class="prestamos-actuales">
        <?php foreach($prestamos as $prestamo) { ?>
        <div></div>
        <?php } ?>
    </div>
</section>
<?php
include __DIR__ . '/../layout/footer.php';
?>
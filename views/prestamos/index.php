<?php
$tituloPagina = "Préstamos | Biblioteca";
$cssFile = "P";
include __DIR__ . '/../layout/header.php';

$prestamo_error = $_SESSION['prestamo-error'] ?? '';
$prestamo_mensaje = $_SESSION['prestamo-mensaje'] ?? '';

unset($_SESSION['prestamo-error']);
unset($_SESSION['prestamo-mensaje']);

//  Devuele un string con el texto a mostrar
function obtenerEstado($limite, $aviso, $real = null) {
    //  Si pasamos la fecha real, usamos esa (historial). Si no, usamos HOY (pendientes).
    $fechaComparar = $real ?? date('Y-m-d');

    //  Convertir a segundos para restar
    $segundosLimite = strtotime($limite);
    $segundosComparar = strtotime($fechaComparar);

    //  Calcular la diferencia en días (86400 seg = 1 día)
    $diferenciaSegundos = $segundosComparar - $segundosLimite;
    $dias = floor(abs($diferenciaSegundos) / 86400);

    //  Le fecha actual (o devolución) es mayor al límite permitido
    if ($fechaComparar > $limite) {
        //  Si $real tiene valor (TRUE) -> Es historial, el libro se devolvío tarde
        //  Si $real es null (FALSE -> Está pendiente, el límite está superado ahora mismo
        return $real ? "Tarde ($dias días)" : "Límite superado ($dias días)";
    } elseif ($fechaComparar > $aviso && !$real) {
        //  Esta en el tiempo de aviso si no se ha devuelto aún
        return "Devolver pronto";
    }
    //  No se pasó del límite
    //  Si $dias = 0 (TRUE) -> Se devuelve justo en la fecha límite
    //  Si $dias > 0 (FALSE) -> Se devuelve con antelación.
    return ($dias == 0) ? "Justo a tiempo" : "A tiempo ($dias días antes)";
}

$misPrestamos = $usuarioLoginPrestamos ?? [];
$pendientes = $prestamosPendientes ?? [];
$historial = $prestamosHistorial ?? [];
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
            <?php if (!empty($misPrestamos)) { ?>
                <h2>Libros prestados por el usuario '<span><?= $_SESSION['user']['nombre']; ?></span>'</h2>
                <ul>
                    <?php foreach ($misPrestamos as $mp) { ?>
                        <li><?= $mp['titulo']; ?> - <small>Devolver antes de: <?= $mp['fecha_devolucion_limite']; ?></small></li>
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
                            <th><label for="fecha_devolucion_limite">Fecha límite de devolución</label></th>
                            <th><label for="multa">Multa (€)</label></th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select id="usuario_id" name="usuario_id">
                                    <option value="">-- Elige un usuario --</option>
                                    <?php foreach ($usuariosActuales as $usuario) { ?>
                                        <option value="<?= $usuario['id']; ?>" <?= ($_SESSION['user']['id'] == $usuario['id']) ? 'selected' : '' ?>><?= $usuario['nombre']; ?></option>
                                    <?php } ?>
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
                                <input type="date" name="fecha_prestamo" id="fecha_prestamo" required>
                            </td>
                            <td>
                                <input type="date" name="fecha_devolucion" id="fecha_devolucion" required>
                            </td>
                            <td>
                                <input type="date" name="fecha_devolucion_limite" id="fecha_devolucion_limite" required>
                            </td>
                            <td>
                                <input type="number" name="multa" id="multa" step="0.01" min="0.01" max="99999.99" required>
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
            <?php if (!empty($pendientes)) { ?>
                <h2>Préstamos existentes</h2>
                <?php foreach ($pendientes as $pend) {
                    //  Se calcula el estado con la fecha de hoy y el límite
                    $estado = obtenerEstado(
                        $pend['fecha_devolucion_limite'],
                        $pend['fecha_devolucion']
                    );
                ?>
                    <div>
                        <p>Usuario: <span><?= $pend['nombre_usuario']; ?></span></p>
                        <p>Título del libro: <span><?= $pend['titulo_libro']; ?></span></p>
                        <p>Fecha de préstamo: <span><?= $pend['fecha_prestamo']; ?></span></p>
                        <p>Fecha de devolución: <span><?= $pend['fecha_devolucion']; ?></span></p>
                        <p>Fecha límite de devolución: <span><?= $pend['fecha_devolucion_limite']; ?></span></p>
                        <p>Multa: <span><?= $pend['multa']; ?> €</span></p>
                        <p>Estado: <span><?= $estado; ?></span></p>
                        <?php
                            $fechaHoy = date('Y-m-d');
                            if ($pend['usuario_id'] == $_SESSION['user']['id']) {
                                if ($fechaHoy >= $pend['fecha_devolucion']) { ?>
                        <form method="POST" action="<?= BASE_PATH ?>/index.php?action=devolver-libro">
                            <input type="hidden" name="prestamo_id" value="<?= $pend['id']; ?>">
                            <input type="hidden" name="libro_id" value="<?= $pend['libro_id']; ?>">
                            <input type="hidden" name="multa" value="<?= $pend['multa']; ?>">
                            <input type="submit" value="Devolver libro">
                        </form>
                            <?php } else { ?>
                                <div class="message-otro-usuario">
                                    <p><span>Aún falta para que devuelvas el libro. (<?= $pend['fecha_devolucion']; ?>).</span></p>
                                </div>
                        <?php
                                }
                            } else {
                                $usuarioAct = '';
                                foreach ($usuariosActuales as $usuario) {
                                    if ($pend['usuario_id'] === $usuario['id']) {
                                        $usuarioAct = $usuario['nombre'];
                                        break;
                                    }
                                }
                        ?>  
                        <div class="message-otro-usuario">
                            <p><span>Está logueado con el usuario <?= $_SESSION['user']['nombre']; ?>. <?= empty($usuarioAct) ? '' : 'Debe iniciar sesión con el usuario ' . $usuarioAct; ?><span>.</p>
                        </div>
                        <?php }?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay préstamos activos en este momento.</p>
            <?php } ?>
        </div>
    </div>
    <div class="devolucion-div">
        <h2>Historial de devoluciones</h2>
        <?php if (!empty($historial)) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Usuario</th>
                        <th>Fecha límite de devolución</th>
                        <th>Fecha de devolución</th>
                        <th>Estado</th>
                        <th>Multa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $h) { 
                        // Calculamos estado comparando fecha real vs límite
                        $estado = obtenerEstado($h['fecha_devolucion_limite'], $h['fecha_devolucion'], $h['fecha_devuelto']);
                    ?>
                        <tr class="fila-normal">
                            <td><?= $h['titulo_libro'] ?></td>
                            <td><?= $h['nombre_usuario'] ?></td>
                            <td><?= $h['fecha_devolucion_limite'] ?></td>
                            <td><?= $h['fecha_devuelto'] ?></td>
                            <td style="font-weight:bold;"><?= $estado; ?></td>
                            <td><?= number_format($h['multa'], 2) . ' €' ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aún no hay historial de devoluciones.</p>
        <?php } ?>
    </div>
</section>
<?php
include __DIR__ . '/../layout/footer.php';
?>
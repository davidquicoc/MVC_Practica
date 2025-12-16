<?php
$tituloPagina = "Libros | Biblioteca";
$cssFile = "L";
include __DIR__ . '/../layout/header.php';
?>
<?php
$libro_mensaje = $_SESSION['libro-mensaje'] ?? '';
$libro_error = $_SESSION['libro-error'] ?? '';

unset($_SESSION['libro-mensaje']);
unset($_SESSION['libro-error']);

$libros = $listaLibros ?? [];
$hayLibros = !empty($libros);

if (isset($libros['error'])) {
    echo "<p class='libros-error-text'>Error al acceder a la base de datos:" . $libros['error'] . "</p>";
    include __DIR__ . '/../layout/footer.php';
    exit();
}

?>
<section class="section-libros">
    <div class="mensajes-libros">
        <?php
        if (!empty($libro_mensaje)) {
            echo "<p class='mensaje correcto'>$libro_mensaje</p>";
        } elseif (!empty($libro_error)) {
            echo "<p class='mensaje error'>$libro_error</p>";
        }
        ?>
    </div>

    <div class="list-libros">
        <h2>Listado de libros</h2>
        <table>
            <thead>
                <tr>
                    <th>
                        <span class="table-tit">Título</span>
                    </th>
                    <th>
                        <span class="table-tit">Autor</span>
                    </th>
                    <th>
                        <span class="table-tit">Editorial</span>
                    </th>
                    <th>
                        <span class="table-tit">Género</span>
                    </th>
                    <th>
                        <span class="table-tit">Año de publicación</span>
                    </th>
                    <th>
                        <span class="table-tit">Nº páginas</span>
                    </th>
                    <th>
                        <span class="table-tit">Estado</span>
                    </th>
                    <th>
                        <span class="table-tit">Acciones</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($hayLibros) {
                    foreach ($libros as $libro) {
                        echo "<tr>";
                        echo "<td> " . $libro['titulo'] . "</td>";
                        echo "<td>" . $libro['autor'] . "</td>";
                        echo "<td>" . $libro['editorial'] . "</td>";
                        echo "<td>" . $libro['genero'] . "</td>";
                        echo "<td>" . $libro['año_publicacion'] . "</td>";
                        echo "<td>" . $libro['n_paginas'] . "</td>";
                        echo "<td>";
                        if ($libro['prestamos_pendientes'] > 0) {
                            echo "<span class='estado-en-uso'>En uso</span>";
                        } else {
                            echo "<span class='estado-disponible'>Disponible</span>";
                        }
                        echo"</td>";
                        echo "<td>";
                            echo "<div class='button-libro'>
                                <form method='POST' action='" . BASE_PATH . "/index.php?action=modify-book'>
                                    <input type='hidden' value='" . $libro['id'] . "' name='id'>
                                    <input type='hidden' value='" . $libro['titulo'] . "' name='titulo'>
                                    <input type='hidden' value='" . $libro['autor'] . "' name='autor'>
                                    <input type='hidden' value='" . $libro['editorial'] . "' name='editorial'>
                                    <input type='hidden' value='" . $libro['genero'] . "' name='genero'>
                                    <input type='hidden' value='" . $libro['año_publicacion'] . "' name='año_publicacion'>
                                    <input type='hidden' value='" . $libro['n_paginas'] . "' name='n_paginas'>
                                    <input type='submit' value='Editar'>
                                </form>";
                            if ($libro['prestamos_pendientes'] == 0) {
                                echo "<form method='POST' action='" . BASE_PATH . "/index.php?action=delete-book'>
                                        <input type='hidden' name='id' value='" . $libro['id'] . "'>
                                        <input type='submit' value='Borrar'>
                                    </form>";
                            }
                            echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>
                            <td colspan='8' class='error-bd'>
                                No hay libros en la base de datos
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="link-create">
        <a href="<?= BASE_PATH ?>/index.php?action=add-book">Crear libro</a>
    </div>
</section>
<?php
include __DIR__ . '/../layout/footer.php';
?>
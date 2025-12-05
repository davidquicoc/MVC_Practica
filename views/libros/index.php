<?php
$tituloPagina = "Libros | Biblioteca";
$cssFile = "L";
$booleanLibros = true;
include __DIR__ . '/../layout/header.php';
?>
<?php
if (isset($libros['error'])) {
    echo "<p class='libros-error-text'>Error al acceder a la base de datos:" . $libros['error'] . "</p>";
    include __DIR__ . '/../layout/footer.php';
    exit();
}

if (empty($libros) && !isset($libros['error'])) {
    echo "<p>No hay libros en la base de datos.</p>";
    $booleanLibros = false;
}
?>
<section class="section-libros">
    <div class="mensajes-libros">
        <?php
            if (isset($_SESSION['libro-mensaje'])) {
                echo "<p class='mensaje-correcto'>" . $_SESSION['libro-mensaje'] .  "</p>";
            } elseif (isset($_SESSION['libro-error'])) {
                echo "<p class='mensaje-erroneo'>" . $_SESSION['libro-error'] .  "</p>";
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
                        <span class="table-tit">&nbsp;</span>
                    </th>
                </tr>
            </thead>
            <?php
                if ($booleanLibros) {
                    echo "<tbody>";
                    foreach($libros as $libro) {
                        echo "<tr>";
                            echo "<td> " . $libro['titulo'] . "</td>";
                            echo "<td>" . $libro['autor'] . "</td>";
                            echo "<td>" . $libro['editorial'] . "</td>";
                            echo "<td>" . $libro['genero'] . "</td>";
                            echo "<td>" . $libro['año_publicacion'] . "</td>";
                            echo "<td>" . $libro['n_paginas'] . "</td>";
                            echo "<td>";
                                echo "
                                    <div class='button-libro'>
                                        <form method='POST' action='index.php?action=modify-book'>
                                            <input type='hidden' value='" . $libro['id'] . "' name='id'>
                                            <input type='hidden' value='" . $libro['titulo'] . "' name='titulo'>
                                            <input type='hidden' value='" . $libro['autor'] . "' name='autor'>
                                            <input type='hidden' value='" . $libro['editorial'] . "' name='editorial'>
                                            <input type='hidden' value='" . $libro['genero'] . "' name='genero'>
                                            <input type='hidden' value='" . $libro['año_publicacion'] . "' name='año_publicacion'>
                                            <input type='hidden' value='" . $libro['n_paginas'] . "' name='n_paginas'>
                                            <input type='submit' value='Editar'>
                                        </form>
                                        <form method='POST' action='index.php?action=delete-book'>
                                            <input type='hidden' name='id' value='" . $libro['id'] . "'>
                                            <input type='submit' value='Borrar'>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                }
            ?>
            <tfoot>
                <tr>
                    <td colspan="7">Biblioteca &copy;&nbsp;<?= date('Y'); ?></td>
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
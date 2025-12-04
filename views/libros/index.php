<?php
$tituloPagina = "Libros | Biblioteca";
$cssFile = "L";
include __DIR__ . '/../layout/header.php';
?>

<h2>Listado de libros</h2>

<?php
if (isset($libros['error'])) {
    echo "<p class='libros-error-text'>Error al acceder a la base de datos:" . $libros['error'] . "</p>";
    include __DIR__ . '/../layout/footer.php';
    exit();
}

if (empty($libros) && !isset($libros['error'])) {
    echo "<p>No hay libros en la base de datos.</p>";
}
?>
<table border="1">
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
    <tbody>
        <tr></tr>
    </tbody>
</table>
<br><br>
<hr>
<br><br>
<section class="section-libros">
    <div class="libros-container">
        <div class="create-libro">
            <form class="create-libro-form" method="POST" action="index.php?action=create-libro">
                <div>
                    <label for="titulo">Titulo:</label>
                    <input type="text" name="titulo" id="titulo" required>
                </div>
                <div>
                    <label for="autor">Autor:</label>
                    <input type="text" name="autor" id="autor" required>
                </div>
                <div>
                    <label for="editorial">Editorial:</label>
                    <input type="text" name="editorial" id="editorial" required>
                </div>
                <div>
                    <label for="genero">Género:</label>
                    <input type="text" name="genero" id="genero" required>
                </div>
                <div>
                    <label for="año_publicacion">Año de publicación:</label>
                    <input type="number" name="año_publicacion" id="año_publicacion" max="<?= date('Y'); ?>" required>
                </div>
                <div>
                    <label for="n_paginas">Número de páginas:</label>
                    <input type="number" name="n_paginas" id="n_paginas" required>
                </div>
                <div>
                    <label for="isbn">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" required>
                </div>
                <div>
                    <input type="submit" value="Crear">
                </div>
            </form>
        </div>
    </div>
</section>
<!--<div class="table-libros">
    <div class="libros-header">
        <div class="libro-cell">Título</div>
        <div class="libro-cell">Autor</div>
        <div class="libro-cell">Editorial</div>
        <div class="libro-cell">Género</div>
        <div class="libro-cell">Año de publicación</div>
        <div class="libro-cell">Nº páginas</div>
        <div class="libro-cell">&nbsp;</div>
    </div>
    <form method="POST" action="libros.php?action=create">
    <div class="libros-create">
            <div class="libro-cell">
                <label for="titulo">Titulo:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <div class="libro-cell">
                <label for="autor">Autor:</label>
                <input type="text" name="autor" id="autor" required>
            </div>
            <div class="libro-cell">
                <label for="editorial">Editorial:</label>
                <input type="text" name="editorial" id="editorial" required>
            </div>
            <div class="libro-cell">
                <label for="genero">Género:</label>
                <input type="text" name="genero" id="genero" required>
            </div>
            <div class="libro-cell">
                <label for="año_publicacion">Año de publicación:</label>
                <input type="number" name="año_publicacion" id="año_publicacion" max="<?= date('Y'); ?>" required>
            </div>
            <div class="libro-cell">
                <label for="n_paginas">Número de páginas:</label>
                <input type="number" name="n_paginas" id="n_paginas" required>
            </div>
            <div class="libro-cell">
                <input type="submit" value="Crear">
            </div>
        </div>
    </form>
    <?php
    /*if (!empty($libros) && !isset($libros['error'])) {
        foreach ($libros as $libro) {
            echo "<div class='libros-edit'>";
            echo "<div class='libro-cell'>" . $libro['titulo'] . "</div>";
            echo "<div class='libro-cell'>" . $libro['autor'] . "</div>";
            echo "<div class='libro-cell'>" . $libro['editorial'] . "</div>";
            echo "<div class='libro-cell'>" . $libro['genero'] . "</div>";
            echo "<div class='libro-cell'>" . $libro['año_publicacion'] . "</div>";
            echo "<div class='libro-cell'>" . $libro['n_paginas'] . "</div>";
            echo "<div class='libro-cell'>&nbsp;</div>";
            //  FORMULARIO DE EDITAR
            echo "<form method='POST' action='libros.php?action=edit'>";
            echo "<input type='hidden' value='" . $libro['titulo'] . "' name='titulo'>";
            echo "<input type='hidden' value='" . $libro['autor'] . "' name='autor'>";
            echo "<input type='hidden' value='" . $libro['editorial'] . "' name='editorial'>";
            echo "<input type='hidden' value='" . $libro['genero'] . "' name='genero'>";
            echo "<input type='hidden' value='" . $libro['año_publicacion'] . "' name='año_publicacion'>";
            echo "<input type='hidden' value='" . $libro['n_paginas'] . "' name='n_paginas'>";
            if (isset($libro['id'])) {
                echo "<input type='hidden' name='id' value='" . $libro['id'] . "'>";
            }
            echo "<input type='submit' value='Editar'>";
            echo "</form>";
            //  FORMULARIO DE BORRAR
            if (isset($libro['id'])) {
                echo "<form method='POST' action='libros.php?action=erase'>";
                echo "<input type='hidden' name='id' value='" . $libro['id'] . "'>";
                echo "<input type='submit' value='Borrar'>";
                echo "</form>";
            }
            echo "</div>";
            echo "</div>";
        }
    }
    */ ?>
    -->
</div>
<?php
include __DIR__ . '/../layout/footer.php';
?>
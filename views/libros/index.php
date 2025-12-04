<?php
    $tituloPagina = "Libro | Biblioteca";
    include __DIR__ . '/../layout/header.php';
?>

<h2>Listado de libros</h2>

<?php
    if (isset($libros['error'])) {
        echo "<p class='error-text'>Error al acceder a la base de datos:" . $libros['error'] . "</p>";
    }
    
    if (empty($libros) && !isset($libros['error'])) {
        echo "<p>No hay libros en la base de datos.</p>";
    }
?>  
    <div class="button-create">
        <a href="libros.php?action=create">Crear libro</a>
    </div>
    <div class="table">
        <div class="row-header">
            <div class="cell">Título</div>
            <div class="cell">Autor</div>
            <div class="cell">Editorial</div>
            <div class="cell">Género</div>
            <div class="cell">Año de publicación</div>
            <div class="cell">Nº páginas</div>
            <div class="cell">&nbsp;</div>
        </div>
        <?php
            if (!empty($libros) && !isset($libros['error'])) {
                foreach ($libros as $libro) {
                    echo "<div class='row-edit'>";
                    echo "<div class='cell'>" . $libro['titulo'] . "</div>";
                    echo "<div class='cell'>" . $libro['autor'] . "</div>";
                    echo "<div class='cell'>" . $libro['editorial'] . "</div>";
                    echo "<div class='cell'>" . $libro['genero'] . "</div>";
                    echo "<div class='cell'>" . $libro['año_publicacion'] . "</div>";
                    echo "<div class='cell'>" . $libro['n_paginas'] . "</div>";
                    echo "<div class='cell'>&nbsp;</div>";
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
                    echo "</div>";
                    echo "</div>";
                }
            } 
        ?>
        </div>
    </div>
<?php
    include __DIR__ . '/../layout/footer.php';
?>
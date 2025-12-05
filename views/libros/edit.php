<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de libros | Biblioteca</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/libro-form.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="index.php?action=edit-book">
            <h2>Editar libro "<?= $_POST['titulo']; ?>" (<?= $_POST['id']; ?>)</h2>
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" value="<?= $_POST['titulo']; ?>" required>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?= $_POST['autor']; ?>" required>
            <label for="editorial">Editorial:</label>
            <input type="text" name="editorial" id="editorial" value="<?= $_POST['editorial']; ?>" required>
            <label for="genero">Género:</label>
            <input type="text" name="genero" id="genero" value="<?= $_POST['genero']; ?>" required>
            <label for="año_publicacion">Año de publicación:</label>
            <input type="number" name="año_publicacion" id="año_publicacion" max="<?= date('Y'); ?>" value="<?= $_POST['año_publicacion']; ?>" required>
            <label for="n_paginas">Número de páginas:</label>
            <input type="number" name="n_paginas" id="n_paginas" value="<?= $_POST['n_paginas']; ?>" required>
            <div class="button-block">
                <input type="submit" value="Acceder">
                <a href="index.php?action=libros">Volver a libros</a>
            </div>
        </form>
    </div>
</body>
</html>
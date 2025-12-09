<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="index.php?action=sacar-libro">
            <h2>Sacar libro</h2>
            <label for="usuario_id">ID de usuario:</label>
            <select name="usuario_id">
                <option value="" selected>== Ellige un usuario ==</option>
            </select>
            <label for="libro_id">ID de libro:</label>
            <select name="libro_id">
                <option value="" selected>== Ellige un libro ==</option>
            </select>
            <label for="fecha_prestamo">Fecha de préstamo:</label>
            <input type="date" name="fecha_prestamo" id="fecha_prestamo" required>
            <label for="fecha_devolucion">Fecha de devolución:</label>
            <input type="date" name="fecha_devolucion" id="fecha_devolucion" required>
            <label for="multa">Multa:</label>
            <input type="number" name="multa" id="multa" step="0.01">
            <div class="button-block">
                <input type="submit" value="Sacar libro">
                <a href="index.php?action=prestamos">Volver a préstamos</a>
            </div>
        </form>
    </div>
</body>
</html>
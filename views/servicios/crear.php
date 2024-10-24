<h1 class="titulo-pagina">Servicio Nuevo</h1>
<p class="descripcion-pagina">Crear un nuevo servicio</p>

<?php include_once __DIR__ . '../../templates/alertas.php'   ?>

    <form action="/servicios/crear" class="formulario" method="POST">
            <?php include_once __DIR__ . '/formulario.php' ?>
        
            <input class="boton" type="submit" value="Guardar servicio">
    </form>
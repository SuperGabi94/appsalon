<h1 class="titulo-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Actualizar un servicio existente</p>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<?php include_once __DIR__ . '../../templates/alertas.php'   ?>

    <form class="formulario" method="POST">
            <?php include_once __DIR__ . '/formulario.php' ?>
        
            <input class="boton" type="submit" value="Actualizar servicio">
    </form>
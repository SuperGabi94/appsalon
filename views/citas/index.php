<h1 class="nombre-pagina">Crear nueva cita</h1>
<?php  include_once __DIR__ . '/../templates/barra.php' ?>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div id="app">

    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre"> Tu Nombre</label>
                <input 
                    type="text"
                    class="disabled"
                    id="nombre"
                    placeholder="Coloca tu nombre"
                    value="<?php echo $usuario -> nombre ?>" 
                    disabled
                    >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    min= "<?php echo date('Y-m-d', strtotime('+1 day')) ?>" 
                   
                    >
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora"
                   
                    >
            </div>
            <input type="hidden" id="id" value="<?php echo $usuario -> id ?>">; 
        </form>
        
    </div>
    <div id="paso-3" class="seccion contenido-resumen" >
        <h2 >Resumen</h2>
        <p class="text-center " >Verifica que la infromacion sea correcta</p>
        
    </div>
    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
        >&laquo; Anterior</button>
  
        <button
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button>
    </div>
</div>



<?php $script = "
    <script src='build/js/app.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

";  ?>

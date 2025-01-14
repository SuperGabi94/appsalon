<h1 class="titulo-pagina">Servicios</h1>
<p class="descripcion-pagina">Panel de administración de los servicios</p>
<?php

use Model\Servicio;

 $mensaje = $_GET['mensaje'] ?? ''; 
    if($mensaje) {
        Servicio::setAlerta('exito', 'Eliminado correctamente');  
        $alertas = Servicio::getAlertas(); 
    }
?>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<?php include_once __DIR__ . '../../templates/alertas.php'   ?>

<ul class="servicios">
<?php foreach($servicios as $servicio) { ?>

   
        <li>
            <p>Nombre: <span> <?php echo $servicio -> nombre; ?> </span> </p>
            <p>Precio: <span>$<?php echo $servicio -> precio; ?> </span> </p>
            <div class="acciones">
                <a href="/servicios/actualizar?id=<?php echo $servicio -> id ?>" class="boton">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio -> id ?>">
                    <input type="submit" value="Eliminar" class="boton-eliminar">
                </form>
                
            </div>
        </li>

<?php } ?>
</ul>


<h1 class="nombre-pagina">Panel de administración</h1>
<?php  include_once __DIR__ . '/../templates/barra.php' ?>
<h2>Buscar citas</h2>
<div class="busqueda">
    
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input  type="date" 
                    id="fecha"
                    name="fecha"
                    value="<?php echo $fecha; ?>"
                    >
                    
        </div>
    </form>
    <?php if(count($citas) === 0 ) {
        echo "<h3>No hay citas para esta fecha</h3>";
    } ?>
</div>

<div id="citas-admin">
    <ul class="citas">

        <?php $idCitas = 0; foreach($citas as $key => $cita) { 
            
            if($idCitas !== $cita -> id) { 
                
                $idCitas = $cita ->id;
                $total = 0; 
                ?>


            <li>
                <p>ID: <span><?php echo $cita -> id ?></span></p>
                <p>Hora: <span><?php echo $cita -> hora ?></span></p>
                <p>Cliente: <span><?php echo $cita -> cliente ?></span></p>
                <p>Teléfono: <span><?php echo $cita -> telefono ?></span></p>
            
            <h3>Servicios</h3>
            
            
           
                
      <?php   } 
        $total  += $cita -> precio;
      ?> 
        <p class="servicio"><?php echo $cita -> servicio . ' $' .  $cita -> precio?></p>

      <?php   
      $actual = $cita -> id; 
      $proximo = $citas[$key + 1]->id ?? 0; 
      
      if(esUltimo($actual, $proximo)) {
        
        echo "<p class='total'>Total: <span>$$total </span></p>";
        ?>

      <form action='/eliminar' method="POST">
      <input type='hidden' name='id' value = <?php echo $cita -> id?>> 
      <input type='submit'  value = 'Eliminar cita' class='boton-eliminar'> 
    </form>
      <?php 
      }
 
      
    
    } 
        
                
      ?>

      
    </ul>
    
</div>


<?php $script = '<script src="build/js/buscador.js"></script>' ?>
<h1 class="titulo-pagina">Reestablece tu contraseña</h1>
<p class="descripcion-pagina">LLena el siguiente formulario para camiar tu contraseña</p> 
<?php include_once __DIR__ . '/../templates/alertas.php'  ?>

<?php if($error) {
    return null;
}  ?>

<form class="formulario" method="POST">
    <div class="campo">
    <label for="password" id="password"> Nueva Contraseña</label>
    <input type="password"
           name="password"
           id="password"
        placeholder="Contraseña"
    >
    </div>
    
    <input type="submit" class="boton" value="Reestablecer" >
</form>
<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Aun no tienes cuenta? Crear una</a>
</div>
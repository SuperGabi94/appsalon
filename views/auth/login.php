<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>
<?php include_once __DIR__ . '/../templates/alertas.php'  ?>
<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        placeholder="Tu Correo"
        name="email"
        id="email">
    </div>
    <div class="campo">
        <label for="password">Tu Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Contraseña"
        
        >
    </div>
    <input type="submit" value="Iniciar sesión" class="boton">

</form>

<div class="acciones">
    <a href="/crear-cuenta">Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>
<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Si olvidaste tu password, coloca tu email en el siguiente formulario y revisa tu correo para seguir las instrucciones</p>
<?php include_once __DIR__ . '/../templates/alertas.php'  ?>
<form action="/olvide" method="POST" class="formulario">
<div class="campo">
            <label for="email">E-mail</label>
            <input 
            type="email"
            placeholder="Tu Correo"
            name="email"
            id="email">
    </div>
    <input type="submit" class="boton" value="Recuperar cuenta">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Aun no tienes cuenta? Crear una</a>
</div>
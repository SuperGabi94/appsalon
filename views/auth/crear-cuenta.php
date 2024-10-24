<h1 class="nombre-pagina">Crea tu cuenta</h1>
<p class="descripcion-pagina">Puedes crear una cuenta llenando el siguiente formulario con tus datos</p>

<?php include_once __DIR__ . "../../templates/alertas.php"  ?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
            type="text"
            placeholder="Tu Nombre"
            name="nombre"
            id="nombre"
            value="<?php echo s($usuario -> nombre); ?>" 
            >
    </div>
    <div class="campo">
            <label for="apellido">Apellido</label>
            <input 
            type="text"
            placeholder="Tu Apellido"
            name="apellido"
            id="apellido"
            value="<?php echo s($usuario ->apellido); ?>" 
            >
    </div>
    <div class="campo">
            <label for="telefono">Teléfono</label>
            <input 
            type="tel"
             name="telefono"
            id="telefono"
            value="<?php echo s($usuario->telefono) ?>" 
            placeholder="Tu Telefono"
            >
    </div>
    <div class="campo">
            <label for="email">E-mail</label>
            <input 
            type="email"
            placeholder="Tu Correo"
            name="email"
            id="email"
            value="<?php echo s($usuario ->email); ?>" 
            />
            
    </div>
    <div class="campo">
            <label for="password">Contraseña</label>
            <input 
            type="password"
            placeholder="Tu Contraseña"
            name="password"
            id="password">
    </div>
    <input type="submit" value="Crear Cuenta" class="boton">

</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>
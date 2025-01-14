<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\ApiController;
use Controllers\AdminController;
use Controllers\CitasController;
use Controllers\LoginController;
use Controllers\ServiciosController;

$router = new Router();

//Inciar sesion 

$router -> get('/', [LoginController::class, 'login']); 
$router -> post('/', [LoginController::class, 'login']); 
$router -> get('/logout', [LoginController::class, 'logout']); 

//Recuperar Password
$router -> get('/olvide', [LoginController::class, 'olvide']); 
$router -> post('/olvide', [LoginController::class, 'olvide']); 
$router -> get('/recuperar', [LoginController::class, 'recuperar']); 
$router -> post('/recuperar', [LoginController::class, 'recuperar']); 

//Crear Cuenta:
$router -> get('/crear-cuenta', [LoginController::class, 'crear']); 
$router -> post('/crear-cuenta', [LoginController::class, 'crear']);

//Confirmar cuenta 
$router -> get('/confirmar-cuenta', [LoginController::class, 'confirmar']); 
$router -> get('/mensaje', [LoginController::class, 'mensaje']); 

//Area privada 

$router -> get('/citas', [CitasController::class, 'index']); 

//Area de administración
$router -> get('/admin', [AdminController::class, 'index']); 
$router -> post('/eliminar', [ApiController::class, 'eliminar']);



//API

$router -> get('/api/servicios', [ApiController::class, 'index']);
$router -> post('/api/cita', [ApiController::class, 'guardar']);

//CRUD DE SERVICIOS
$router -> get('/servicios', [ServiciosController::class, 'index']);
$router -> get('/servicios/crear', [ServiciosController::class, 'crear']);
$router -> post('/servicios/crear', [ServiciosController::class, 'crear']);
$router -> get('/servicios/actualizar', [ServiciosController::class, 'actualizar']);
$router -> post('/servicios/actualizar', [ServiciosController::class, 'actualizar']);
$router -> post('/servicios/eliminar', [ServiciosController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();


<?php 
namespace Controllers;

use Model\Usuario;
use MVC\Router;

class CitasController {

    public static function index(Router $router){
        session_start();
        isAuth();  
        $usuario = Usuario::where('email', $_SESSION['email']); 
        
    
        $router -> render('citas/index', [
            'usuario' => $usuario, 
            

        ]); 
    }
}
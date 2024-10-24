<?php 
namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $alertas = []; 

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST); 
            $alertas = $auth -> validarLogin(); 

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth -> email); 
                if($usuario){
                 if( $usuario -> comprobarPasswordAndVerificado($auth -> password)) {
                    
                    //Autenticar al usuario

                    session_start();

                    $_SESSION['id'] = $usuario ->id;
                    $_SESSION['email'] = $usuario -> email;
                    $_SESSION['nombre'] = $usuario -> nombre . " " . $usuario -> apellido;
                    $_SESSION['login'] = true;

                    if($usuario -> admin === "1") {
                        $_SESSION['admin'] = $usuario -> admin ?? null; 
                        header('Location: /admin');  
                    } else {
                        header('Location: /citas');  
                    }

                    
                 }


                } else {
                    Usuario::setAlerta('error', 'El email no se encuentra registrado'); 
                }
            }
            
        }

        $alertas = Usuario::getAlertas(); 
        $router -> render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        session_start(); 
        $_SESSION = []; 
        header('location:/'); 
    }

    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST); 

            $alertas = $auth -> validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth -> email ); 
                if($usuario && $usuario -> confirmado === "1" ) {
                    //Genera un token si el usuario existe y esta confirmado
                    $usuario -> crearToken();
                    $usuario -> guardar();

                    //Enviar email
                    $email = new Email($usuario -> nombre, $usuario -> email, $usuario -> token); 
                    $email -> enviarInstrucciones(); 

                    Usuario::setAlerta('exito', 'revisa tu email'); 
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado'); 
                }
            }

        }
        $alertas = Usuario::getAlertas();


        $router -> render('auth/olvide-password', [
            'alertas' => $alertas
        ]); 
    }

    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false; 
        $token = $_GET['token']; 
        $usuario = Usuario::where('token', $token); 
       

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'token no valido'); 
            $error = true; 
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);
            $alertas= $password -> validarPassword(); 

            if(empty($alertas)) {
            $password -> hashearPassword(); 
            $usuario -> password = $password -> password; 
            $usuario -> token = "0"; 
           $resultado = $usuario -> guardar(); 

           if($resultado) {
            header('location:/');
           }
            

            }
            
        }
       $alertas = Usuario::getAlertas();

        $router -> render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        $usuario = new Usuario; 
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
             
            $usuario -> sincronizar($_POST); 
            $alertas = $usuario -> validadNuevaCuenta(); 
           
            
            if(empty($alertas)) {
                $resultado = $usuario -> existeUsuario(); 

                if($resultado -> num_rows) {
                    $alertas = Usuario::getAlertas(); 
                } else {

                    $usuario -> hashearPassword();
                    //Crear token
                    $usuario -> crearToken(); 
                    
                    //Enviar Email 
                    $email = new Email($usuario -> nombre, $usuario -> email, $usuario -> token);
                    

                    //Confirmar cuenta 
                    $email -> confirmarCuenta();
                    //Guardar usuario 
                    $resultado = $usuario -> guardar();  
                    if($resultado) {
                        header('location: /mensaje?usuario=' . $usuario -> nombre); 
                    }
                    

                }
            }


        }
        
        
        $router -> render('auth/crear-cuenta', [
            'usuario' => $usuario, 
            'alertas' => $alertas 
        ]); 
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
       
       
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'El token no es valido'); 
        } else {

            $usuario -> confirmado = "1"; 
            $usuario -> token = "0";
            $usuario -> guardar();
            
            Usuario::setAlerta('exito', " Confirmaste correctamente tu cuenta" . $usuario -> nombre ); 
            

        }
        
        $alertas = Usuario::getAlertas(); 
        $router -> render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'usuario' => $usuario
            

        ]);



        
    }


    public static function mensaje( Router $router) {
        $usuario = $_GET['usuario']; 
        $router -> render('auth/mensaje', [
            'usuario' => $usuario
        ]); 
    }
}
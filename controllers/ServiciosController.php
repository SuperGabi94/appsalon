<?php 
namespace Controllers;

use Model\Servicio;
use Model\Usuario;
use MVC\Router;

class ServiciosController {
    public static function index(Router $router) {
        session_start();
        isAdmin();
        $servicios = Servicio::all();
        $usuario = Usuario::where('email', $_SESSION['email']); 
        $router -> render('servicios/index', [
            'usuario' => $usuario,
            'servicios' => $servicios

        ]); 
    }

    public static function crear(Router $router) {
        session_start();
        isAdmin();
        $servicio = new Servicio();
        $alertas = []; 
       
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> sincronizar($_POST); 
            $alertas = $servicio -> validar();
           

            if(empty($alertas)) {
              $resultado =  $servicio -> guardar(); 
              if($resultado){
                Servicio::setAlerta('exito', 'servicio agregado correctamente');
              }
            }

        }
        $alertas = Servicio::getAlertas();

        $usuario = Usuario::where('email', $_SESSION['email']); 
        $router -> render('servicios/crear', [
            'usuario' => $usuario, 
            'servicio' => $servicio,
            'alertas' => $alertas

        ]); 


    }

    public static function actualizar(Router $router) {
        session_start();
        isAdmin();
        $id = is_numeric($_GET['id']); 
        if(!$id){
            header('location: /servicios'); 
        }
        $servicio = Servicio::find($_GET['id']); 
        $alertas = [];
       
       
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> sincronizar($_POST);


            $alertas = $servicio -> validar();

            if(empty($alertas)) {
                $servicio -> guardar();
                header('location: /servicios'); 
            }  }
            

        $usuario = Usuario::where('email', $_SESSION['email']); 
        $router -> render('servicios/actualizar', [
            'usuario' => $usuario, 
             'servicio' => $servicio, 
             'alertas' => $alertas

        ]); 
    }

    public static function eliminar() {
        session_start(); 
        isAdmin();
        $id = $_POST['id']; 
       

        if(!is_numeric($id)){
            header('location: /servicios'); 
        }
        $servicio = Servicio::find($id); 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> eliminar(); 
            header('location: /servicios?mensaje=eliminado');
        }
    }

}
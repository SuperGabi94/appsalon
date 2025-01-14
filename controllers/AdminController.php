<?php namespace Controllers;

use Model\AdminCitas;
use MVC\Router;
use Model\Usuario;

class AdminController {
    public static function index(Router $router) {
    
        session_start(); 
        isAdmin();
        $fecha = $_GET['fecha'] ?? date('Y-m-d'); 
        $fechas= explode('-', $fecha);

   
            if( !checkdate($fechas[1], $fechas[2], $fechas[0]) ){
                header('Location: /404');
            } 
        

       
    
      
       

       
       
       //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $citas = AdminCitas::SQL($consulta); 
        

       $usuario = Usuario::where('email', $_SESSION['email']); 
       
       $router -> render('admin/index', [
            'usuario' => $usuario, 
            'citas' => $citas, 
            'fecha' => $fecha
        ]);
    }
}
<?php namespace Controllers;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;
use MVC\Router;

class ApiController {
    public static function index(Router $router){
        $servicios= Servicio::all();

        echo json_encode($servicios); 
    }

    public static function guardar() {

        $cita = new Cita($_POST); 
        $resultado = $cita -> guardar(); 
        $id = $resultado['id'];

       

        //Almacena la cita y el servicio 

        $idServicios = explode(',', $_POST['servicios']); 
        foreach($idServicios as $idServicio){
            $args = [
                'citaid' => $id, 
                'servicioid' => $idServicio
            ]; 
            $citasservicios = new CitasServicios($args); 
            $citasservicios -> guardar();
        }
        
   
    echo json_encode(['resultado' => $resultado]);


    }

    //Eliminar una cita 
    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; 
            $cita = Cita::find($id);
            $cita -> eliminar();

            header('location:' . $_SERVER['HTTP_REFERER']);
        }
        
       
    }
}
<?php 

namespace Model;


class Servicio extends ActiveRecord {
    //base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio']; 

    public $id; 
    public $nombre; 
    public $precio; 

    public function __construct($args = [] )
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar(){
        if(!$this -> nombre){
            self::$alertas['error'][] = 'Debes agregarle un nombre al nuevo servicio'; 
        }

        if(!$this -> precio){
            self::$alertas['error'][] = 'Debes añadir el precio al nuevo servicio'; 
        }

        if(!is_numeric($this -> precio)){
            self::$alertas['error'][] = 'Ingresa un precio valido'; 
        }

        return self::$alertas; 
    }
}
<?php 

namespace Model;


class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios'; 
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token' ];

    public $id; 
    public $nombre;
    public $apellido;
    public $email;
    public $password; 
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    
    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null; 
        $this -> nombre = $args['nombre'] ?? '';
        $this -> apellido = $args['apellido'] ?? '';
        $this -> email = $args['email'] ?? '';
        $this -> password = $args['password'] ?? '';
        $this -> telefono = $args['telefono'] ?? '';
        $this -> admin = $args['admin'] ?? 0;
        $this -> confirmado = $args['confirmado'] ?? 0;

    }

    public function validadNuevaCuenta() {
        if(!$this -> nombre) {
            self::$alertas['error'][] = 'Es obligatorio colocar tu nombre'; 
        }

        if(!$this -> apellido) {
            self::$alertas['error'][] = 'Es obligatorio colocar tu apellido'; 
        }

        if(!$this -> email) {
            self::$alertas['error'][] = 'Es obligatorio colocar tu email'; 
        }

        if(!$this -> password) {
            self::$alertas['error'][] = 'Es obligatorio colocar una contraseña'; 
        }

        if(strlen($this -> password < 6 )) {
            self::$alertas['error'][] = 'Es obligatorio que la contraseña tenga almenos 6 carácteres'; 
        }

        return self::$alertas; 
    }

    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this -> email . "' LIMIT 1"; 
        
        $resultado = self::$db->query($query); 
        
        if($resultado -> num_rows) {
            self::$alertas['error'][] = 'El correo ingresado ya se encuentra registrado'; 
            
        }

        return $resultado; 
        
    }

    public function hashearPassword(){
        $this -> password = password_hash($this -> password, PASSWORD_BCRYPT);

    }

    public function crearToken() {
        $this -> token = uniqid(); 
    }

    public function validarLogin() {
        if(!$this -> email) {
            self::$alertas['error'][] = 'Ingresa tu email para poder iniciar sesión';
        }

        if(!$this -> password) {
            self::$alertas['error'][] = 'Colocar tu contraseña es obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password) {
            self::$alertas['error'][] = 'Colocar un nuevo password es obligatorio'; 
        }

        if(strlen($this-> password)  < 6 ) {
            self::$alertas['error'][] = 'La contraseña debe de tener almenos 6 caracteres';
        }

        return self::$alertas;
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this-> password);
       
        if($this -> confirmado === '0' || !$resultado) {
            self::$alertas['error'][] = 'El password es incorrecto o el usuario no está confirmado'; 
        } else {
            return true; 
        }
    }


    public function validarEmail() {
        if(!$this -> email) {
            self::$alertas['error'][] = 'debes ingresar tu email'; 
        }
        
       return self::$alertas; 
    }


}
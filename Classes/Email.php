<?php 
namespace Classes; 
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    
    public $nombre; 
    public $email; 
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this -> nombre = $nombre; 
        $this -> email = $email; 
        $this -> token = $token; 
    }

    public function confirmarCuenta() {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        
        $mail -> setFrom('cuentas@appsalon.com'); 
        $mail -> addAddress('cuentas@appsalon.com', 'appsalon.com'); 
        $mail -> Subject = 'confirma tu cuenta'; 
        $mail -> isHTML(TRUE); 
        $mail -> CharSet = 'UTF-8'; 

        $contenido = "<html>"; 
        $contenido .= "<p><strong>Hola " . $this-> nombre; "</strong> Has Creado tu cuenta en Appsalon, solo debes confirmarla presionando el siguiente enlace: </p>"; 
        $contenido .= "<p>Presiona aquí </p> <a href='" . $_ENV['APP_URL']  ."confirmar-cuenta?token=" . $this -> token . "'>Confirmar Cuenta </a>";
        $contenido .= "</html>";
        $mail -> Body = $contenido; 
        $resultado = $mail->send(); 
        return $resultado; 
        




    }

    public function enviarInstrucciones() {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        
        $mail -> setFrom('cuentas@appsalon.com'); 
        $mail -> addAddress('cuentas@appsalon.com', 'appsalon.com'); 
        $mail -> Subject = 'Recupera tu cuenta en AppSalon'; 
        $mail -> isHTML(TRUE); 
        $mail -> CharSet = 'UTF-8'; 

        $contenido = "<html>"; 
        $contenido .= "<p><strong>Hola " . $this-> nombre . "</strong> Puedes recuperar tu cuenta en Appsalon, solo debes presionar el siguiente enlace y crear una nueva contraseña: </p>"; 
        $contenido .= "<p>Reestablecer Password </p> <a href='" . $_ENV['APP_URL']  ."/recuperar?token=" . $this -> token . "'> Presiona aquí </a>";
        $contenido .= "</html>";
        $mail -> Body = $contenido; 
        $resultado = $mail->send(); 
        return $resultado; 
        




    }


}
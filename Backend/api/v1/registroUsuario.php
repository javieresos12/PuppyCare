<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once ('../../resources/lib/MysqliDb.php');
    require_once ("../../resources/lib/mail/PHPMailer.php");
    require_once ("../../resources/lib/mail/Exception.php");
    require_once ("../../resources/lib/mail/OAuth.php");
    require_once ("../../resources/lib/mail/POP3.php");
    require_once ("../../resources/lib/mail/SMTP.php");
    require_once ("../../resources/lib/mail/PHPMailerAutoload.php");
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $email = $_POST["Email_"];
    $usuario = $_POST["Usuario_"];
    $contrasena = $_POST["Contrasena_"];
    $encrp = md5($contrasena);
    $stringtotken = $email.$contrasena.$usuario;
    $token = md5($stringtotken);
    $url = "http://localhost/puppycare/api/v1/validarEmail?token_=".$token;
    $db->where ("(Email = ? or Nombre_Usuario = ?)", Array($email,$usuario));
    $res = $db->get ("usuarios");
    if($db->count > 0){
        echo "Usuario ya existe";
    }else{
        $data = array("Nombre_Usuario"=> $usuario,
                      "Email"=> $email,
                      "Contraseña"=> $encrp,
                      "Token"=> $token,
                      "Pass_key" => $token);
        $bol = $db->insert("usuarios", $data);
        if($bol){
            $mail = new PHPMailer();
            //$mail->IsSMTP();
            $mail->CharSet="UTF-8";
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'soportebucompany@gmail.com';
            $mail->Password = 'Bucompany2017';
            $mail->SMTPAuth = true;
            $mail->From = 'soportebucompany@gmail.com';
            $mail->FromName = 'PuppyCare';
            $mail->AddAddress($email, $usuario);
            $mail->AddReplyTo("soportebucompany@gmail.com", 'Soporte');
            $mail->IsHTML(true);
            $mail->Subject    = "Activar Cuenta";
            $mail->AltBody    = "Activar cuenta para disfrutar más";
            $mail->Body    = "Active su cuenta en el siguiente Link ".$url;
            if(!$mail->Send()) {
                echo " ";
            } else {
                echo "Enviado";
            }  
        }else{
            echo "Error";
        }
    }
}else{
    header('location: ../../index');
}
    
?>
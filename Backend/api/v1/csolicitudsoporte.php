<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ind = "";
    $user = $_POST["user_"]; 
    $mensaje = $_POST["mensaje_"];
    require_once ('../../resources/lib/MysqliDb.php');
    require_once ("../../resources/lib/mail/PHPMailer.php");
    require_once ("../../resources/lib/mail/Exception.php");
    require_once ("../../resources/lib/mail/OAuth.php");
    require_once ("../../resources/lib/mail/POP3.php");
    require_once ("../../resources/lib/mail/SMTP.php");
    require_once ("../../resources/lib/mail/PHPMailerAutoload.php");
    session_start();
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    if(isset($_SESSION["Ind"])){
        $ind = $_SESSION["Ind"];
        $data = array("Id_usuario" => $ind,"Descripcion"=>$mensaje);
        $res = $db->insert("soporte", $data);
        if($res){
            $mail = new PHPMailer();
            $mail->CharSet="UTF-8";
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'soportebucompany@gmail.com';
            $mail->Password = 'Bucompany2017';
            $mail->From = $_SESSION["Email"];
            $mail->FromName = 'PuppyCare';
            $mail->AddAddress("soportebucompany@gmail.com", 'Soporte');
            $mail->AddReplyTo("wijurost@gmail.com", 'Soporte');
            $mail->IsHTML(true);
            $mail->Subject = "Soporte";
            $mail->AltBody    = "Soporte e incovenientes";
            $mail->Body    = $mensaje;
            if(!$mail->Send()){
                echo "error_";
            }else{
                echo "Enviado";
            }
        }else{
            echo "error";
        }
    }else{
        $db->where("Nombre_Usuario", $user);
        $res = $db->getOne("usuarios");
        if($db->count == 1){
            $ind = $res["Ind"];
            $email = $res["Email"];
            $datad = array("Id_usuario" => $ind, "Descripcion"=>$mensaje);
            $response = $db->insert("soporte", $datad);
            if($response){
                $mail = new PHPMailer();
            $mail->CharSet="UTF-8";
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'soportebucompany@gmail.com';
            $mail->Password = 'Bucompany2017';
            $mail->From = $email;
            $mail->FromName = 'PuppyCare';
            $mail->AddAddress("soportebucompany@gmail.com", 'Soporte');
            $mail->AddReplyTo("wijurost@gmail.com", 'Soporte');
            $mail->IsHTML(true);
            $mail->Subject = "Soporte";
            $mail->AltBody    = "Soporte e incovenientes";
            $mail->Body    = $mensaje;
            if(!$mail->Send()){
                echo "error_";
            }else{
                echo "Enviado";
            }
            }else{
                echo "error";
            }
        }else{
            echo "noexiste";
        }
        
        
    }
    
    
    
    
}else{
    header('location: ../../index');
}

?>
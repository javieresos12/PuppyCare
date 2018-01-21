<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ("../../resources/lib/mail/PHPMailer.php");
    require_once ("../../resources/lib/mail/Exception.php");
    require_once ("../../resources/lib/mail/OAuth.php");
    require_once ("../../resources/lib/mail/POP3.php");
    require_once ("../../resources/lib/mail/SMTP.php");
    require_once ("../../resources/lib/mail/PHPMailerAutoload.php");
    $email_re = $_POST["email_re_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Email", $email_re);
    $user = $db->getOne("usuarios");
    $usuario = $user['Nombre_Usuario'];
    $estado = $user['Estado'];
    $key = $user['Pass_key'];
    $url = "http://localhost/puppycare/restaurapass?token_=".$key;
    if($db->count == 1){
        if($estado == "Activado"){
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
            $mail->AddAddress($email_re, $usuario);
            $mail->AddReplyTo("soportebucompany@gmail.com", 'Soporte');
            $mail->IsHTML(true);
            $mail->Subject    = "Recupere Contraseña";
            $mail->AltBody    = "Recupere contraseña para seguir disfrutando";
            $mail->Body    = "Recupere su cuenta en el siguiente Link ".$url;
            if(!$mail->Send()) {
                echo "Error";
            } else {
                echo "Enviado";
            }

        }else{
            echo "No activo";
        }
    }else{
        echo "No existe";
    }
    

    }else{
        header('location: ../../index');
    }
    

?>
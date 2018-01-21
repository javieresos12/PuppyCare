<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST["usuario_"];
    $contrasena = $_POST["contrasena_"];
    $encrp = md5($contrasena);
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Nombre_Usuario", $usuario);
    $res = $db->get ("usuarios");
    if($db->count == 1){
        $db->where ("Nombre_Usuario", $usuario);
        $user = $db->getOne("usuarios");
        $estado = $user['Estado'];
        $inf = $user['Estado_Inf'];
        if($estado == "Eliminado"){
            echo "Eliminado";
        }else{
            if($estado == "NoActivado"){
                echo "NoActivado";
            }else{
                $db->where("Nombre_Usuario", $usuario);
                $db->where("Contraseña", $encrp);
                $res = $db->get ("usuarios"); 
                if($db->count == 1){
                    $_SESSION['Ind'] = $res[0]['Ind'];
                    $_SESSION['Nombre_Usuario'] = $res[0]['Nombre_Usuario'];
                    $_SESSION['Nombres'] = $res[0]['Nombres'];
                    $_SESSION['Apellidos'] = $res[0]['Apellidos'];
                    $_SESSION['Cedula'] = $res[0]['Cedula'];
                    $_SESSION['Telefono'] = $res[0]['Telefono'];
                    $_SESSION['Celular'] = $res[0]['Celular'];
                    $_SESSION['Email'] = $res[0]['Email'];
                    $_SESSION['Estado'] = $res[0]['Estado'];
                    $_SESSION['Estado_Inf'] = $res[0]['Estado_Inf'];
                    $_SESSION['Ciudad'] = $res[0]['Ciudad'];
                    $_SESSION['Estado_Conexion'] = "Conectado";
                    $_SESSION['Rol'] = $res[0]['Rol'];
                    echo "Correcta";
                }else{
                    echo "Errada";
                }   
            }
        }
    }else{
        echo "noexiste";
    }
    }else{
        header('location: ../../index');
    }
    
?>

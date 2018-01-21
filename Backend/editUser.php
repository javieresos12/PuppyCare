<?php 

    session_start();
    if(isset($_SESSION["Estado_Conexion"])){
        if($_SESSION['Rol'] == "Usuario"){
            header("location: dashboard");
        }else{
            include("views/editUsuarioView.php");
        }
    }else{
        header("location: index");
    }
   


?>


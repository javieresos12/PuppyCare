<?php 

session_start();
if (!isset($_SESSION['Estado_Conexion'])) {
    include("views/loginView.php");
}else{
    if($_SESSION['Rol'] == "Admin"){
        header("location: admin");
    }else{
        header("location: dashboard");
    }
    
}


?>


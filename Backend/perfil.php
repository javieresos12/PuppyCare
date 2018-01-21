<?php 
   
    session_start();
    if(isset($_SESSION["Estado_Conexion"])){
        include("views/editInfoUser.php");
        
    }else{
        header("location: index");
    }
    ?>
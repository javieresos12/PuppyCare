<?php 
   
    session_start();
    if(isset($_SESSION["Estado_Conexion"])){
        $adoptar = $_GET["id_"];
        //echo $adoptar;
        include("views/adoptarView.php");
    }else{
        header("location: index");
    }
    ?>
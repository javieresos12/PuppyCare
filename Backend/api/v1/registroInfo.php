<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST["cedula_"];
    $celular = $_POST["celular_"];
    $ciudad = $_POST["ciudad_"];
    $telefono = $_POST["telefono_"];
    $nombre = $_POST["Nombres_"];
    $apellido = $_POST["Apellidos_"];
    $id = $_POST["Ind_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $data = array("Nombres"=>$nombre, 
                "Apellidos" =>$apellido, 
                "Cedula"=>$cedula,
                "Telefono"=>$telefono,
                "Ciudad"=>$ciudad,
                "Celular"=>$celular, 
                "Estado_Inf"=> "Completo");

                    
    $db->where ("Cedula", $cedula);
    $res = $db->get ("usuarios");
    if($db->count == 1){
        echo "YaExiste";
    }else{
        $db->where ('Ind', $id);
        $res = $db->update('usuarios', $data);
        if($res){
            echo "Actualizado";
            $_SESSION['Estado_Inf'] = "Completo";
        }else{
            echo "Error";
        }
    }
}else{
    header('location: ../../index');
}    
    
?>
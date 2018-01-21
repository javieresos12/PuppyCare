<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["Ind_"];
    $nombre = $_POST["Nombres_"];
    $apellido = $_POST["Apellidos_"];
    $telefono = $_POST["telefono_"];
    $celular = $_POST["celular_"];
    $ciudad = $_POST["ciudad_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $data = array("Nombres"=>$nombre, 
                "Apellidos" =>$apellido, 
                "Telefono"=>$telefono,
                "Ciudad"=>$ciudad,
                "Celular"=>$celular, 
                );

    $db->where ("Ind", $id);
    $res = $db->update('usuarios', $data);
    if($res){
        echo "Actualizado";
    }else{
        echo "Error";
    }
}else{
    header('location: ../../index');
}
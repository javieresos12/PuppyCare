<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMascota = $_POST["idMascota_"];
    $idUsuario = $_POST["idUsuario_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $data = array("Id_mascota"=>$idMascota, 
                "Id_usuario" =>$idUsuario, 
                );
    $res = $db->insert('adopcion', $data);
    if($res){
        echo "insertado";
    }else{
        echo "Error";
    }
}else{
    header('location: ../../index');
}
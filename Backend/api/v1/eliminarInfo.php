<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ind = $_POST["Ind_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $data = array("Estado" => "Eliminado");
    $db->where("Ind", $ind);
    $res = $db->update("usuarios", $data);
    if($res){
        echo "eliminado";
    }else{
        echo "error";
    }
}else{
    header('location: ../../index');
}

?>
<?php 
    require_once ('../../resources/lib/MysqliDb.php');
    $token = $_GET["token_"];
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Token", $token);
    $user = $db->getOne("usuarios");
    $estado = $user['Estado'];
    if($estado == "Activado"){
        header('location: ../../resources/confirmado');
    }else{
        $data = array("Estado" => "Activado");
        $db->where('Token', $token);
        if ($db->update ('usuarios', $data)){
            header('Location: ../../resources/validado');
        }else{
            echo "0";
        }
    }
?>
<?php 

    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where("Estado", "Activado");
    $user = $db->get("usuarios");
    $arr = array("data" => $user);
    echo json_encode($arr);
    ?>
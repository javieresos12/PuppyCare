<?php 

    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $mascota = $db->get("mascotas");
    $arr = array("data" => $mascota);
    $response = json_encode($arr);
    echo $response;
    ?>
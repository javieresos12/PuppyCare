<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passkeyre = $_POST["pass_re_"];
    $encryp = md5($passkeyre);
    $tokenpasskey = $_POST["token_"];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Pass_key", $tokenpasskey);
    $data = array("Contraseña" => $encryp);
    $res = $db->update("usuarios", $data);
if($res){
    echo "exito";
}else{
    echo "error";
}
}else{
    header('location: ../../index');
}





?>
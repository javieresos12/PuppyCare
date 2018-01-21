<?php 
/*$usuario = $_POST["usuario_"];*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $usuario =  $body['usuario_'];
    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Nombre_Usuario", $usuario);
    $user = $db->getOne("usuarios");
    $response = json_encode($user);
    echo $response;
}else{
    echo "no";
}
//var_dump($user);
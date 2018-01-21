<?php 

    require_once ('../../resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $user = $db->rawQuery("SELECT sp.Ind, sp.Fecha_radicado, sp.Descripcion, us.Nombres, us.Apellidos, sp.Estado, sp.Respuesta FROM soporte AS sp, usuarios AS us WHERE sp.Id_usuario = us.Ind;");
    $arr = array("data" => $user);
    echo json_encode($arr);

?>
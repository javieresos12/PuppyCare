<?php 

require_once ('../../resources/lib/MysqliDb.php');
$db = new MysqliDb ('localhost', 'root', '', 'puppycare');
$user = $db->rawQuery("select ad.Ind, mc.Nombre, ad.Id_usuario, ad.Fecha_solicitud, ad.Estado from adopcion as ad, mascotas as mc, usuarios as us where ad.Id_mascota = mc.Ind and ad.Id_usuario = us.Ind;");
$arr = array("data" => $user);
echo json_encode($arr);
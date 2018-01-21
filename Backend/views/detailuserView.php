<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">
    <title>PuppyCare</title>
    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="resources/css/signin.css" rel="stylesheet">
</head>
<body>


<?php 
$id = $_GET["userid_"];
require_once("resources/lib/MysqliDb.php");
$db = new MysqliDb ('localhost', 'root', '', 'puppycare');
$db->where ("Ind", $id);
$res = $db->getOne("usuarios");
$Cedula = $res["Cedula"];
$Nombre = $res["Nombres"];
$Apellido = $res["Apellidos"];
$telefono = $res["Telefono"];
$celular = $res["Celular"]; 
$email = $res["Email"];
?>

<div class="container">
    <div class="form-group">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $Cedula; ?>">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $Nombre; ?>">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $Apellido; ?>">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $telefono; ?>">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $celular; ?>">
        <input type="text" class="form-control" readonly="readonly" placeholder="<?php echo $email; ?>">
    </div>
</div>
    
</body>
</html>
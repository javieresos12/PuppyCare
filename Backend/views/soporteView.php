
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="resources/css/datatables.css"/>
    <script type="text/javascript" src="resources/js/datatables.js"></script>
    <script type="text/javascript" src="resources/lib/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">
    <title>PuppyCare</title>
    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="resources/css/signin.css" rel="stylesheet">
    
</head>
<body>
<ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link" href="./">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="usuarios">Usuarios</a>
      </li>
      <li class="nav-item">
            <a class="nav-link" href="solicitudes">Solicitudes</a>
        </li>
      <li class="nav-item">
        <a class="nav-link" href="soporte">Soporte</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION["Nombre_Usuario"]; ?> </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="perfil">Perfil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout">Cerrar Sesion</a>
        </div>
      </li>
    </ul>
    
<div class="table-responsive col-sm-12">
<table id="tb_cliente" class="table table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Ind</th>
                <th>Fecha Solicitud</th>
                <th>Descripcion</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Estado</th>
                <th>Respuesta</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Ind</th>
                <th>Fecha Solicitud</th>
                <th>Descripcion</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Estado</th>
                <th>Respuesta</th>
            </tr>
        </tfoot>
    </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#tb_cliente').DataTable({
                "ajax":{
                    "method":"post",
                    "url": "api/v1/getSupport"

                },
                "columns":[
                    {"data": "Ind",
                     "render": function(data, type, row, meta){
                         if(type === 'display'){
                             data = '<a href="supportdetail?supportid_='+data+'">'+data+'</a>';
                         }
                         return data;
                     }},
                    {"data":"Fecha_radicado"},
                    {"data":"Descripcion"},
                    {"data":"Nombres"},
                    {"data":"Apellidos"},
                    {"data":"Estado"},
                    {"data":"Respuesta"}
                ]
            });
        } );
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
</body>
</html>
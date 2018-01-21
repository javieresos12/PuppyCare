<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="resources/lib/jquery-3.2.1.js">
    </script>
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">

    <title>PuppyCare</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="resources/css/signin.css" rel="stylesheet">
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["Estado_Conexion"])){
    ?>
        <div class="container">
            <div class="form-group">
                <h2>Radique su solicitud</h2>
                <label for="inputUsuario">Usuario</label>
                <input readonly="readonly" type="text" id="inputUsuario" placeholder="<?php echo $_SESSION["Nombre_Usuario"]; ?>" value="<?php echo $_SESSION["Nombre_Usuario"]; ?>">
                <br><br><label for="inputMensaje">Solicitud</label>
                <textarea class="form-control" rows="5" id="solicitud"></textarea>
                <br><br><button class="btn btn-primary" id="btnRadicar">Radicar Solicitud</button>
            </div>
        </div>
        <div class="alert alert-success" id="successI" role="alert">
            <strong>Bien Hecho!</strong> Información enviada.
         </div>
        <div class="alert alert-warning" id="emptyI" role="alert">
            <strong>Campos Vacios!</strong> Rellene los campos vacios.
        </div>
        <div class="alert alert-warning" id="errorI" role="alert">
            <strong>Se produjo un error</strong> Intentelo de nuevo.
        </div>
        <div class="alert alert-info" id="procesandoI" role="alert">
            <strong>Enviando</strong> por favor espere!.
        </div>
        <script>
            $("#btnRadicar").on("click", function(){
                var user = $("#inputUsuario").val();
                var mensaje = $("#solicitud").val();
                if(mensaje == ""){
                    $("#emptyI").css("display", "block");
                }else{
                    var parametros = {
                        "user_": user,
                        "mensaje_": mensaje
                    };
                    $.ajax({
                        data:parametros,
                        url:"api/v1/csolicitudsoporte.php",
                        type: 'post',
                        beforeSend:function(){
                            $("#procesandoI").css("display", "block");
                        },
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            });
        </script>

            <?php 

        }else{
            ?> 
            <div class="container">
            <div class="form-group">
                <h2>Radique su solicitud</h2>
                <label for="inputUsuariod">Usuario</label>
                <input type="text" id="inputUsuariod" placeholder="Ingrese usuario">
                <br><br><label for="inputMensaje">Solicitud</label>
                <textarea class="form-control" rows="5" id="solicitudd"></textarea>
                <br><br><button class="btn btn-primary" id="btnRadicard">Radicar Solicitud</button>
            </div>
        </div>
        <div class="alert alert-success" id="successId" role="alert">
            <strong>Bien Hecho!</strong> Información enviada.
         </div>
        <div class="alert alert-warning" id="emptyId" role="alert">
            <strong>Campos Vacios!</strong> Rellene los campos vacios.
        </div>
        <div class="alert alert-warning" id="errorId" role="alert">
            <strong>Se produjo un error</strong> Intentelo de nuevo.
        </div>
        <div class="alert alert-info" id="procesandoId" role="alert">
            <strong>Enviando</strong> por favor espere!.
        </div>
        <script>
            $("#btnRadicard").on("click", function(){
                var user = $("#inputUsuariod").val();
                var mensaje = $("#solicitudd").val();
                if(mensaje == "" || user == ""){
                    $("#emptyId").css("display", "block");
                }else{
                    var parametros = {
                        "user_": user,
                        "mensaje_": mensaje
                    };
                    $.ajax({
                        data:parametros,
                        url:"api/v1/csolicitudsoporte.php",
                        type: 'post',
                        beforeSend:function(){
                            $("#procesandoId").css("display", "block");
                        },
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            });
        </script>
            <?php
        }
    ?>

    <script>
        $(document).ready(function(){
            $("#successI").css("display", "none");
            $("#emptyI").css("display", "none");
            $("#errorI").css("display", "none");
            $("#procesandoI").css("display", "none");
            $("#successId").css("display", "none");
            $("#emptyId").css("display", "none");
            $("#errorId").css("display", "none");
            $("#procesandoId").css("display", "none");
        });
    </script>
</body>
</html>

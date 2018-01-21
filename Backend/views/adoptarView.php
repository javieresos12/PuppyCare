<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
        <div class="container">
            <div class="form-signin">
                <h2 class="form-signin-heading">Radicar Solicitud Adopcion</h2>
                <form method="post" id="formulario" enctype="multipart/form-data">
                    <label for="inputId" class="sr-only">Codigo mascota</label>
                    <input type="number" id="inputId" class="form-control" value="<?php /*echo $_GET["userid_"];*/ echo $adoptar; ?>" placeholder="<?php /*echo $_GET["Ind_"];*/ echo $adoptar; ?>" readonly="readonly" required autofocus>
                    <label for="inputNombre" class="sr-only">Nombres</label>
                    <input type="text" id="inputNombre" class="form-control" placeholder="<?php echo $_SESSION["Nombres"]." ".$_SESSION["Apellidos"]; ?>" value="<?php echo $_SESSION["Ind"]; ?>" required>
                    
                
                    
                </form>
                <button class="btn btn-lg btn-primary btn-block" id="updateUp" type="submit">Radicar Solicitud</button>
                
                <div id="resutado"></div>
                <div class="alert alert-success" id="successI" role="alert">
                    <strong>Bien Hecho!</strong> radicacion actualizada, se pondran en contacto con ud.
                </div>
                <div class="alert alert-success" id="successD" role="alert">
                    <strong>Bien Hecho!</strong> Información eliminada.
                </div>
                <div class="alert alert-danger" id="cedexist" role="alert">
                    <strong>Ya existe la cedula!</strong> Verifique la información.
                </div>
                <div class="alert alert-warning" id="emptyI" role="alert">
                    <strong>Campos Vacios!</strong> Rellene los campos vacios.
                </div>
                <div class="alert alert-warning" id="errorI" role="alert">
                    <strong>Se produjo un error</strong> Intentelo de nuevo.
                </div>
                <div class="alert alert-info" id="procesandoI" role="alert">
                    <strong>Actualizando</strong> por favor espere!.
                </div>
                <div class="alert alert-info" id="procesandoD" role="alert">
                    <strong>Eliminando</strong> por favor espere!.
                </div>
            </div>
        </div> <!-- /container -->
        <script>
            $(document).ready(function(){
                $("#successI").css("display", "none");
                $("#successD").css("display", "none");
                $("#cedexist").css("display", "none");
                $("#emptyI").css("display", "none");
                $("#errorI").css("display", "none");
                $("#procesandoI").css("display", "none");
                $("#procesandoD").css("display", "none");
                $("#updateUp").on("click", function(){
                    var idMascota = $("#inputId").val();
                    var idUsuario = $("#inputNombre").val();
                    var parametros = {
                        "idMascota_": idMascota,
                        "idUsuario_": idUsuario,
                    };
                    $.ajax({
                        data: parametros,
                        type: "post",
                        url: "api/v1/adoptar",
                        beforeSend: function(){
                            $("#procesandoI").css("display", "block");
                        },
                        success: function(response){
                            if(response == "insertado"){
                                $("#procesandoI").css("display", "none");
                                $("#successI").css("display", "block");
                            }
                            if(response == "Error"){
                                $("#errorI").css("display", "block");
                                $("#procesandoI").css("display", "none");
                            }
                        }
                    });
                    
                });

                

            });
        </script>
    </body>
</html>
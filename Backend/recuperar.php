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
        <h2 class="form-signin-heading">Recuperar Contraseña</h2>
        <label for="inputEmailRes" class="sr-only">Email</label>
        <input type="email" id="inputEmailRes" class="form-control" placeholder="Ingrese Email" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" id="restore" type="submit">Recuperar</button>
        <div class="alert alert-warning" id="ENotExiste" role="alert">
            <strong>Correo no existe</strong>
        </div>
        <div class="alert alert-success" id="Esuccess" role="alert">
            <strong>Bien Hecho!</strong> Ahora revise su correo para continuar.
        </div>
        <div class="alert alert-warning" id="ENotActived" role="alert">
            <strong>Correo no activado</strong>
        </div>
        <div class="alert alert-warning" id="EemptyF" role="alert">
            <strong>Campo Vacios!</strong> Rellene el campo vacio.
        </div>
        <div class="alert alert-warning" id="Eerr" role="alert">
            <strong>Ocurrio un error inesperado!</strong>
        </div>
</div>

    </div> <!-- /container -->
    <script>
        $(document).ready(function(){
            $("#ENotExiste").css("display", "none");
            $("#Esuccess").css("display", "none");
            $("#ENotActived").css("display", "none");
            $("#EemptyF").css("display", "none");
            $("#Eerr").css("display", "none");
            $("#restore").on("click", function(){
                var email_restore = $("#inputEmailRes").val();
                if(email_restore == ""){
                    $("#EemptyF").css("display", "block");
                }else{
                    var parametros = {
                        "email_re_":email_restore
                    };
                    $.ajax({
                        data:parametros,
                        type:"post",
                        url:'api/v1/recuperarPass',
                        beforeSend:function(){
                            console.log("procesando");
                        },
                        success:function(response){
                            if(response == "Error"){
                                $("#Eerr").css("display", "block");
                            }

                            if(response == "Enviado"){
                                $("#Esuccess").css("display", "block");
                            }

                            if(response == "No activo"){
                                $("#ENotActived").css("display", "block");
                            }

                            if(response == "No existe"){
                                $("#ENotExiste").css("display", "block");
                            }
                            console.log(response);
                        }
                    });
                }
                
            });
        });
    </script>

    </body>

    </html>

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
  <?php 
    
?>

    <div class="container">

      <div class="form-signin">
        <h2 class="form-signin-heading">Inicie Sesion</h2>
        <label for="inputUsuario" class="sr-only">Usuario</label>
        <input type="text" id="inputUsuario" class="form-control" placeholder="Usuario" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" id="logIn" type="submit">Iniciar</button>
        <div class="alert alert-warning" id="NotExiste" role="alert">
            <strong>Usuario no existe</strong>
        </div>
        <div class="alert alert-warning" id="NotActived" role="alert">
            <strong>Usuario no activado</strong>
        </div>
        <div class="alert alert-warning" id="emptyF" role="alert">
            <strong>Campos Vacios!</strong> Rellene los campos vacios.
        </div>
        <div class="alert alert-warning" id="notpass" role="alert">
            <strong>Contraseña Errada!</strong> Verifique la contraseña.
        </div>
        <div class="alert alert-warning" id="err" role="alert">
            <strong>Ocurrio un error inesperado!</strong>
        </div>
        <div class="alert alert-warning" id="errD" role="alert">
            <strong>Cuenta eliminada! </strong> pongase en contacto con soporte
        </div>
</div>

    </div> <!-- /container -->

    <center>  <a href="registro">¿No tiene una cuenta?, Registrese!</a></center>
    <center>  <a href="recuperar">¿Se te olvido la contraseña?, Recuperala!</a></center>
    <center>  <a href="radicarsoporte">¿Tiene problemas para iniciar sesion?, cuentanos!</a></center>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
        $(document).ready(function(){
            $("#NotExiste").css("display","none");
            $("#NotActived").css("display","none");
            $("#notpass").css("display","none");
            $("#emptyF").css("display","none");
            $("#err").css("display","none");
            $("#errD").css("display","none");
            $("#logIn").on("click", function(){
                var usuario = $("#inputUsuario").val();
                var password = $("#inputPassword").val();
                if(usuario == "" || password == ""){
                    $("#emptyF").css("display","block");
                }
                var parametros = {
                    "usuario_": usuario,
                    "contrasena_": password
                };
                $.ajax({
                    data: parametros,
                    type: "post",
                    url: "api/v1/login",
                    beforeSend: function(){
                        console.log("Iniciando");
                    },
                    success: function(response){
                        if(response == "NoActivado"){
                            $("#NotActived").css("display","block");
                        }

                        if(response == "Errada"){
                            $("#notpass").css("display","block");
                        }

                        if(response == "noexiste"){
                            $("#NotExiste").css("display","block");
                        }
                        
                        if(response == "Correcta"){
                            window.location = "dashboard";
                        }

                        if(response == "Eliminado"){
                            $("#errD").css("display","block");
                        }

                        console.log(response);
                    }
                });
                
            });
            
        });
    </script>
    <script src="resources/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
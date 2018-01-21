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
        <h2 class="form-signin-heading">Registrese</h2>
        <label for="inputUsuario" class="sr-only">Usuario</label>
        <input type="text" id="inputUsuario" class="form-control" placeholder="Usuario" required autofocus>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <label for="inputRePassword" class="sr-only">Repetir Contraseña</label>
        <input type="password" id="inputRePassword" class="form-control" placeholder="Repetir contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" id="SignUp" type="submit">Registrar</button>
        <div class="alert alert-success" id="success" role="alert">
            <strong>Bien Hecho!</strong> Ahora revise su correo para confirmar la cuenta.
        </div>
        <div class="alert alert-danger" id="userexist" role="alert">
            <strong>Ya existe el usuario!</strong> Inicie sesion.
        </div>
        <div class="alert alert-warning" id="empty" role="alert">
            <strong>Campos Vacios!</strong> Rellene los campos vacios.
        </div>
        <div class="alert alert-warning" id="pass" role="alert">
            <strong>Contraseñas no coinciden</strong> Verifique la contraseña.
        </div>
        <div class="alert alert-warning" id="error" role="alert">
            <strong>Se produjo un error</strong> Intentelo de nuevo.
        </div>
        <div class="alert alert-info" id="procesando" role="alert">
            <strong>Registrando</strong> por favor espere!.
        </div>
    </div>
    
    </div> <!-- /container -->
    
   


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
        $(document).ready(function(){
            $("#success").css("display","none");
            $("#userexist").css("display","none");
            $("#empty").css("display","none");
            $("#error").css("display","none");
            $("#pass").css("display","none");
            $("#procesando").css("display","none");
            $("#SignUp").on("click", function(){
                $("#success").css("display","none");
                $("#userexist").css("display","none");
                $("#empty").css("display","none");
                $("#error").css("display","none");
                $("#pass").css("display","none");
                $("#procesando").css("display","none");
                var usuario = $("#inputUsuario").val();
                var email = $("#inputEmail").val();
                var password = $("#inputPassword").val();
                var repassword = $("#inputRePassword").val();
                if(usuario == "" || email == "" || password == "" || repassword == ""){
                    $("#empty").css("display","block");
                }else{
                    if(password != repassword){
                        $("#pass").css("display","block");
                    }else{
                        var parametros = {
                            "Email_": email,
                            "Usuario_": usuario,
                            "Contrasena_": password
                        };
                        $.ajax({
                            data: parametros,
                            url: "api/v1/registroUsuario",
                            type: "post",
                            beforeSend: function(){
                                $("#procesando").css("display","block");
                            },
                            success: function(response){
                                if(response == "Enviado"){
                                    $("#procesando").css("display","none");
                                    $("#empty").css("display","none");
                                    $("#success").css("display","block");
                                    
                                }
                                if(response == "Usuario ya existe"){
                                    $("#userexist").css("display","block");
                                }
                                if(response == "Error"){
                                    $("#error").css("display","block");
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script src="resources/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
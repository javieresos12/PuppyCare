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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
<div class="container">

      <div class="form-signin">
        <h2 class="form-signin-heading">Restaurar Contraseña</h2>
        <label for="inputToken" class="sr-only">Token</label>
        <input type="text" id="inputToken" class="form-control" hidden  placeholder="Token" value="<?php echo $_GET['token_']; ?>" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <label for="inputRePassword" class="sr-only">Repetir Contraseña</label>
        <input type="password" id="inputRePassword" class="form-control" placeholder="Repetir contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" id="establecer" type="submit">Establecer</button>
        <div class="alert alert-success" id="success" role="alert">
            <strong>Bien Hecho!</strong> Sera redigirido al login.
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
            <strong>Actualizando</strong> por favor espere!.
        </div>
    </div>
    
    </div> <!-- /container -->

    <script>
        $(document).ready(function(){
            $("#success").css("display", "none");
            $("#empty").css("display", "none");
            $("#pass").css("display", "none");
            $("#error").css("display", "none");
            $("#procesando").css("display", "none");
            $("#establecer").on("click", function(){
                var token = $("#inputToken").val();
                var pass = $("#inputPassword").val();
                var repass = $("#inputRePassword").val();
                if(pass == "" || repass == ""){
                    $("#empty").css("display", "block");
                }else{
                    if(pass != repass){
                        $("#pass").css("display", "block");
                    }else{
                        var parametros = {
                            "pass_re_":pass,
                            "token_":token
                        };
                        $.ajax({
                            data:parametros,
                            type:"post",
                            url: "api/v1/validarKey",
                            beforeSend:function(){
                                $("#procesando").css("display", "block");
                            },
                            success:function(response){
                                if(response=="exito"){
                                    $("#success").css("display", "block");
                                    $("#procesando").css("display", "none");
                                    setTimeout(() => {
                                        window.location = "index";
                                    }, 5000);
                                }
                                if(response=="error"){
                                    $("#success").css("display", "none");
                                    $("#error").css("display", "block");
                                }
                                
                            }
                        });
                    }
                    
                }
                
            });
        });
    </script>
    
    
</body>
</html>
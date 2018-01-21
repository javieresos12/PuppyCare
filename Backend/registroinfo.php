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
                <h2 class="form-signin-heading">Comnplete Info</h2>
                <form method="post" id="formulario" enctype="multipart/form-data">
                    <label for="inputId" class="sr-only">Cod</label>
                    <input type="number" id="inputId" class="form-control" value="<?php echo $_GET["Ind_"]; ?>" placeholder="<?php echo $_GET["Ind_"]; ?>" readonly="readonly" required autofocus>
                    <label for="inputNombre" class="sr-only">Nombres</label>
                    <!--<label for="inputFoto">Subir foto</label>
                    <input type="file" id="inputFoto" name="file" class="form-control">-->
                    <input type="text" id="inputNombre" class="form-control" placeholder="Nombres" required>
                    <label for="inputApellidos" class="sr-only">Apellidos</label>
                    <input type="text" id="inputApellidos" class="form-control" placeholder="Apellidos" required>
                    <label for="inputCedula" class="sr-only">Cedula</label>
                    <input type="number" id="inputCedula" class="form-control" placeholder="Cedula" required autofocus>
                    <label for="inputTelefono" class="sr-only">Telefono</label>
                    <input type="number" id="inputTelefono" class="form-control" placeholder="Telefono" required autofocus>
                    <label for="inputCelular" class="sr-only">Celular</label>
                    <input type="number" id="inputCelular" class="form-control" placeholder="Celular" required>
                    <label for="inputCiudad" class="sr-only">Ciudad</label>
                    <input type="text" id="inputCiudad" class="form-control" placeholder="Ciudad" required>
                    
                </form>
                <button class="btn btn-lg btn-primary btn-block" id="updateUp" type="submit">Enviar Info</button>
                <div id="resutado"></div>
                <div class="alert alert-success" id="successI" role="alert">
                    <strong>Bien Hecho!</strong> Información actualizada.
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
            </div>
        </div> <!-- /container -->
        <script>
            $(document).ready(function(){
                $("#successI").css("display", "none");
                $("#cedexist").css("display", "none");
                $("#emptyI").css("display", "none");
                $("#errorI").css("display", "none");
                $("#procesandoI").css("display", "none");
                $("#updateUp").on("click", function(){
                    //var img = document.getElementById("inputFoto");
                    //var file = img.files[0];
                    var nombres = $("#inputNombre").val();
                    var apellidos = $("#inputApellidos").val();
                    var ind = $("#inputId").val();
                    var cedula = $("#inputCedula").val(); 
                    var ciudad = $("#inputCiudad").val();
                    var celular = $("#inputCelular").val();
                    var telefono = $("#inputTelefono").val();
                    //var foto = $("#inputFoto").val();
                    if(cedula == "" || ciudad == "" || celular == "" || telefono == ""){
                        $("#emptyI").css("display", "block");
                    }else{
                        var parametros = {
                            "Ind_": ind,
                            "Nombres_": nombres,
                            "Apellidos_": apellidos,
                            "cedula_":cedula,
                            "ciudad_":ciudad,
                            "celular_":celular,
                            "telefono_":telefono,
                        };
                        //var data = new FormData();
                        //data.append('img', file);
                        //data.append("datos", JSON.stringify(parametros));
                        /*$.ajax({
                            url: "guardar",
                            type: "post",
                            data: data,
                            contentType: false,
                            processData:false,
                            success: function(datos){
                                $("#respuesta").html(datos);
                            }
                        });*/
                        $.ajax({
                            data: parametros,
                            type: "post",
                            url: "api/v1/registroInfo",
                            beforeSend: function(){
                                $("#procesandoI").css("display", "block");
                            },
                            success: function(response){
                                if(response == "Actualizado"){
                                    $("#successI").css("display", "block");
                                    /*setTimeout(() => {
                                        window.location = "dashboard"; 
                                    }, 5000);*/
                                   window.location = "dashboard";
                                }
                                if(response == "Error"){
                                    $("#errorI").css("display", "block");
                                }
                                if(response == "YaExiste"){
                                    $("#cedexist").css("display", "block");
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
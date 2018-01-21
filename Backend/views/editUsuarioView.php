<?php 
    $id = $_GET["userid_"];
    require_once ('resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    $db->where ("Ind", $id);
    $user = $db->getOne("usuarios");
    $Nombres = $user["Nombres"];
    $Apellidos = $user["Apellidos"];
    $Cedula = $user["Cedula"];
    $Telefono = $user["Telefono"];
    $Celular = $user["Celular"];
    $Ciudad = $user["Ciudad"];
?>
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
                <h2 class="form-signin-heading">Actualice Info</h2>
                <form method="post" id="formulario" enctype="multipart/form-data">
                    <label for="inputId" class="sr-only">Cod</label>
                    <input type="number" id="inputId" class="form-control" value="<?php echo $_GET["userid_"]; ?>" placeholder="<?php echo $_GET["Ind_"]; ?>" readonly="readonly" required autofocus>
                    <label for="inputNombre" class="sr-only">Nombres</label>
                    <!--<label for="inputFoto">Subir foto</label>
                    <input type="file" id="inputFoto" name="file" class="form-control">-->
                    <input type="text" id="inputNombre" class="form-control" placeholder="<?php echo $Nombres; ?>" value="<?php echo $Nombres; ?>" required>
                    <label for="inputApellidos" class="sr-only">Apellidos</label>
                    <input type="text" id="inputApellidos" class="form-control" placeholder="<?php echo $Apellidos; ?>" value="<?php echo $Apellidos; ?>" required>
                    <label for="inputCedula" class="sr-only">Cedula</label>
                    <input type="number" id="inputCedula" class="form-control" placeholder="<?php echo $Cedula; ?>" value="<?php echo $Cedula; ?>" readonly="readonly" required autofocus>
                    <label for="inputTelefono" class="sr-only">Telefono</label>
                    <input type="number" id="inputTelefono" class="form-control" placeholder="<?php echo $Telefono; ?>" value="<?php echo $Telefono; ?>" required autofocus>
                    <label for="inputCelular" class="sr-only">Celular</label>
                    <input type="number" id="inputCelular" class="form-control" placeholder="<?php echo $Celular; ?>" value="<?php echo $Celular; ?>" required>
                    <label for="inputCiudad" class="sr-only">Ciudad</label>
                    <input type="text" id="inputCiudad" class="form-control" placeholder="<?php echo $Ciudad; ?>" value="<?php echo $Ciudad; ?>" required>
                    
                </form>
                <button class="btn btn-lg btn-primary btn-block" id="updateUp" type="submit">Enviar Info</button>
                <button class="btn btn-lg btn-danger btn-block" id="deleteUp" type="submit">Eliminar Usuario</button>
                <div id="resutado"></div>
                <div class="alert alert-success" id="successI" role="alert">
                    <strong>Bien Hecho!</strong> Información actualizada.
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
                    var nombres = $("#inputNombre").val();
                    var apellidos = $("#inputApellidos").val();
                    var ind = $("#inputId").val();
                    var cedula = $("#inputCedula").val(); 
                    var ciudad = $("#inputCiudad").val();
                    var celular = $("#inputCelular").val();
                    var telefono = $("#inputTelefono").val();
                    if(cedula == "" || ciudad == "" || celular == "" || telefono == ""){
                        $("#emptyI").css("display", "block");
                    }else{
                        var parametros = {
                            "Ind_": ind,
                            "Nombres_": nombres,
                            "Apellidos_": apellidos,
                            "ciudad_":ciudad,
                            "celular_":celular,
                            "telefono_":telefono,
                        };
                        
                        $.ajax({
                            data: parametros,
                            type: "post",
                            url: "api/v1/actualizarInfo",
                            beforeSend: function(){
                                $("#procesandoI").css("display", "block");
                            },
                            success: function(response){
                                if(response == "Actualizado"){
                                    $("#successI").css("display", "block");
                                    /*setTimeout(() => {
                                        window.location = "dashboard"; 
                                    }, 5000);*/
                                   window.location = "usuarios";
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
                $("#deleteUp").on("click", function(){
                    var ind = $("#inputId").val();
                    var parametros = {
                            "Ind_": ind
                        };

                    $.ajax({
                        data: parametros,
                        type: 'post',
                        url: 'api/v1/eliminarInfo',
                        beforeSend: function(){
                            $("#procesandoD").css("display", "block");
                        },
                        success:function(response){
                            if(response == "eliminado"){
                                $("#procesandoD").css("display", "none");
                                $("#successD").css("display", "block");
                            }else{
                                $("#procesandoD").css("display", "none");
                                $("#errorI").css("display", "block");
                            }
                        }
                    });
                });

            });
        </script>
    </body>
</html>
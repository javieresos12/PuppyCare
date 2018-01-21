<?php 
    session_start();
    require_once ('resources/lib/MysqliDb.php');
    $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
    if(isset($_SESSION["Estado_Conexion"])){
        if($_SESSION['Rol'] == "Usuario"){
            header("location: dashboard");
        }
        if($_SESSION['Estado_Inf'] == "Incompleto"){
            header("location: registroinfo?Ind_=".$_SESSION['Ind']);
        }else{
            ?>
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <script src="resources/lib/jquery-3.2.1.js">
                    </script>
                    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">
                    <title>PuppyCare</title>
                    <!-- Bootstrap core CSS -->
                    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
                    <!-- Custom styles for this template -->
                    <link href="resources/css/signin.css" rel="stylesheet">
                    <link href="resources/css/album.css" rel="stylesheet">
                    <script src="https://use.fontawesome.com/c4fdf21eee.js"></script>
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
                    <main role="main">
                        <div class="album text-muted">
                            <div class="container">
                                <div class="row">
                                    <?php 
                                        require_once ('resources/lib/MysqliDb.php');
                                        $db = new MysqliDb ('localhost', 'root', '', 'puppycare');
                                        $mascota = $db->get("mascotas");
                                        foreach ($mascota as $mascotas) {
                                            echo '<div class="card">
                                                    <img witdh="300" height="300" src="'.$mascotas["Foto"].'">
                                                    <p class="card-text">'.$mascotas["Nombre"].'</p>
                                                    <p class="card-text">'.$mascotas["Raza"].'</p>
                                                    <p class="card-text">'.$mascotas["Edad"].'</p>
                                                    <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$mascotas["Ciudad"].'</p>
                                                    <p class="card-text">'.$mascotas["Descripcion"].'</p>
                                                    <button name="btnAdoptar" type="button" class="btn btn-secondary"><a href="adoptar?id_='.$mascotas["Ind"].'">Adoptar</a></button>
                                                </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </main>
                    <footer class="text-muted">
                        <div class="container">
                        <p class="float-right">
                            <a href="#">Back to top</a>
                        </p>
                        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
                        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
                        </div>
                    </footer>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
                    <script src="resources/js/bootstrap.min.js"></script> 
                    <script>
                        $(document).ready(function(){
                            /*$(".btnAdoptar").on("click", function(){
                                alert("ok");
                            });*/
                            
                        });
                    </script>
                </body>
            </html>
        <?php 
        }
    }else{
        header("location: index");
    }
?>

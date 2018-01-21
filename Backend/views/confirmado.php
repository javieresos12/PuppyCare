<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <script src="resources/lib/jquery-3.2.1.js"></script>
    <title>Cuenta Confirmada</title>
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="resources/css/starter-template.css" rel="stylesheet">
    <!-- Custom styles for this template -->
  </head>
  <body>
    <main role="main" class="container">
      <div class="starter-template">
        <h1>Cuenta confirmada</h1>
        <p class="lead">Su cuenta ya ha sido activada anteriormente.<br> Sera redireccionado a la ventana de login</p>
      </div>
    </main><!-- /.container -->
    <script>
      $(document).ready(function(){
        setTimeout(() => {
          window.location = "index";
          }, 5000);
        });
    </script>
  </body>
</html>
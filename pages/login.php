<?php
//Conexion BD
require '../include/config/database.php';
$db = conectarDB();

//Autenticacion de usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*echo "<pre>";
        var_dump($_POST);
    echo "</pre>";*/

    $usuario = mysqli_real_escape_string($db, $_POST['usuario']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$usuario) {
        $errores [] = "El usuario es obligatorio";
    }

    if (!$password) {
        $errores [] = "La clave es obligatoria";
    }

    if (empty($errores)) {
        
        //Revisar si el usuario existe
        $query = "SELECT usuario, password, id_cargo FROM usuarios WHERE usuario = '${usuario}'";
        $resultado = mysqli_query($db, $query);
        
        // echo "<pre>";
        // var_dump($resultado);
        // echo "</pre>";

        if ($resultado->num_rows) {
            //Revisar si el password es correcto
            $usuario=mysqli_fetch_assoc($resultado);

            //Verificar si el password es correcto o no
            $auth = password_verify($password, $usuario['password']); //Se compara si el password es igual al de la BD
            
            if ($auth) {
                //El usuario esta autenticado
                session_start();

                //Llernar el arreglo de sesion
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['login'] = true;
                $_SESSION['cargo'] = $usuario['id_cargo'];


                echo "<pre>";
                var_dump($_SESSION);
                echo "</pre>";

            }else{
                $errores[] = 'La clave es incorrecta';
            }
        }else{
            $errores[] = "El usuario no existe";
            }
    }

}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Startmin - Bootstrap Admin Theme</title>

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Mis Estilos -->
        <link href="../css/styles.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">

                <?php foreach($errores as $error):?>
                    <div class = "alerta error">
                        <?php echo $error; ?>
                    </div>
                    <?php endforeach?>


                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Iniciar Sesión</h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="usuario">Usuario</label>
                                        <input class="form-control" placeholder="Usuario" name="usuario" type="text" id="usuario" autofocus required>
                                    </div>
                                    <div class="form-group">
                                    <label for="password">Clave</label>
                                        <input class="form-control" placeholder="Clave" name="password" type="password" id="password" required>
                                    </div>
                                    <input type="submit" value="Ingresar" class="btn btn-lg btn-success btn-block">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

    </body>
</html>

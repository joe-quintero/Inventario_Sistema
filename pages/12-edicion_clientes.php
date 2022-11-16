<?php

//Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT); 

if (!$id) {
    header('location: 8-clientes.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();


//Consulta para optener Clientes
$consulta = "SELECT * FROM clientes WHERE ci_rif = ${id}";
$resultado = mysqli_query($db,$consulta);
$consultaClientes = mysqli_fetch_assoc($resultado);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$preci_rif = $consultaClientes['preci_rif']; //variables para valores temporales en el formulario
$ci_rif = $consultaClientes['ci_rif'];
$nombre = $consultaClientes['nombre'];
$apellido = $consultaClientes['apellido'];
$telefono = $consultaClientes['telefono'];
$direccion = $consultaClientes['direccion'];

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    //$preci_rif =mysqli_real_escape_string($db , $_POST['preci_rif']);
    //$ci_rif =mysqli_real_escape_string($db , $_POST['ci_rif']);
    $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    $apellido =mysqli_real_escape_string($db , $_POST['apellido']);
    $telefono =mysqli_real_escape_string($db , $_POST['telefono']);
    $direccion =mysqli_real_escape_string($db , $_POST['direccion']);

    $fecha = date('Y/m/d');


//Se valida el fomulario.
    if (!$preci_rif){
        $errores[]= "Debe colocar tipo de Documento";
    }

    if (!$ci_rif){
        $errores[]= "Debe colocar la cedula o RIF del cleinte";
    }

    if (!$nombre){
        $errores[]= "Debe colocar nombre del cliente";
    }

    if (!$telefono){
        $errores[]= "Debe indicar el numero de telefono";
    }

    if (!$direccion){
        $errores[]= "Debe indicar la direccion del cliente";
    }


//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio
    
# Insertar en la Bade de Datos
$query = "UPDATE clientes SET ci_rif='${ci_rif}',preci_rif='${preci_rif}',nombre='${nombre}',apellido='${apellido}',telefono='${telefono}',direccion='${direccion}' WHERE ci_rif = ${id}"; 

//echo $query; //Probar que envia el query

//exit;

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 8-clientes.php?mensaje=2");
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

    <!-- Timeline CSS -->
    <link href="../css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/morris.css" rel="stylesheet">

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



<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Startmin</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edicion de Clientes</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

            <form class="formulario" method="POST">
            <fieldset>

                    <legend>Datos del Cliente</legend>

                    <br>
                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif" disabled="disabled">
                        <option value="<?php echo $preci_rif?>"> <?php echo $preci_rif?> </option>
                    <?php //Mostrar los otros pre para actyualizar
                    /*if ($preci_rif === 'J'){
                        echo '<option value="V">V</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'V'){
                        echo '<option value="J">J</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'G'){
                        echo '<option value="J">J</option>';
                        echo '<option value="V">V</option>';
                    }*/
                    ?>
                    </select>
                    <input type="number" id= ci_rif name="ci_rif"  maxlength="9" placeholder="Cedula / RIF" disabled="disabled" value="<?php echo $ci_rif ?>"> 
                    <br>
                    <label for="nombre">Nombre</label>
                    <input type="text" id= nombre name="nombre" placeholder="Nombre del Usuario" value="<?php echo $nombre ?>"> 
                    <br>
                    <label for="apellido">Apellido</label>
                    <input type="text" id= apellido name="apellido" placeholder="Apellido del Usuario" value="<?php echo $apellido ?>"> 
                    <br>
                    <label for="telefono">Telefono</label>
                    <input type="text" id= telefono name="telefono" placeholder="0424-123-1212" value="<?php echo $telefono ?>"> 
                    <br>
                    <label for="direccion">Direcion</label>
                    <input type="text" id= direccion name="direccion" placeholder="San Bernardino..." value="<?php echo $direccion ?>"> 


                </fieldset>

                <input type="submit" value="Actualizar" Class="boton-envio">  
            </form>

        </div>
    </div>

</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

</body>
</html>

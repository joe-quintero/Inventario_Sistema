<?php

//Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT); 

if (!$id) {
    header('location: 7-productos.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();

//Consulta para optener Productos
$consulta = "SELECT * FROM productos WHERE id_producto = ${id}";
$resultadoProductos = mysqli_query($db,$consulta);
$consultaProductos = mysqli_fetch_assoc($resultadoProductos);

//Consulta para optener Proveedores
$consultaProveedor = "SELECT * FROM proveedor";
$resultado = mysqli_query($db,$consultaProveedor);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = $consultaProductos['nombre']; //variables para valores temporales en el formulario
$tipo_producto = $consultaProductos['tipo_producto'];
$marca = $consultaProductos['marca'];
$precio_costo = $consultaProductos['precio_costo'];
$precio_venta = $consultaProductos['precio_venta'];
$descripcion = $consultaProductos['descripcion'];
$aplicacion = $consultaProductos['aplicacion'];
$codigo_barra = $consultaProductos['codigo_barra'];
$id_proveedor = $consultaProductos['id_proveedor'];

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    $tipo_producto =mysqli_real_escape_string($db , $_POST['tipo_producto']);
    $marca =mysqli_real_escape_string($db , $_POST['marca']);
    $precio_costo =mysqli_real_escape_string($db , $_POST['precio_costo']);
    $precio_venta =mysqli_real_escape_string($db , $_POST['precio_venta']);
    $descripcion =mysqli_real_escape_string($db , $_POST['descripcion']);
    $aplicacion =mysqli_real_escape_string($db , $_POST['aplicacion']);
    $codigo_barra =mysqli_real_escape_string($db , $_POST['codigo_barra']);
    $id_proveedor =mysqli_real_escape_string($db , $_POST['id_proveedor']);
    $nombre_proveedor =mysqli_real_escape_string($db , $_POST['nombre_proveedor']);

    //$fecha = date('Y/m/d');


//Se valida el fomulario.
    if (!$nombre){
        $errores[]= "Debe colocar el Nombre";
    }

    if (!$tipo_producto){
        $errores[]= "Debe colocar el tipo de producto";
    }

    if (!$marca){
        $errores[]= "Debe colocar la marca";
    }

    if (!$precio_costo){
        $errores[]= "Debe indicar el precio de costo";
    }

    if (!$precio_venta){
        $errores[]= "Debe indicar el precio de venta";
    }

    if (!$aplicacion){
        $errores[]= "Debe indicar la aplicacion del producto";
    }

    if (!$id_proveedor){
        $errores[]= "Debe seleccionar el proveedor del producto";
    }

//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio
    
# Insertar en la Bade de Datos
$query = "UPDATE productos SET nombre='${nombre}',tipo_producto='${tipo_producto}',marca='${marca}',precio_costo='${precio_costo}',precio_venta='${precio_venta}',descripcion='${descripcion}',aplicacion='${aplicacion}',codigo_barra='${codigo_barra}',id_proveedor='${id_proveedor}' WHERE id_producto = ${id}"; 

//echo $query; //Probar que envia el query

//exit;

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 7-productos.php?mensaje=2");
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
                    <h1 class="page-header">Edicion de Productos</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>


            <form class="formulario" method="POST">
                <fieldset>
                    <legend>Datos del Usuario</legend>

                    <label for="nombre">Nombre</label>
                    <input type="text" id= nombre name="nombre" placeholder="Nombre del Producto" value="<?php echo $nombre ?>"> 
                    <br>
                    <label for="tipo_producto">Tipo de Producto</label>
                    <input type="text" id= tipo_producto name="tipo_producto" placeholder="Aceite 20-50 Minaral" value="<?php echo $tipo_producto ?>"> 
                    <br>
                    <label for="marca">Marca</label>
                    <input type="text" id= marca name="marca" placeholder="Ultra Lub" value="<?php echo $marca ?>"> 
                    <br>
                    <label for="precio_costo">Precio de Costo</label>
                    <input type="number" id= precio_costo name="precio_costo" placeholder="10" value="<?php echo $precio_costo ?>"> 
                    <br>
                    <label for="precio_venta">Precio de venta</label>
                    <input type="number" id= precio_venta name="precio_venta" placeholder="11" value="<?php echo $precio_venta ?>"> 
                    <br>
                    <label for="descripcion">Descripcion</label>
                    <input type="text" id= descripcion name="descripcion" placeholder="Aceite mineral para motor" value="<?php echo $descripcion ?>"> 
                    <br>
                    <label for="aplicacion">Aplicacion</label>
                    <input type="text" id= aplicacion name="aplicacion" placeholder="Carro, Moto, Corolla" value="<?php echo $aplicacion ?>"> 
                    <br>
                    <label for="codigo_barra">Codigo de Barra</label>
                    <input type="number" id= codigo_barra name="codigo_barra" placeholder="123456789" value="<?php echo $codigo_barra ?>"> 
                    <br>
                    <label for="id_proveedor">Proveedor</label>
                    <select name="id_proveedor" id="id_proveedor" name="id_proveedor">
                        <option value="">---Seleccionar---</option>
                        <?php while ($row = mysqli_fetch_assoc($resultado) ): ?>
                            <option   <?php echo $id_proveedor === $row ['id_proveedor'] ? 'selected' : ''; ?>   value="<?php echo $row ['id_proveedor'] ?>"> <?php echo $row ['nombre']." - ".$row ['preci_rif'].$row ['ci_rif'] ?> </option>
                        <?php endwhile ?> 
                    </select>
                </fieldset>

                <input type="submit" value="Agregar Proveedor" Class="boton-envio">  
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

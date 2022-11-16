<?php
$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje

//Importamos conexion Base de Datos
require '../include/config/database.php';

$db= conectarDB();

//Query
$query ="SELECT id_proveedor, nombre, preci_rif, ci_rif, telefono, direccion, tipo_producto from PROVEEDOR";

//Consulta Base de Datos
$resultado = mysqli_query($db,$query);

// Creacion de variable para eliminar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_proveedor'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "DELETE FROM proveedor WHERE id_proveedor = ${id}";

        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('location: 6-proveedores.php?mensaje=3');
}}}

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
                    <h1 class="page-header">Proveedores</h1>
                </div>
            </div>
        </div>

        <?php if (intval($mensaje)===2): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">¡Proveedor actualizado exitosamente!</p> 
        <?php elseif (intval($mensaje)===3): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">Proveedor eliminado exitosamente!</p> 
        <?php endif; ?>

        <div>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID Proveedor</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>CI RIF</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Tipo Producto</th>
                    <th>Acciones</th>
                </tr>   
            </thead>
            <tbody> <!-- Mostramos los resultados del Query -->
                
                <?php while($proveedor = mysqli_fetch_assoc($resultado)): ?>
                
                <tr>
                    <td> <?php echo $proveedor ['id_proveedor']; ?> </td>
                    <td> <?php echo $proveedor ['nombre']; ?> </td>
                    <td> <?php echo $proveedor ['preci_rif']; ?> </td>
                    <td> <?php echo $proveedor ['ci_rif']; ?> </td>
                    <td> <?php echo $proveedor ['telefono']; ?> </td>
                    <td> <?php echo $proveedor ['direccion']; ?> </td>
                    <td> <?php echo $proveedor ['tipo_producto']; ?> </td>
                    <td>
                        <a href="10-edicion_proveedor.php?id=<?php echo $proveedor ['id_proveedor'];?>">Editar</a>
                        
                        <form method="POST"> <!-- Boton para eliminar registro -->
                            <input type = "hidden" name = "id_proveedor" value = "<?php echo $proveedor ['id_proveedor'];?>">
                            <input type="submit" class = "boton-eliminar" value="Eliminar">
                        </form>
                        
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
        </div>
    </div>

</div>

<!--cierre de la conexion-->
<?php mysqli_close($db); ?>

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

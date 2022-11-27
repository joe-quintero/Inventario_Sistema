<?php
require '../include/templates/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
//Importamos conexion Base de Datos
require '../include/config/database.php';

$db= conectarDB();

//Query
$query ="SELECT operacion, id_producto, nombre_producto, precio_unitario, cantidad, precio_total, fecha, nombre_usuario from operacion";

//Consulta Base de Datos
$resultado = mysqli_query($db,$query);

include '../include/templates/navegacion.php'; //Navegacion
?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Hitorico de Operaciones</h1>
                </div>
            </div>
        </div>            
        <div>
            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Operacion</th>
                                <th>ID Producto</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                            </tr>   
                        </thead>
                        <tbody> <!-- Mostramos los resultados del Query -->
                            
                            <?php while($usuario = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td> <?php echo $usuario ['operacion']; ?> </td>
                                <td> <?php echo $usuario ['id_producto']; ?> </td>
                                <td> <?php echo $usuario ['nombre_producto']; ?> </td>
                                <td> <?php echo $usuario ['precio_unitario']; ?> </td>
                                <td> <?php echo $usuario ['cantidad']; ?> </td>
                                <td> <?php echo $usuario ['precio_total']; ?> </td>
                                <td> <?php echo $usuario ['fecha']; ?> </td>
                                <td> <?php echo $usuario ['nombre_usuario']; ?> </td>
                            </tr>
                            <?php endwhile ?>

                        </tbody>
                    </table>

        </div>
    </div>

</div>

<?php include '../include/templates/script.php'; //JavaScript

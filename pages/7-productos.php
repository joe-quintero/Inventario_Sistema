<?php
require '../include/config/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje

//Importamos conexion Base de Datos
require '../include/config/database.php';

$db= conectarDB();

//Query
$query ="SELECT id_producto, nombre, tipo_producto, marca, precio_costo, precio_venta, descripcion, aplicacion, codigo_barra, fecha_creacion, id_proveedor, nombre_proveedor FROM productos ";

//Consulta Base de Datos
$resultado = mysqli_query($db,$query);

// Creacion de variable para eliminar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_producto'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "DELETE FROM productos WHERE id_producto = ${id}";

        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('location: 7-productos.php?mensaje=3');
}}}

include '../include/templates/navegacion.php'; //Navegacion
?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Productos</h1>
                </div>
            </div>
        </div>

        <?php if (intval($mensaje)===2): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">¡Productos actualizado exitosamente!</p> 
        <?php elseif (intval($mensaje)===3): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">Producto eliminado exitosamente!</p> 
        <?php endif; ?>

        <div>
            <table class="propiedades">
                <thead>
                    <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Tipo Producto</th>
                    <th>Marca</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Descripcion</th>
                    <th>Aplicacion</th>
                    <th>Codigo de Barra</th>
                    <th>ID Proveedor</th>
                    <th>Nombre Proveedor</th>
                    <th>Accion</th>
                    </tr>   
                </thead>
                <tbody> <!-- Mostramos los resultados del Query -->
                    
                    <?php while($producto = mysqli_fetch_assoc($resultado)): ?>
                    
                    <tr>
                        <td> <?php echo $producto ['id_producto']; ?> </td>
                        <td> <?php echo $producto ['nombre']; ?> </td>
                        <td> <?php echo $producto ['tipo_producto']; ?> </td>
                        <td> <?php echo $producto ['marca']; ?> </td>
                        <td> <?php echo $producto ['precio_costo']; ?> </td>
                        <td> <?php echo $producto ['precio_venta']; ?> </td>
                        <td> <?php echo $producto ['descripcion']; ?> </td>
                        <td> <?php echo $producto ['aplicacion']; ?> </td>
                        <td> <?php echo $producto ['codigo_barra']; ?> </td>
                        <td> <?php echo $producto ['id_proveedor']; ?> </td>
                        <td> <?php echo $producto ['nombre_proveedor']; ?> </td>
                        <td>
                        <a href="11-edicion_productos.php?id=<?php echo $producto ['id_producto'];?>">Editar</a>
                        
                        <form method="POST"> <!-- Boton para eliminar registro -->
                            <input type = "hidden" name = "id_producto" value = "<?php echo $producto ['id_producto'];?>">
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

<?php include '../include/templates/script.php'; //JavaScript

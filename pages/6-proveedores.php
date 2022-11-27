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

include '../include/templates/navegacion.php'; //Navegacion
?>
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
        <table class="table table-striped">
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

<?php include '../include/templates/script.php'; //JavaScript
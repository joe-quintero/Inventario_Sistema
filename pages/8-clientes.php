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
$query ="SELECT * FROM clientes";

//Consulta Base de Datos
$resultado = mysqli_query($db,$query);


// Creacion de variable para eliminar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['ci_rif'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "DELETE FROM clientes WHERE ci_rif = ${id}";

        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('location: 8-clientes.php?mensaje=3');
}}}

include '../include/templates/navegacion.php'; //Navegacion
?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Clientes</h1>
                </div>
            </div>
        </div>

        <?php if (intval($mensaje)===2): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">¡Cliente actualizado exitosamente!</p>
        <?php elseif (intval($mensaje)===3): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">¡Cliente eliminado exitosamente!</p> 
        <?php endif;?>

        <div>
            <table class="propiedades">
                <thead>
                    <tr>
                    <th>Documento</th>
                    <th>CI - RIF</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                    </tr>   
                </thead>
                <tbody> <!-- Mostramos los resultados del Query -->
                    
                    <?php while($cliente = mysqli_fetch_assoc($resultado)): ?>
                    
                    <tr>
                        <td> <?php echo $cliente ['preci_rif']; ?> </td>
                        <td> <?php echo $cliente ['ci_rif']; ?> </td>
                        <td> <?php echo $cliente ['nombre']; ?> </td>
                        <td> <?php echo $cliente ['apellido']; ?> </td>
                        <td> <?php echo $cliente ['telefono']; ?> </td>
                        <td> <?php echo $cliente ['direccion']; ?> </td>
                        <td>
                        <a href="12-edicion_clientes.php?id=<?php echo $cliente ['ci_rif'];?>">Editar</a>

                        <form method="POST"> <!-- Boton para eliminar registro -->
                            <input type = "hidden" name = "ci_rif" value = "<?php echo $cliente ['ci_rif'];?>">
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
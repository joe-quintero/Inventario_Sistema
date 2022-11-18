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
$query ="SELECT id_usuario, usuario, nombre, apellido, identificacion, id_cargo from USUARIOS";

//Consulta Base de Datos
$resultado = mysqli_query($db,$query);

// Creacion de variable para eliminar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_usuario'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "DELETE FROM usuarios WHERE id_usuario = ${id}";

        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('location: 5-usuarios.php?mensaje=3');
}}}

include '../templates/navegacion.php'; //Navegacion
?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Usuarios</h1>
                </div>
            </div>
        </div>

        <?php if (intval($mensaje)===2): //Mensaje deactualizacion exitosa mostrado ?>
        <p class="alerta exito">¡Usuario actualizado exitosamente!</p> 
        <?php elseif (intval($mensaje)===3): //Mensaje eliminacion exitosa mostrado ?>
        <p class="alerta exito">¡Usuario eliminado exitosamente!</p> 
        <?php endif; ?>
            
        <div>
            <table class="propiedades">
                        <thead>
                            <tr>
                                <th>ID Usuario</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Identificacion</th>
                                <th>Cargo</th>
                                <th>Acciones</th>
                            </tr>   
                        </thead>
                        <tbody> <!-- Mostramos los resultados del Query -->
                            
                            <?php while($usuario = mysqli_fetch_assoc($resultado)): ?>
                            
                            <tr>
                                <td> <?php echo $usuario ['id_usuario']; ?> </td>
                                <td> <?php echo $usuario ['usuario']; ?> </td>
                                <td> <?php echo $usuario ['nombre']; ?> </td>
                                <td> <?php echo $usuario ['apellido']; ?> </td>
                                <td> <?php echo $usuario ['identificacion']; ?> </td>
                                <td> <?php echo $usuario ['id_cargo']; ?> </td>
                                <td>
                                    <a href="9-edicion_usuario.php?id=<?php echo $usuario ['id_usuario'];?>">Editar</a>
                                    <a href="#">Suspender</a>
                                    <a href="#">Recetear</a>
                        
                                    <form method="POST"> <!-- Boton para eliminar registro -->
                                        <input type = "hidden" name = "id_usuario" value = "<?php echo $usuario ['id_usuario'];?>">
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

<?php include '../templates/script.php'; //JavaScript

<?php
require '../include/config/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
require '../include/config/database.php';

$db = conectarDB();

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = ''; //variables para valores temporales en el formulario
$ci_rif = '';
$preci_rif = '';
$telefono =  '';
$direccion = '';
$tipo_producto = '';
$direccion = '';

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    $preci_rif =mysqli_real_escape_string($db , $_POST['preci_rif']);
    $ci_rif =mysqli_real_escape_string($db , $_POST['ci_rif']);
    $telefono =mysqli_real_escape_string($db , $_POST['telefono']);;
    $direccion =mysqli_real_escape_string($db , $_POST['direccion']);
    $tipo_producto =mysqli_real_escape_string($db , $_POST['tipo_producto']);
    $fecha = date('Y/m/d');


//Se valida el fomulario.
    if (!$nombre){
        $errores[]= "Debe colocar el Nombre";
    }

    if (!$preci_rif){
        $errores[]= "Debe colocar tipo de documento";
    }

    if (!$ci_rif){
        $errores[]= "Debe colocar CI o RIF";
    }

    if (!$telefono){
        $errores[]= "Debe colocar Telefono de Contacto";
    }

    if (!$tipo_producto){
        $errores[]= "Debe indicar el tipo de producto";
    }

//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio
    
# Insertar en la Bade de Datos
$query = "INSERT INTO proveedor (nombre, ci_rif, preci_rif, telefono, direccion, tipo_producto, fecha, id_usuario_registro, nombre_Usuario) 
VALUES ('$nombre', '$ci_rif', '$preci_rif', '$telefono', '$direccion', '$tipo_producto', '$fecha',2,'Joe')"; 

//    echo $query; //Probar que envia el query

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 2-registro_proveedor.php?mensaje=1");
}
}
}

include '../templates/navegacion.php'; //Navegacion
?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Registro de Proveedores</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

<?php if (intval($mensaje)===1): //Mensaje de exitodo mostrando ?>
    <p class="alerta exito">¡Proveedor creado exitosamente!</p> 
<?php endif; ?>

            <form class="formulario" method="POST" action="2-registro_proveedor.php">
                <fieldset>
                    <legend>Datos del Usuario</legend>

                    <label for="nombre">Nombre</label>
                    <input type="text" id= nombre name="nombre" placeholder="Nombre del Usuario" value="<?php echo $nombre ?>"> 
                    <br>
                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif">
                        <option value="">-</option>
                        <option value="J">J</option>
                        <option value="G">G</option>
                        <option value="V">V</option>
                    </select>
                    <input type="number" id= ci_rif name="ci_rif" placeholder="Cedula / RIF" value="<?php echo $ci_rif ?>"> 
                    <br>
                    <label for="telefono">Telefono</label>
                    <input type="text" id= telefono name="telefono" placeholder="0424-123-4567" value="<?php echo $telefono ?>"> 
                    <br>
                    <label for="direccion">Direcion</label>
                    <input type="text" id= direccion name="direccion" placeholder="Direccion de Proveedor" value="<?php echo $direccion ?>"> 
                    <br>
                    <label for="tipo_producto">Tipo de Producto</label>
                    <input type="text" id= tipo_producto name="tipo_producto" placeholder="Aceite, Bateria, Filtros..." value="<?php echo $tipo_producto ?>"> 



                </fieldset>

                <input type="submit" value="Agregar Proveedor" Class="boton-envio">  
            </form>

        </div>
    </div>

    </div>

<?php include '../templates/script.php'; //JavaScript

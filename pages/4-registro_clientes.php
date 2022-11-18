<?php
require '../include/config/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
require '../include/config/database.php';

$db = conectarDB();

//Consulta para optener Proveedores
//$consultaProveedor = "SELECT * FROM proveedor";
//$resultado = mysqli_query($db,$consultaProveedor);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$preci_rif = ''; //variables para valores temporales en el formulario
$ci_rif = '';
$nombre = '';
$apellido =  '';
$telefono = '';
$direccion = '';

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    $preci_rif =mysqli_real_escape_string($db , $_POST['preci_rif']);
    $ci_rif =mysqli_real_escape_string($db , $_POST['ci_rif']);
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
$query = "INSERT INTO clientes(ci_rif, preci_rif, nombre, apellido, telefono, direccion, id_usuario_registro, fecha) VALUES ('$ci_rif','$preci_rif','$nombre','$apellido','$telefono','$direccion',2,'$fecha')"; 

//    echo $query; //Probar que envia el query

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 4-registro_clientes.php?mensaje=1");
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
                    <h1 class="page-header">Registro de Clientes</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

<?php if (intval($mensaje)===1): //Mensaje de exitodo mostrando ?>
    <p class="alerta exito">¡Cliente creado exitosamente!</p> 
<?php endif; ?>

            <form class="formulario" method="POST" action="4-registro_clientes.php">
            <fieldset>

                    <legend>Datos del Cliente</legend>

                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif">
                        <option value="">-</option>
                        <option value="V">V</option>
                        <option value="J">J</option>
                        <option value="G">G</option>
                    </select>
                    <input type="number" id= ci_rif name="ci_rif"  maxlength="9" placeholder="Cedula / RIF" value="<?php echo $ci_rif ?>"> 
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

                <input type="submit" value="Agregar" Class="boton-envio">  
            </form>

        </div>
    </div>

</div>

<?php include '../templates/script.php'; //JavaScript
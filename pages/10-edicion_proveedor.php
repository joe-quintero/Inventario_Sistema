<?php
require '../include/templates/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

//Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT); 

if (!$id) {
    header('location: 6-proveedores.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();

//Consulta para optener informacion de proveedores
$consulta = "SELECT nombre, ci_rif, preci_rif, telefono, direccion, tipo_producto  FROM proveedor WHERE id_proveedor = ${id}";
$resultado = mysqli_query($db, $consulta);
$consultaProveedores = mysqli_fetch_assoc($resultado);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = $consultaProveedores['nombre']; //variables para valores temporales en el formulario
$ci_rif = $consultaProveedores['ci_rif'];
$preci_rif = $consultaProveedores['preci_rif'];
$telefono = $consultaProveedores['telefono'];
$direccion = $consultaProveedores['direccion'];
$tipo_producto = $consultaProveedores['tipo_producto'];

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
$query = "UPDATE proveedor SET nombre='${nombre}',ci_rif=${ci_rif},preci_rif='${preci_rif}',telefono='${telefono}',direccion='${direccion}',tipo_producto='${tipo_producto}' WHERE id_proveedor = ${id}";

//echo $query; //Probar que envia el query

//exit;

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 6-proveedores.php?mensaje=2"); //Al guardar se envia por la url el mensajed e guardado
}
}
}

include '../include/templates/navegacion.php'; //Navegacion
?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Actualizar Proveedores</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

            <form class="formulario" method="POST">
                <fieldset>
                    <legend>Datos del Proveedor</legend>

                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" id= nombre name="nombre" placeholder="Nombre del Usuario" value="<?php echo $nombre ?>"> 

                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif">
                        <option value="<?php echo $preci_rif?>"> <?php echo $preci_rif?> </option>
                    <?php //Mostrar los otros pre para actyualizar
                    if ($preci_rif === 'J'){
                        echo '<option value="V">V</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'V'){
                        echo '<option value="J">J</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'G'){
                        echo '<option value="J">J</option>';
                        echo '<option value="V">V</option>';
                    }
                    ?>
                    </select>
                    <input class="form-control" type="number" id= ci_rif name="ci_rif" placeholder="Cedula / RIF" value="<?php echo $ci_rif ?>"> 

                    <label for="telefono">Telefono</label>
                    <input class="form-control" type="text" id= telefono name="telefono" placeholder="0424-123-4567" value="<?php echo $telefono ?>"> 

                    <label for="direccion">Direcion</label>
                    <input class="form-control" type="text" id= direccion name="direccion" placeholder="Direccion de Proveedor" value="<?php echo $direccion ?>"> 

                    <label for="tipo_producto">Tipo de Producto</label>
                    <input class="form-control" type="text" id= tipo_producto name="tipo_producto" placeholder="Aceite, Bateria, Filtros..." value="<?php echo $tipo_producto ?>"> 



                </fieldset>

                <input type="submit" value="Actualizar" Class="btn btn-primary boton-envio" autofocus>  
            </form>

        </div>
    </div>

</div>

<?php include '../include/templates/script.php'; //JavaScript
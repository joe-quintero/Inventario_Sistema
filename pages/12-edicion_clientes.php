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
    header('location: 8-clientes.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();


//Consulta para optener Clientes
$consulta = "SELECT * FROM clientes WHERE ci_rif = ${id}";
$resultado = mysqli_query($db,$consulta);
$consultaClientes = mysqli_fetch_assoc($resultado);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$preci_rif = $consultaClientes['preci_rif']; //variables para valores temporales en el formulario
$ci_rif = $consultaClientes['ci_rif'];
$nombre = $consultaClientes['nombre'];
$apellido = $consultaClientes['apellido'];
$telefono = $consultaClientes['telefono'];
$direccion = $consultaClientes['direccion'];

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    //$preci_rif =mysqli_real_escape_string($db , $_POST['preci_rif']);
    //$ci_rif =mysqli_real_escape_string($db , $_POST['ci_rif']);
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
$query = "UPDATE clientes SET ci_rif='${ci_rif}',preci_rif='${preci_rif}',nombre='${nombre}',apellido='${apellido}',telefono='${telefono}',direccion='${direccion}' WHERE ci_rif = ${id}"; 

//echo $query; //Probar que envia el query

//exit;

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 8-clientes.php?mensaje=2");
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
                    <h1 class="page-header">Actualizacion de Clientes</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

            <form class="formulario" method="POST">
            <fieldset>

                    <legend>Datos del Cliente</legend>

                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif" disabled="disabled">
                        <option value="<?php echo $preci_rif?>"> <?php echo $preci_rif?> </option>
                    <?php //Mostrar los otros pre para actyualizar
                    /*if ($preci_rif === 'J'){
                        echo '<option value="V">V</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'V'){
                        echo '<option value="J">J</option>';
                        echo '<option value="G">G</option>';
                    }elseif($preci_rif === 'G'){
                        echo '<option value="J">J</option>';
                        echo '<option value="V">V</option>';
                    }*/
                    ?>
                    </select>
                    <input class="form-control" type="number" id= ci_rif name="ci_rif"  maxlength="9" placeholder="Cedula / RIF" disabled="disabled" value="<?php echo $ci_rif ?>"> 

                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" id= nombre name="nombre" placeholder="Nombre del Usuario" value="<?php echo $nombre ?>"> 

                    <label for="apellido">Apellido</label>
                    <input class="form-control" type="text" id= apellido name="apellido" placeholder="Apellido del Usuario" value="<?php echo $apellido ?>"> 

                    <label for="telefono">Telefono</label>
                    <input class="form-control" type="text" id= telefono name="telefono" placeholder="0424-123-1212" value="<?php echo $telefono ?>"> 

                    <label for="direccion">Direcion</label>
                    <input class="form-control" type="text" id= direccion name="direccion" placeholder="San Bernardino..." value="<?php echo $direccion ?>"> 


                </fieldset>

                <input type="submit" value="Actualizar" Class="btn btn-primary boton-envio" autofocus>  
            </form>

        </div>
    </div>

</div>

<?php include '../include/templates/script.php'; //JavaScript
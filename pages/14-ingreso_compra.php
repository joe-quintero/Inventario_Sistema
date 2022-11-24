<?php
require '../include/templates/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
require '../include/config/database.php';

$id_proveedor = $_GET['id'] ?? null;

$db = conectarDB();

//Consulta para optener cargo
$consultaProveedores = "SELECT * FROM proveedor where id_proveedor = ?";
$stmt = $db->prepare($consultaProveedores);
$stmt->bind_param("i", $id_proveedor); //s:string ;i:integer
$stmt->execute();
$resultado = $stmt->get_result();
$prov = $resultado->fetch_object();

$consultaProductosProv = "SELECT * FROM PRODUCTOS WHERE ID_PROVEEDOR = ?";

$stmt = $db->prepare($consultaProductosProv);
$stmt->bind_param("i", $id_proveedor); //s:string ;i:integer
$stmt->execute();
$resultadoProducto = $stmt->get_result(); // get the mysqli result


//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

// $nombre = ''; //variables para valores temporales en el formulario
// $apellido = '';
// $identificacion = '';
// $usuario =  '';
$id_proveedor = '';

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    // $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    // $apellido =mysqli_real_escape_string($db , $_POST['apellido']);
    // $identificacion =mysqli_real_escape_string($db , $_POST['identificacion']);
    // $usuario =mysqli_real_escape_string($db , $_POST['usuario']);
    $id_proveedor =mysqli_real_escape_string($db , $_POST['id_proveedor']);
    // $fecha = date('Y/m/d');

//Se valida el fomulario.
    // if (!$nombre){
    //     $errores[]= "Debe colocar el Nombre";
    // }

    // if (!$apellido){
    //     $errores[]= "Debe colocar el Apellido";
    // }

    // if (strlen ($identificacion) < 7){
    //     $errores[]= "Debe colocar la Cedula corecta";
    // }

    // if (!$usuario){
    //     $errores[]= "Debe colocar Nombre de usuario";
    // }

    if (!$id_proveedor){
        $errores[]= "Debe elegir un Proveedor";
    }

//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio

//Creacion de clave Hasheada
// $password = 'abc123';
// $passwordHash = password_hash($password, PASSWORD_BCRYPT);

// # Insertar en la Bade de Datos
// $query = "INSERT INTO usuarios (nombre, apellido, identificacion, usuario, id_cargo, password, fecha) 
// VALUES ('$nombre', '$apellido', '$identificacion', '$usuario', '$id_cargo', '$passwordHash', '$fecha')"; 

/*
echo $query; //Probar que envia el query
exit;
*/

$resultado = mysqli_query($db, $query);

// if ($resultado) {
//     header("Location: 1-registro_usuario.php?mensaje=1"); //Al guardar se envia por la url el mensajed e guardado
// }
}
}

include '../include/templates/navegacion.php'; //Navegacion
?>


    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Registro de Compra</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>

<!-- <?php if (intval($mensaje)===1): //Mensaje de exitodo mostrando ?>
    <p class="alerta exito">¡Usuario creado exitosamente!</p> 
<?php endif; ?> -->

            <form class="formulario" method="POST" action="">
                <fieldset>
                    <legend>Selecionar Proveedor</legend>

                    <select name="id_proveedor" id="id_proveedor" name="id_proveedor" class="selectBusqueda">
                        <option value="">---Seleccionar---</option>
                        
                    </select>
                    I  
                    <input type="text" value = "<?php echo $prov->nombre?>">
                    
                    <select name="id_producto" id="id_producto" class="selectBusqueda">
                        <option value="">---Seleccionar---</option>
                        <?php while ($row = mysqli_fetch_assoc($resultadoProducto) ): ?>
                            <option value="<?php echo $row ['id_producto'] ?>"><?php echo $row ['nombre'] ?> </option>
                        <?php endwhile ?>
                    </select>
                </fieldset>
                <br>
                <input type="submit" value="Selecionarasdasdas Proveedor" class="boton-envio">  
            </form>
        </div>
    </div>
</div>

<?php include '../include/templates/script.php';//JavaScript ?> 
<script>
    console.log('<?php echo $prov->nombre?>')
</script>   
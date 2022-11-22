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
    header('location: 5-usuarios.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();

//Consulta para optener informacion de Usuario
$consulta = "SELECT usuario, nombre, apellido, identificacion, id_cargo FROM usuarios WHERE id_usuario = ${id}";
$resultado = mysqli_query($db, $consulta);
$consultaUsuarios = mysqli_fetch_assoc($resultado);

//Consulta para optener cargo
$consultaCargos = "SELECT * FROM cargo WHERE id_cargo <> 1";
$resultado = mysqli_query($db,$consultaCargos);




//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = $consultaUsuarios['nombre']; //variables para valores temporales en el formulario
$apellido = $consultaUsuarios['apellido'];
$identificacion = $consultaUsuarios['identificacion'];
$usuario = $consultaUsuarios['usuario'];
$id_cargo = $consultaUsuarios['id_cargo'];

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    $apellido =mysqli_real_escape_string($db , $_POST['apellido']);
    $identificacion =mysqli_real_escape_string($db , $_POST['identificacion']);
    $usuario =mysqli_real_escape_string($db , $_POST['usuario']);
    $id_cargo =mysqli_real_escape_string($db , $_POST['id_cargo']);
    $fecha = date('Y/m/d');

//Se valida el fomulario.
    if (!$nombre){
        $errores[]= "Debe colocar el Nombre";
    }

    if (!$apellido){
        $errores[]= "Debe colocar el Apellido";
    }

    if (strlen ($identificacion) < 7){
        $errores[]= "Debe colocar la Cedula corecta";
    }

    if (!$usuario){
        $errores[]= "Debe colocar Nombre de usuario";
    }

    if (!$id_cargo){
        $errores[]= "Debe elegir el Cargo";
    }

//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio
    
# Insertar en la Bade de Datos
$query = "UPDATE usuarios SET nombre = '${nombre}' , apellido = '${apellido}' , identificacion = ${identificacion} , usuario = '${usuario}' , id_cargo = ${id_cargo} WHERE id_usuario = ${id}"; 


//echo $query; //Probar que envia el query

//exit;

$resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 5-usuarios.php?mensaje=2"); //Al guardar se envia por la url el mensajed e guardado
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
                    <h1 class="page-header">Actualizar Usuario</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>


            <form class="formulario" method="POST">
                <fieldset>
                    <legend>Datos del Usuario</legend>

                    <label for="nombre">Nombre</label>
                    <input type="text" id= nombre name="nombre" placeholder="Nombre del Usuario" value="<?php echo $nombre; ?>"> 
                    <br>
                    <label for="apellido">Apellido</label>
                    <input type="text" id= apellido name="apellido" placeholder="Apellido del Usuario" value="<?php echo $apellido; ?>"> 
                    <br>
                    <label for="identificacion">Cedula</label>
                    <input type="number" id= identificacion name="identificacion" maxlength="10" placeholder="Cedula de identidad" value="<?php echo $identificacion; ?>"> 
                    <br>
                    <label for="usuario">Usuario</label>
                    <input type="text" id= usuario name="usuario" placeholder="Nombre de Usuario" value="<?php echo $usuario; ?>"> 
                    <br>
                    <label for="id_cargo">Cargo</label>
                    <select name="id_cargo" id="id_cargo" name="id_cargo">
                        <option value="">---Seleccionar---</option>
                        <?php while ($row = mysqli_fetch_assoc($resultado) ): ?>
                            <option   <?php echo $id_cargo === $row ['id_cargo'] ? 'selected' : ''; ?>   value="<?php echo $row ['id_cargo'] ?>"> <?php echo $row ['cargo'] ?> </option>
                        <?php endwhile ?>
                    </select>
                </fieldset>

                <input type="submit" value="Actualizar" class="boton-envio">  
            </form>

        </div>
    </div>

</div>

<?php include '../include/templates/script.php'; //JavaScript
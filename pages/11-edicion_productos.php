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
    header('location: 7-productos.php');
}

//Importamos conexion Base de Datos
require '../include/config/database.php';

//Conexion Base de Datos
$db = conectarDB();

//Consulta para optener Productos
$consulta = "SELECT * FROM productos WHERE id_producto = ${id}";
$resultadoProductos = mysqli_query($db,$consulta);
$consultaProductos = mysqli_fetch_assoc($resultadoProductos);

//Consulta para optener Proveedores
$consultaProveedor = "SELECT * FROM proveedor";
$resultado = mysqli_query($db,$consultaProveedor);

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = $consultaProductos['nombre']; //variables para valores temporales en el formulario
$tipo_producto = $consultaProductos['tipo_producto'];
$marca = $consultaProductos['marca'];
$precio_costo = $consultaProductos['precio_costo'];
$precio_venta = $consultaProductos['precio_venta'];
$descripcion = $consultaProductos['descripcion'];
$aplicacion = $consultaProductos['aplicacion'];
$codigo_barra = $consultaProductos['codigo_barra'];
$id_proveedor = $consultaProductos['id_proveedor'];

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    $tipo_producto =mysqli_real_escape_string($db , $_POST['tipo_producto']);
    $marca =mysqli_real_escape_string($db , $_POST['marca']);
    $precio_costo =mysqli_real_escape_string($db , $_POST['precio_costo']);
    $precio_venta =mysqli_real_escape_string($db , $_POST['precio_venta']);
    $descripcion =mysqli_real_escape_string($db , $_POST['descripcion']);
    $aplicacion =mysqli_real_escape_string($db , $_POST['aplicacion']);
    $codigo_barra =mysqli_real_escape_string($db , $_POST['codigo_barra']);
    $id_proveedor =mysqli_real_escape_string($db , $_POST['id_proveedor']);
    $nombre_proveedor =mysqli_real_escape_string($db , $_POST['nombre_proveedor']);

    //$fecha = date('Y/m/d');


//Se valida el fomulario.
    if (!$nombre){
        $errores[]= "Debe colocar el Nombre";
    }

    if (!$tipo_producto){
        $errores[]= "Debe colocar el tipo de producto";
    }

    if (!$marca){
        $errores[]= "Debe colocar la marca";
    }

    if (!$precio_costo){
        $errores[]= "Debe indicar el precio de costo";
    }

    if (!$precio_venta){
        $errores[]= "Debe indicar el precio de venta";
    }

    if (!$aplicacion){
        $errores[]= "Debe indicar la aplicacion del producto";
    }

    if (!$id_proveedor){
        $errores[]= "Debe seleccionar el proveedor del producto";
    }

//Mostrar en formato Array lo que hay en la variable errores.
// echo "<pre>";  
// var_dump($errores);
// echo "</pre>";   

//Revisar que el array de errores este vacio para ejecutar el query
    if(empty($errores)){ // ----- emtpty revisa que el arreglo se encuentre vacio
    
# Insertar en la Bade de Datos
$query = "UPDATE productos SET nombre='${nombre}',tipo_producto='${tipo_producto}',marca='${marca}',precio_costo='${precio_costo}',precio_venta='${precio_venta}',descripcion='${descripcion}',aplicacion='${aplicacion}',codigo_barra='${codigo_barra}',id_proveedor='${id_proveedor}' WHERE id_producto = ${id}"; 

//echo $query; //Probar que envia el query

//exit;

    $resultado = mysqli_query($db, $query);

if ($resultado) {
    header("Location: 7-productos.php?mensaje=2");
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
                    <h1 class="page-header">Actualizar Productos</h1>
                </div>
            </div>


<?php foreach($errores as $error): ?>
<div class = " alerta error">
    <?php echo $error; ?>
</div>
<?php endforeach; ?>


            <form class="formulario" method="POST">
                <fieldset>
                    <legend>Datos del Producto</legend>

                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" id= nombre name="nombre" placeholder="Nombre del Producto" value="<?php echo $nombre ?>"> 

                    <label for="tipo_producto">Tipo de Producto</label>
                    <input class="form-control" type="text" id= tipo_producto name="tipo_producto" placeholder="Aceite 20-50 Minaral" value="<?php echo $tipo_producto ?>"> 

                    <label for="marca">Marca</label>
                    <input class="form-control" type="text" id= marca name="marca" placeholder="Ultra Lub" value="<?php echo $marca ?>"> 

                    <label for="precio_costo">Precio de Costo</label>
                    <input class="form-control" type="number" id= precio_costo name="precio_costo" placeholder="10" value="<?php echo $precio_costo ?>"> 

                    <label for="precio_venta">Precio de venta</label>
                    <input class="form-control" type="number" id= precio_venta name="precio_venta" placeholder="11" value="<?php echo $precio_venta ?>"> 

                    <label for="descripcion">Descripcion</label>
                    <input class="form-control" type="text" id= descripcion name="descripcion" placeholder="Aceite mineral para motor" value="<?php echo $descripcion ?>"> 

                    <label for="aplicacion">Aplicacion</label>
                    <input class="form-control" type="text" id= aplicacion name="aplicacion" placeholder="Carro, Moto, Corolla" value="<?php echo $aplicacion ?>"> 

                    <label for="codigo_barra">Codigo de Barra</label>
                    <input class="form-control" type="number" id= codigo_barra name="codigo_barra" placeholder="123456789" value="<?php echo $codigo_barra ?>"> 

                    <label for="id_proveedor">Proveedor</label>
                    <select name="id_proveedor" id="id_proveedor" class = "selectBusqueda" name="id_proveedor">
                        <option value="">---Seleccionar---</option>
                        <?php while ($row = mysqli_fetch_assoc($resultado) ): ?>
                            <option   <?php echo $id_proveedor === $row ['id_proveedor'] ? 'selected' : ''; ?>   value="<?php echo $row ['id_proveedor'] ?>"> <?php echo $row ['nombre']." - ".$row ['preci_rif'].$row ['ci_rif'] ?> </option>
                        <?php endwhile ?> 
                    </select>
                </fieldset>

                <input type="submit" value="Actualizar" Class="btn btn-primary boton-envio" autofocus>  
            </form>

        </div>
    </div>

</div>

<?php include '../include/templates/script.php'; //JavaScript
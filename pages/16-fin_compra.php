<?php
require '../include/templates/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
require '../include/config/database.php';

$id_proveedor = $_GET['id'] ?? null;
$dataStr = $_POST['productosCompra'] ?? null;
$productosCompra = json_decode($dataStr);

$db = conectarDB();

foreach($productosCompra as $producto) {
    //1) Crear operacion
    //2) Actualizar cantidad de producto
    $insertarOperacion = "INSERT INTO operacion(operacion, id_producto, nombre_producto, cirif_cleinte_proveedor, nombre_cliente_proveedor, cantidad, precio_unitario, precio_total, fecha, id_usuario, nombre_usuario, id_tipo_operacion) VALUES ('COMPRA', ?, ?, '111111111', 'PEPE', ?, ?, ?, sysdate(), '1', 'jdquintero', '101')";
    $stmt = $db->prepare($insertarOperacion);
    //echo $producto['id'];
    $stmt->bind_param("isidd", $producto->id, $producto->nombre, $producto->cantidad, $producto->precio, $producto->acumulado);
    $stmt->execute();
    $stmt->close();

    //Aumentar en productos
    $updtProductos = "UPDATE PRODUCTOS SET CANTIDAD = CANTIDAD + ".$producto->cantidad." WHERE ID_PRODUCTO = ?";
    $stmt = $db->prepare($updtProductos);
    $stmt->bind_param("i", $producto->id);
    $stmt->execute();
    $stmt->close();
}

//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

//variables para valores temporales en el formulario

// Ejecutar el codigo luego que el usuario envia el formulario.

include '../include/templates/navegacion.php'; //Navegacion
//$arrProductos = [];

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
                <h1>Compra realizada exitosamente</h1>
            
            <div>
            
        </div>
        </div>
    </div>
</div>

<?php include '../include/templates/script.php';//JavaScript ?> 
<script>
    console.log('<?php echo $prov->nombre?>');
    
    var productos = [];
    var productosBD = {};

    <?php 

        if(!empty($arrProductos)) { 
            echo "console.log('".json_encode($arrProductos)."');\n
                productosBD = JSON.parse('".json_encode($arrProductos)."');\n  " ;   
        ?>

    <?php } ?>

    let lineNo = 1; //Agregar productos a tabla´
    let acumulado = 0.0;
        $(document).ready(function () {
            $(".add-row").click(function () {
                
                const id =$("#id_producto").val()
                const cantidad = $("#cantidad").val()

                //Validaciones
                if(id == null || id == '') {
                    alert('Por favor, seleccione un producto.');
                }

                if(cantidad == null || cantidad == '') {
                    alert('Por favor, indique cantidad a comprar');
                }

                let p = productosBD[id];
                acumulado += parseFloat(p.precio) * parseFloat(cantidad)
                productos.push(p)

                markup = "<tr><td> " + p.nombre + 
                        "</td><td> " + cantidad 
                    +"</td><td> $ " + p.precio 
                    + "</td><td> $ " + acumulado
                    + "</td></tr>";
                tableBody = $("table tbody");
                tableBody.append(markup);
                lineNo++;
            });
        }); 
</script>   
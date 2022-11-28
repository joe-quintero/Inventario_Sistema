<?php
require '../include/templates/funciones.php'; //Funciones
$auth=usuarioAutenticado();//Validacion de suuario autenticado

if(!$auth){
    header('location: login.php');
}

$mensaje= $_GET['mensaje'] ?? null; // variable por la url de mensaje
require '../include/config/database.php';

$db = conectarDB();

//Consulta para optener cargo
$consultaProductos = "SELECT * FROM productos";
//$resultado = mysqli_query($db,$consultaProductos);

$stmt = $db->prepare($consultaProductos);
$stmt->execute();
$resultadoProducto = $stmt->get_result(); // get the mysqli result


//Array con mensajes de Error para lavidar que los campos no se envien vacios
$errores= [];

$nombre = ''; //variables para valores temporales en el formulario
// $apellido = '';
$identificacion = '';
// $usuario =  '';
$id_producto = '';

// Ejecutar el codigo luego que el usuario envia el formulario.
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
// echo "<pre>";  //Mostrar en formato Array lo que se envia a la BD
// var_dump($_POST);
// echo "</pre>";

    // $nombre =mysqli_real_escape_string($db , $_POST['nombre']);
    // $apellido =mysqli_real_escape_string($db , $_POST['apellido']);
    // $identificacion =mysqli_real_escape_string($db , $_POST['identificacion']);
    // $usuario =mysqli_real_escape_string($db , $_POST['usuario']);
    // $id_proveedor =mysqli_real_escape_string($db , $_POST['id_proveedor']);
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

// $resultado = mysqli_query($db, $query);

// if ($resultado) {
//     header("Location: 1-registro_usuario.php?mensaje=1"); //Al guardar se envia por la url el mensajed e guardado
// }
}
}

include '../include/templates/navegacion.php'; //Navegacion
$arrProductos = array(
);

while ($row = mysqli_fetch_assoc($resultadoProducto) ) {
    $arrProductos[$row["id_producto"]] =  array(
        "id" => $row["id_producto"],
        "nombre" => $row["nombre"],
        "tipo" => $row["tipo_producto"],
        "marca" => $row["nombre"],
        "precio" => $row["precio_venta"],
        "cantidad" => $row["cantidad"]
    );
}



?>


    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Registro de Venta</h1>
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

            <form class="formulario" method="POST">
                <fieldset>
                    <legend>Selecionar Productos</legend>
                    <label for="preci_rif">CI - RIF</label>
                    <select name="preci_rif" id="preci_rif" name="preci_rif">
                        <option value="">-</option>
                        <option value="V">V</option>
                        <option value="J">J</option>
                        <option value="G">G</option>
                    </select>
                    <input class="form-control" type="number" id= ci_rif name="ci_rif"  maxlength="9" placeholder="Cedula / RIF" value="<?php echo $ci_rif ?>" autofocus> 

                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" id= nombre name="nombre" placeholder="Nombre del Cliente" value="<?php echo $nombre ?>"> 

                    <label for="cantidad">Producto</label>
                    <select name="id_producto" id="id_producto" name="id_producto" class="selectBusqueda">
                        <option value="">---Seleccionar---</option>
                        <?php foreach ($arrProductos as $row ){ 
                        ?>
                            <option   <?php echo $id_producto === $row ['id'] ? 'selected' : ''; ?>   value="<?php echo $row ['id'] ?>">
                            Nombre: <?php echo $row ['nombre'] ?>
                            - Tipo: <?php echo $row ['tipo'] ?>
                            - Marca: <?php echo $row ['marca'] ?>
                            - Disponible: <?php echo $row ['cantidad'] ?> 
                            - Precio: <?php echo $row ['precio']?>$</option>
                        <?php  }?>
                    </select>
                    <br>
                    <label for="cantidad">Cantidad</label>
                    <input class="form-control" type="number" id= cantidad name="cantidad" placeholder="10"> 

                </fieldset>
                <br>
            </form>
            <br>
            <button class="add-row">Agregar Prodcutos</button>
            <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>precio</th>
                    <th>Total</th>
                    </tr>   
                </thead>
                <tbody> <!-- Mostramos los resultados del Query -->                  
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
                </tbody>
            </table>
            <br>
            <button onclick = "enviarFormulario()">Realizar Venta</button>
        </div>
    </div>

</div>

<form id="formulario" method="POST" action="17-fin_venta.php">
                <input type="hidden" id="dataJson" name="productosVenta" value="">
            </form>

<?php include '../include/templates/script.php'; //JavaScript ?>
<script>

    var productos = [];
    var productosBD = {};

<?php 

        if(!empty($arrProductos)) { 
            echo "console.log('".json_encode($arrProductos)."');\n
            productosBD = JSON.parse('".json_encode($arrProductos)."');\n  " ;   
?>
    <?php } ?>

    const disponible = $(productosBD['cantidad']).val()
    alert(disponible)

    let lineNo = 1; //Agregar productos a tabla´
        $(document).ready(function () {
            $(".add-row").click(function () {
                let acumulado = 0.0;
                const id =$("#id_producto").val()
                const cantidad = $("#cantidad").val()

                //Validaciones
                if(id == null || id == '') {
                    alert('Por favor, seleccione un producto.');
                    return false
                }

                if(cantidad == null || cantidad == '') {
                    alert('Por favor, indique cantidad a comprar');
                    return false;
                }

                let p = productosBD[id];
                p['cantidad'] = cantidad;
                acumulado += parseFloat(p.precio) * parseFloat(cantidad)
                p['acumulado'] = acumulado
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

        function enviarFormulario() {
            //validaciones
            if(productos.length < 1) {
                alert('Por favor, agregue productos')
                return false;
            }
            $("#dataJson").val(JSON.stringify(productos));
            $("#formulario").submit();
        }
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palladium Hotel Group</title>
    <link rel="icon" href="img/vista.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: aliceblue;
        }
    </style>
</head>
<body>
    <?php
    // Incluir la conexión a la base de datos
    require 'conexion.php';
    require 'phpqrcode/qrlib.php'; // Librería PHP QR Code
    require './Perfil/navbar.php'
    ?>

    <!-- Contenedor Principal (50% de la pantalla) -->
    <div class="container w-50 mt-5 shadow p-5 bg-transparent rounded text-center">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="img/Palladium.png" width="55" alt="">
            <img src="img/gp_hotels.png" width="55" alt="">
            <img src="img/TRS.png" width="55" alt="">
            <img src="img/ayre.png" width="55" alt="">
            <img src="img/fiesta.png" width="55" alt="">
            <img src="img/hardrock.jpg" width="55" alt="">
            <img src="img/oy-logo.png" width="55" alt="">
            <img src="img/ushuaia.png" width="55" alt="">
            <img src="img/pbh-logo.png" width="55" alt="">
        </div>

    <div class="container">
    <h2 class="text-center mb-4">Panel de Registro</h2>

        <!-- Selector de tipo de registro -->
        <div class="text-center mb-5">
            <h4>Seleccione el tipo de usuario a registrar:</h4>
            <div class="btn-group" role="group" aria-label="Opciones de Registro">
                <button class="btn btn-outline-primary" id="btnEmpleado">Registrar Empleado</button>
                <button class="btn btn-outline-secondary" id="btnInvitado">Registrar Invitado</button>
                <button class="btn btn-outline-success" id="btnProveedor">Registrar Proveedor</button>
            </div>
        </div>

        <!--aqui cierra el contendor de registro dinamico como el del registro-->
        <!-- Formulario dinámico que se mostrará según la selección -->
        <div id="formContainer" class="p-4 shadow rounded bg-white"></div>
    </div>

    <!-- Script para manejar los formularios -->
    <script>
        const btnEmpleado = document.getElementById('btnEmpleado');
        const btnInvitado = document.getElementById('btnInvitado');
        const btnProveedor = document.getElementById('btnProveedor');
        const formContainer = document.getElementById('formContainer');

        // Limpiar el contenedor del formulario
        function clearForm() {
            formContainer.innerHTML = '';
        }

        // Formulario de registro de empleados
        function formEmpleado() {
            clearForm();
            formContainer.innerHTML = `
                <h4>Registro de Empleado</h4>
                <form action="PanelQr.php" method="POST">
                <input type="hidden" name="tipo" value="empleado">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre y Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="numero_colaborador" class="form-label">Número de Colaborador <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="numero_colaborador" name="numero_colaborador" required>
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Departamento</label>
                        <select class="form-select" id="area" name="area" required>
                        <option value="" disabled selected>Selecciona un Departamento</option>
                        <option value="RRHH">RRHH</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Lavanderia">Lavanderia</option>
                        <option value="Roperia">Roperia</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label for="tipo_Qr" class="form-label">Tipo de Qr <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipo_Qr" name="tipo_Qr" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="permanente">Permanente</option>
                        <option value="temporal">Temporal</option>
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="placas" class="form-label">Placas del Vehículo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="placas" name="placas" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo_marca" class="form-label">Modelo y Marca <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modelo_marca" name="modelo_marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color del Vehículo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Empleado</button>
                </form>
            `;
        }

        // Formulario de registro de invitados
        function formInvitado() {
            clearForm();
            formContainer.innerHTML = `
                <h4>Registro de Invitado</h4>
                <form action="PanelQr.php" method="POST">
                    <input type="hidden" name="tipo" value="invitado">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre y Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="area_asiste" class="form-label">Área a la que Asiste <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_asiste" name="area_asiste" required>
                    </div>

                    <div class="mb-3">
                    <label for="tipo_Qr" class="form-label">Tipo de Qr <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipo_Qr" name="tipo_Qr" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="permanente">Permanente</option>
                        <option value="temporal">Temporal</option>
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="placas" class="form-label">Placas del Vehículo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="placas" name="placas" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo_marca" class="form-label">Modelo y Marca <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modelo_marca" name="modelo_marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color del Vehículo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Registrar Invitado</button>
                </form>
            `;
        }

        // Formulario de registro de proveedores
        function formProveedor() {
            clearForm();
            formContainer.innerHTML = `
                <h4>Registro de Proveedor</h4>
                <form action="PanelQr.php" method="POST">
                    <input type="hidden" name="tipo" value="proveedor">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre y Apellido</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor" required>
                    </div>

                    <div class="mb-3">
                    <label for="tipo_Qr" class="form-label">Tipo de Qr</label>
                            <select class="form-control" id="tipo_Qr" name="tipo_Qr" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="permanente">Permanente</option>
                        <option value="temporal">Temporal</option>
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="placas" class="form-label">Placas del Vehículo</label>
                        <input type="text" class="form-control" id="placas" name="placas" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo_marca" class="form-label">Modelo y Marca</label>
                        <input type="text" class="form-control" id="modelo_marca" name="modelo_marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color del Vehículo</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                    <button type="submit" class="btn btn-success">Registrar Proveedor</button>
                </form>
            `;
        }

        // Asignar eventos a los botones
        btnEmpleado.addEventListener('click', formEmpleado);
        btnInvitado.addEventListener('click', formInvitado);
        btnProveedor.addEventListener('click', formProveedor);
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Procesar el formulario y generar el código QR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $placas = $_POST['placas'];
    $modeloMarca = $_POST['modelo_marca'];
    $color = $_POST['color'];

    // Insertar los datos en la base de datos según el tipo
    
    // Verificar si las placas ya están registradas en alguna de las tablas: empleados, invitados o proveedores
    $verificar_placas_empleados = $conn->prepare("SELECT * FROM empleados WHERE placas_vehiculo = :placas");
    $verificar_placas_invitados = $conn->prepare("SELECT * FROM invitados WHERE placas_vehiculo = :placas");
    $verificar_placas_proveedores = $conn->prepare("SELECT * FROM proveedores WHERE placas_vehiculos = :placas");
    
    // Vincular el parámetro de las placas
    $verificar_placas_empleados->bindParam(':placas', $placas);
    $verificar_placas_invitados->bindParam(':placas', $placas);
    $verificar_placas_proveedores->bindParam(':placas', $placas);

    // Ejecutar las consultas
    $verificar_placas_empleados->execute();
    $verificar_placas_invitados->execute();
    $verificar_placas_proveedores->execute();

    // Verificar si hay algún registro que coincida, se agrego un fetch para verificar el registro de placas
    $placa_existe_en_empleados = $verificar_placas_empleados->fetch(); 
    $placa_existe_en_invitados = $verificar_placas_invitados->fetch();
    $placa_existe_en_proveedores = $verificar_placas_proveedores->fetch();

    //Si las placas ya existen en alguna de las tablas, mostrar error

    if ($placa_existe_en_empleados || $placa_existe_en_invitados || $placa_existe_en_proveedores){
        echo "<div class='alert alert-danger text-center'>Error: Ya existe un registro con esas placas en empleados, invitados o proveedores.</div>";
    } else {
        //solo si las placas no existen, se procede a generar el QR y registrar en la base de datos
        // Preparar contenido del QR
    $contenidoQR = "$nombre  - $placas - $modeloMarca - $color";

    // Generar la fecha actual
    $fechaActual = date('Y-m-d H:i:s');
    
    // Si es un invitado o proveedor, generamos un vencimiento de 3 día
    if ($tipo == 'invitado' || $tipo == 'proveedor') {
        // Crear una fecha de vencimiento (3 día desde la fecha actual)
        $vencimiento = date('Y-m-d H:i:s', strtotime('+3 day', strtotime($fechaActual)));
        $contenidoQR = "$nombre - $placas - $modeloMarca - $color - Vence el: $vencimiento";
    } else {
        // Para empleados, no se establece vencimiento, el QR es permanente
        $contenidoQR = "$nombre - $placas - $modeloMarca - $color - Permanente";
    }

    // Ruta donde se guardará el QR
        //$filename = "img_qr/qr_$tipo" . time() . ".png";

    //Sanitizar el nombre para evitar problemas con los nombres de archivo
        $nombre_sanitizado = str_replace('','_',$nombre);
    //Si es empleado, usamos el Nombre y Numero de colaborador en el nombre del archivo
        if ($tipo == 'empleado'){
            $numeroColaborador=$_POST['numero_colaborador'];
            $filename="img_qr/qr_" . $nombre_sanitizado . "_" . $numeroColaborador . ".png";
        }

    // Para invitados, usamos solo el nombre en el archivo
        elseif ($tipo == 'invitado') {
        $filename = "img_qr/qr_" . $nombre_sanitizado . ".png";
        } 
    // Para proveedores, usamos solo el nombre del proveedor en el archivo
        elseif ($tipo == 'proveedor') {
        $proveedor = $_POST['proveedor'];
        $proveedor_sanitizado = str_replace(' ', '_', $proveedor); // Sanitizar nombre del proveedor
        $filename = "img_qr/qr_" . $proveedor_sanitizado . ".png"; // Solo el nombre del proveedor en el archivo
        }

        // Mostrar el código QR
        echo "<div class='alert alert-success text-center'>Registro exitoso. Código QR generado.</div>";

        
    // Opción para descargar el código QR y Se guarda con el nombre de cada uno
    if ($tipo == 'empleado') {
        echo "<a href='$filename' download='codigo_qr_" . urlencode($nombre_sanitizado) ."' class='btn btn-primary'>Descargar Código QR</a>";
    } elseif ($tipo == 'invitado') {
        echo "<a href='$filename' download='codigo_qr_" . urlencode($nombre_sanitizado) . "' class='btn btn-primary'>Descargar Código QR</a>";
    } elseif ($tipo == 'proveedor') {
        echo "<a href='$filename' download='codigo_qr_" . urlencode($proveedor_sanitizado) . "' class='btn btn-primary'>Descargar Código QR</a>";
    }
    
    // Generar el QR
        QRcode::png($contenidoQR, $filename, QR_ECLEVEL_L, 6);

        //insercion de los datos segun el tipo
    try{
    //aqui van los datos del empleado
    if ($tipo == 'empleado') {
        $numeroColaborador = $_POST['numero_colaborador'];
        $area = $_POST['area'];
        $sql = "INSERT INTO empleados (nombre_apellido, numero_colaborador, area, placas_vehiculo, modelo_marca, color_vehiculo, qr_code) 
                VALUES ('$nombre', '$numeroColaborador', '$area', '$placas', '$modeloMarca', '$color', '$filename')";
    } 
    //aqui va los datos del invitado
    elseif ($tipo == 'invitado') {
        $areaAsiste = $_POST['area_asiste'];
        $sql = "INSERT INTO invitados (nombre_apellido, area_asistencia, placas_vehiculo, modelo_marca, color_vehiculo, qr_code) 
                VALUES ('$nombre', '$areaAsiste', '$placas', '$modeloMarca', '$color', '$filename')";
    } 
    //aqui van los datos del proveedor
    else {
        $proveedor= $_POST['proveedor'];
        $sql = "INSERT INTO proveedores (nombre_apellido, proveedor, placas_vehiculos, modelo_marca, color_vehiculo, qr_code) 
                VALUES ('$nombre', '$proveedor', '$placas', '$modeloMarca', '$color', '$filename')";
    }

    // Ejecutar la inserción
    if ($conn->query($sql)) {
        //mostrar mensaje de exitoy el QR
        echo "<div class= 'text-center'> <img src='$filename' alt='código QR'></div>";
    } else {
        //manejar errores en la consulta
        $errorInfo = $conn->errorInfo();
        echo "<div class='alert alert-danger text-center'>Error al registrar: " . $errorInfo[2] . "</div>";
    }
        } catch (PDOException $e){ 
            //Captura el error de PDO
            echo "<div class='alert alert-danger text-center'>Error al registrar: " .$e->getMessage() . "</div>";
        }
    }
}
// solo queda hacer que el numero de colabolador sea unico o agregarle el PRIMARY KEY
?>
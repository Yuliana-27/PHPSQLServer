<?php
// Incluir el archivo de conexión
require '../conexion.php';
// Incluir la librería PHP QR Code
include('../phpqrcode/qrlib.php');

// Inicializar variable para la búsqueda
$busqueda = '';

// Verificar si se ha enviado un término de búsqueda
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['numero_colaborador'];
}

// Actualizar empleado
if (isset($_POST['actualizar'])) {
    $id_ = $_POST['id'];
    $nombre_apellido_ = $_POST['nombre_apellido'];
    $numero_colaborador_ = $_POST['numero_colaborador'];
    $area_ = $_POST['area'];
    $placas_vehiculo_ = $_POST['placas_vehiculo'];
    $modelo_marca_ = $_POST['modelo_marca'];
    $color_vehiculo_ = $_POST['color_vehiculo'];

    // Generar el contenido del QR usando los datos actualizados
    $qrContent = "Nombre: $nombre_apellido_ \nColaborador: $numero_colaborador_ \nÁrea: $area_ \nVehículo: $modelo_marca_ ($color_vehiculo_)";

    // Ruta donde se guardará la imagen del código QR
    $qrFilePath = "../img_qr/qr_" . $numero_colaborador_ . ".png";

    // Generar el código QR
    QRcode::png($qrContent, $qrFilePath);

    // Guardar la ruta o el nombre del archivo QR en la base de datos
    $qr_code_ = $qrFilePath;

    $sql = "UPDATE empleados SET nombre_apellido = ?, numero_colaborador = ?, area = ?, placas_vehiculo = ?, modelo_marca = ?, color_vehiculo = ?, qr_code = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nombre_apellido_, $numero_colaborador_, $area_, $placas_vehiculo_, $modelo_marca_, $color_vehiculo_, $qr_code_, $id_])) {
        echo "<div class='alert alert-success' role='alert'>Empleado y código QR actualizados correctamente</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al actualizar el empleado</div>";
    }
}

// Eliminar empleado
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $sql = "DELETE FROM empleados WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$id])) {
        echo "<div class='alert alert-success' role='alert'>Empleado eliminado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al eliminar el empleado</div>";
    }
}

// Habilitar/deshabilitar empleado
if (isset($_GET['habilitar']) || isset($_GET['deshabilitar'])) {
    $id = isset($_GET['habilitar']) ? $_GET['habilitar'] : $_GET['deshabilitar'];
    $estado = isset($_GET['habilitar']) ? 1 : 0;

    $sql = "UPDATE empleados SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$estado, $id])) {
        echo "<div class='alert alert-success' role='alert'>Empleado " . (isset($_GET['habilitar']) ? 'habilitado' : 'deshabilitado') . " correctamente</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al actualizar el estado del empleado</div>";
    }
}

// Obtener empleados (con búsqueda)
$sql = "SELECT id, nombre_apellido, numero_colaborador, area, placas_vehiculo, modelo_marca, color_vehiculo, qr_code, estado FROM empleados";
if ($busqueda) {
    $sql .= " WHERE numero_colaborador LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$busqueda%"]);
} else {
    $stmt = $conn->query($sql);
}
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palladium Hotel Group</title>
    <link rel="icon" href="../img/vista.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Gestión de Colaboradores</h1>

        <!-- Formulario de búsqueda -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por número de colaborador" name="numero_colaborador" value="<?php echo htmlspecialchars($busqueda); ?>" required>
                <button class="btn btn-outline-secondary" type="submit" name="buscar">Buscar</button>
            </div>
        </form>

        <!-- Formulario de actualización -->
        <?php if (isset($_GET['id'])): 
            $id = $_GET['id'];
            $sql = "SELECT nombre_apellido, numero_colaborador, area, placas_vehiculo, modelo_marca, color_vehiculo, qr_code FROM empleados WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $empleado = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <form method="POST" class="mb-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="nombre_apellido" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_apellido" name="nombre_apellido" value="<?php echo $empleado['nombre_apellido']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="numero_colaborador" class="form-label">Numero de Colaborador</label>
                <input type="text" class="form-control" id="numero_colaborador" name="numero_colaborador" value="<?php echo $empleado['numero_colaborador']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <input type="text" class="form-control" id="area" name="area" value="<?php echo $empleado['area']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="placas_vehiculo" class="form-label">Placas del Vehículo</label>
                <input type="text" class="form-control" id="placas_vehiculo" name="placas_vehiculo" value="<?php echo $empleado['placas_vehiculo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="modelo_marca" class="form-label">Modelo y Marca del Vehículo</label>
                <input type="text" class="form-control" id="modelo_marca" name="modelo_marca" value="<?php echo $empleado['modelo_marca']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="color_vehiculo" class="form-label">Color del Vehículo</label>
                <input type="text" class="form-control" id="color_vehiculo" name="color_vehiculo" value="<?php echo $empleado['color_vehiculo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="qr_code" class="form-label">Codigo QR</label>
                <input type="text" class="form-control" id="qr_code" name="qr_code" value="<?php echo $empleado['qr_code']; ?>" required>
            </div>
            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
        </form>
        <?php endif; ?>

        <!-- Tabla de empleados -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Numero de Colaborador</th>
                    <th>Área</th>
                    <th>Placas del Vehículo</th>
                    <th>Modelo y Marca</th>
                    <th>Color del Vehículo</th>
                    <th>QR</th>
                    <th>Estado</th> <!-- Nueva columna para el estado -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre_apellido']; ?></td>
                    <td><?php echo $row['numero_colaborador']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['placas_vehiculo']; ?></td>
                    <td><?php echo $row['modelo_marca']; ?></td>
                    <td><?php echo $row['color_vehiculo']; ?></td>
                    <td><img src="<?php echo $row['qr_code']; ?>" alt="QR Code" style="width: 50px; height: 50px;"></td>  
                    <td><?php echo $row['estado'] ? 'Habilitado' : 'Deshabilitado'; ?></td> <!-- Mostrar estado -->
                    <td>
                        <a href="actualizacionesempleado.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="actualizacionesempleado.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este empleado?');">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <?php if ($row['estado']): ?>
                        <a href="actualizacionesempleado.php?deshabilitar=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm" onclick="return confirm('¿Estás seguro de deshabilitar este empleado?');">
                        <i class="bi bi-toggle-off"></i>
                        </a>
                        <?php else: ?>
                        <a href="actualizacionesempleado.php?habilitar=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de habilitar este empleado?');">
                        <i class="bi bi-toggle-on"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

        <!-- Contenedor para los botones -->
        <div class="text-center mt-4">
            <!-- Botón para volver -->
            <button class="btn btn-secondary me-2" onclick="history.back()">Volver</button>
            <!-- Botón para actualizar -->
            <button class="btn btn-primary" onclick="location.reload()">Actualizar</button>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

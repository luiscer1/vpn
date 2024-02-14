<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "monitoreo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear Dispositivo
if (isset($_POST['crearDispositivo'])) {
    $nombre = $_POST['nombre'];
    $direccion_ip = $_POST['direccion_ip'];
    $tipo = $_POST['tipo'];
    $ubicacion = $_POST['ubicacion'];

    $stmt = $conn->prepare("INSERT INTO Dispositivos (nombre, direccion_ip, tipo, ubicacion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $direccion_ip, $tipo, $ubicacion);
    $stmt->execute();
    $stmt->close();
}

// Leer Dispositivos
$sqlDispositivos = "SELECT * FROM Dispositivos";
$resultadoDispositivos = $conn->query($sqlDispositivos);

// Crear Registro
if (isset($_POST['crearRegistro'])) {
    $id_dispositivo = $_POST['id_dispositivo'];
    $uso_cpu = $_POST['uso_cpu'];
    $uso_memoria = $_POST['uso_memoria'];
    $velocidad_red = $_POST['velocidad_red'];
    $paquetes_perdidos = $_POST['paquetes_perdidos'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("INSERT INTO Registros_de_Monitoreo (id_dispositivo, uso_cpu, uso_memoria, velocidad_red, paquetes_perdidos, estado) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id_dispositivo, $uso_cpu, $uso_memoria, $velocidad_red, $paquetes_perdidos, $estado);
    $stmt->execute();
    $stmt->close();
}

// Leer Registros
$sqlRegistros = "SELECT * FROM Registros_de_Monitoreo";
$resultadoRegistros = $conn->query($sqlRegistros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Monitoreo de Redes</title>
</head>
<body>

    <h2>Dispositivos en la Red</h2>

    <!-- Formulario para crear dispositivo -->
    <form method="post" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="direccion_ip">Dirección IP:</label>
        <input type="text" name="direccion_ip" required>
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required>
        <label for="ubicacion">Ubicación:</label>
        <input type="text" name="ubicacion" required>
        <button type="submit" name="crearDispositivo">Agregar Dispositivo</button>
    </form>

    <!-- Mostrar Dispositivos -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección IP</th>
            <th>Tipo</th>
            <th>Ubicación</th>
        </tr>
        <?php
        while ($filaDispositivo = $resultadoDispositivos->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$filaDispositivo['id']}</td>";
            echo "<td>{$filaDispositivo['nombre']}</td>";
            echo "<td>{$filaDispositivo['direccion_ip']}</td>";
            echo "<td>{$filaDispositivo['tipo']}</td>";
            echo "<td>{$filaDispositivo['ubicacion']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h2>Registros de Monitoreo</h2>

    <!-- Formulario para crear registro -->
    <form method="post" action="">
        <label for="id_dispositivo">ID del Dispositivo:</label>
        <input type="text" name="id_dispositivo" required>
        <label for="uso_cpu">Uso de CPU:</label>
        <input type="text" name="uso_cpu" required>
        <label for="uso_memoria">Uso de Memoria:</label>
        <input type="text" name="uso_memoria" required>
        <label for="velocidad_red">Velocidad de Red:</label>
        <input type="text" name="velocidad_red" required>
        <label for="paquetes_perdidos">Paquetes Perdidos:</label>
        <input type="text" name="paquetes_perdidos" required>
        <label for="estado">Estado:</label>
        <input type="text" name="estado" required>
        <button type="submit" name="crearRegistro">Agregar Registro</button>
    </form>

    <!-- Mostrar Registros -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID del Dispositivo</th>
            <th>Uso de CPU</th>
            <th>Uso de Memoria</th>
            <th>Velocidad de Red</th>
            <th>Paquetes Perdidos</th>
            <th>Estado</th>
        </tr>
        <?php
        while ($filaRegistro = $resultadoRegistros->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$filaRegistro['id']}</td>";
            echo "<td>{$filaRegistro['id_dispositivo']}</td>";
            echo "<td>{$filaRegistro['uso_cpu']}</td>";
            echo "<td>{$filaRegistro['uso_memoria']}</td>";
            echo "<td>{$filaRegistro['velocidad_red']}</td>";
            echo "<td>{$filaRegistro['paquetes_perdidos']}</td>";
            echo "<td>{$filaRegistro['estado']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>
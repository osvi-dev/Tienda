<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tienda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener registros de la tabla Almacen
$queryAlmacen = "SELECT * FROM Almacen";
$resultAlmacen = $conn->query($queryAlmacen);

// Obtener registros de la tabla Compra
$queryCompra = "SELECT * FROM Compra";
$resultCompra = $conn->query($queryCompra);

// Obtener registros de la tabla Proveedor
$queryProveedor = "SELECT * FROM Proveedor";
$resultProveedor = $conn->query($queryProveedor);

// Obtener registros de la tabla Salida
$querySalida = "SELECT * FROM Salida";
$resultSalida = $conn->query($querySalida);

// Función para agregar una nueva compra

// Función para agregar una nueva compra
function agregarCompra($conn, $proveedor, $producto, $cantidad, $precio)
{
    // Actualizar la tabla Almacen
    $updateAlmacen = "UPDATE Almacen SET Stock = Stock + $cantidad WHERE ID = $producto";
    if ($conn->query($updateAlmacen) !== TRUE) {
        return false; // Si hay un error al actualizar, devolver false
    }

    // Insertar la compra en la tabla Compra
    $insertCompra = "INSERT INTO Compra (IDProvedor, IDProducto, Cant, Precio) VALUES ($proveedor, $producto, $cantidad, $precio)";
    if ($conn->query($insertCompra) !== TRUE) {
        return false; // Si hay un error al insertar, devolver false
    }

    return true; // Todo se realizó con éxito
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si se ha enviado el formulario de compra
    $proveedor = $_POST["proveedor"];
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];

    if (agregarCompra($conn, $proveedor, $producto, $cantidad, $precio)) {
        echo '<script>alert("Compra agregada con éxito");</script>';
    } else {
        echo '<script>alert("Error al agregar la compra");</script>';
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en Línea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #0066cc;
            /* Color de fondo de la barra */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .navbar img {
            width: 50px;
            /* Ajusta el tamaño del logo según necesidades */
            height: auto;
            margin-right: 15px;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        header {
            padding: 20px;
            text-align: center;
            background-color: #333;
            /* Mantener este color o cambiarlo si se desea */
            color: white;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            /* Sombra para efecto elevado */
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            /* Centrado para hacerlo más legible */
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        tbody tr:hover {
            background-color: #ddd;
            /* Efecto hover para las filas */
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1 {
            color: #333;
            margin-top: 50px;
            /* Espaciado adicional antes de las secciones */
        }

        .table-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }

        .table-container {
            width: 45%;
            /* Ajusta esto según el ancho deseado para cada tabla */
            margin: 0 2%;
            /* Espaciado entre las tablas */
            /* Aplica aquí estilos adicionales si es necesario */
        }
        h2{
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <img src="cha.jpg" alt="Logo de la Tienda">
        <h2>Mi tienda</h2>
    </div>

    <header>
        <!-- Otros detalles de cabecera si se requiere -->
    </header>

    <div class="table-wrapper">
        <div class="table-container">
            <h1 style="text-align: center;">Inventario de la Tienda</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Descripción</th>
                        <th>Mínimo</th>
                        <th>Máximo</th>
                        <th>Stock Actual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar registros de la tabla Almacen
                    while ($row = $resultAlmacen->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['Descripcion'] . "</td>";
                        echo "<td>" . $row['Min'] . "</td>";
                        echo "<td>" . $row['Max'] . "</td>";
                        echo "<td>" . $row['Stock'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h1 style="text-align: center;">Registro de Compras</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID Proveedor</th>
                        <th>ID Producto</th>
                        <th>Cantidad Comprada</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar registros de la tabla Compra
                    while ($row = $resultCompra->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['IDProvedor'] . "</td>";
                        echo "<td>" . $row['IDProducto'] . "</td>";
                        echo "<td>" . $row['Cant'] . "</td>";
                        echo "<td>" . $row['Precio'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-wrapper">
        <div class="table-container">
            <h1 style="text-align: center;">Proveedores</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID </th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Telefono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar registros de la tabla Proveedor
                    while ($row = $resultProveedor->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['Nombre'] . "</td>";
                        echo "<td>" . $row['Direccion'] . "</td>";
                        echo "<td>" . $row['Telefono'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h1 style="text-align: center;">Salidas</h1>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>ID Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar registros de la tabla Salida
                    while ($row = $resultSalida->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Fecha'] . "</td>";
                        echo "<td>" . $row['Hora'] . "</td>";
                        echo "<td>" . $row['IDProducto'] . "</td>";
                        echo "<td>" . $row['Cantidad'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agregar un formulario para agregar una nueva compra -->
    <h2>Agregar Compra</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" onsubmit="return validarCompra()">
        <label for="producto">ID Producto:</label>
        <input type="text" id="producto" name="producto" required>
        
        <label for="proveedor">ID Proveedor:</label>
        <input type="text" id="proveedor" name="proveedor" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>

        <button type="submit" onclick="actualizarCompras()">Agregar Compra</button>
        </form>

</script>
<script>
    // Función para recargar la página después de agregar una compra
    function actualizarCompras() {
        setTimeout(function () {
            location.reload(); // Recargar la página después de 1 segundo
        }, 1000);
    }
</script>
</body>
</html>
<?php
require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../../models/productos.php";

$mensaje = "";

if (isset($_POST["guardar"])) {
    $nombre = trim($_POST["nombre"]);
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $categoria = $_POST["categoria_id"];
    $estado = $_POST["estado"];
    $id = $_POST["id_producto"];

    if ($nombre == "" || $precio == "" || $cantidad == "" || $categoria == "") {
        $mensaje = "Debe completar los campos obligatorios.";
    } elseif (!is_numeric($precio) || $precio <= 0) {
        $mensaje = "El precio debe ser un número mayor que cero.";
    } elseif (!is_numeric($cantidad) || $cantidad < 0 || (int)$cantidad != $cantidad) {
        $mensaje = "La cantidad debe ser un número entero igual o mayor que cero.";
    } else {
        if ($id != "") {
            $consulta = $conexion->prepare("UPDATE productos SET nombre=?, precio=?, cantidad=?, categoria_id=?, estado=? WHERE id_producto=?");
            $consulta->execute(array($nombre, $precio, $cantidad, $categoria, $estado, $id));
            $mensaje = "El producto ha sido actualizado correctamente.";
        } else {
            $consulta = $conexion->prepare("INSERT INTO productos (nombre, precio, cantidad, categoria_id, estado) VALUES (?, ?, ?, ?, ?)");
            $consulta->execute(array($nombre, $precio, $cantidad, $categoria, $estado));
            $mensaje = "Producto guardado correctamente.";
        }
    }
}

$categorias = listarCategorias($conexion);
$productos = listarProductos($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de productos</title>
    <link rel="stylesheet" href="../../public/css/estilos.css">
    <script src="../../public/js/productos.js" defer></script>
</head>
<body>
<header id="inicio" class="encabezado">
    <h1>Gestión de productos</h1>
    <p>Daniel Aleksander Regalado — Ficha 3230905</p>
</header>

<nav class="menu">
    <a href="../inicio/index.html">Inicio</a>
    <a href="#registro">Registrar producto</a>
    <a href="#productos">Listado de productos</a>
</nav>

<main class="contenido">
    <section id="registro" class="caja">
        <h2 id="tituloFormulario">Registrar producto</h2>
        <?php if ($mensaje != "") { echo "<p>" . htmlspecialchars($mensaje) . "</p>"; } ?>
        <form method="POST" id="formProducto">
            <input type="hidden" name="id_producto" id="id_producto">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" min="0.01" step="0.01" required>

            <label for="cantidad">Cantidad disponible</label>
            <input type="number" name="cantidad" id="cantidad" min="0" step="1" required>

            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($cat = $categorias->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $cat["id_categoria"]; ?>"><?php echo htmlspecialchars($cat["nombre_categoria"]); ?></option>
                <?php } ?>
            </select>

            <label for="estado">Estado</label>
            <select name="estado" id="estado">
                <option value="Activo">Activo</option>
                <option value="Disponible">Disponible</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Sin Stock">Sin Stock</option>
            </select>

            <button type="submit" name="guardar">Guardar</button>
            <button type="button" id="limpiarFormulario">Limpiar formulario</button>
        </form>
    </section>

    <section id="productos" class="caja">
        <h2>Listado de productos</h2>

        <label for="buscarProducto">Buscar producto</label>
        <input type="text" id="buscarProducto" placeholder="Nombre o categoría">
        <button type="button" id="buscar">Buscar</button>
        <button type="button" id="limpiarBusqueda">Limpiar búsqueda</button>

        <label for="filtroEstado">Filtrar por estado</label>
        <select id="filtroEstado">
            <option value="todos">Todos</option>
            <option value="activos">Activos</option>
            <option value="inactivos">Inactivos</option>
        </select>

        <p id="contador"></p>
        <p id="mensajeVacio" style="display:none;">No se encontraron productos que coincidan con la búsqueda</p>

        <div style="overflow-x:auto;">
        <table id="tablaProductos">
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Categoría</th><th>Estado</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($p = $productos->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr data-id="<?php echo $p["id_producto"]; ?>"
                    data-nombre="<?php echo htmlspecialchars($p["nombre"], ENT_QUOTES); ?>"
                    data-precio="<?php echo $p["precio"]; ?>"
                    data-cantidad="<?php echo $p["cantidad"]; ?>"
                    data-categoria="<?php echo $p["categoria_id"]; ?>"
                    data-estado="<?php echo htmlspecialchars($p["estado"], ENT_QUOTES); ?>">
                    <td><?php echo $p["id_producto"]; ?></td>
                    <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
                    <td><?php echo $p["precio"]; ?></td>
                    <td><?php echo $p["cantidad"]; ?></td>
                    <td><?php echo htmlspecialchars($p["nombre_categoria"]); ?></td>
                    <td><?php echo htmlspecialchars($p["estado"]); ?></td>
                    <td><button type="button" class="editar">Editar</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </section>
</main>
<footer class="pie"><p>SENA · ADSO · Ficha 3230905</p></footer>
</body>
</html>

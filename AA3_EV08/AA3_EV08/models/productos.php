<?php
function listarProductos($conexion) {
    $consulta = "SELECT productos.*, categorias.nombre_categoria
                 FROM productos
                 INNER JOIN categorias
                 ON productos.categoria_id = categorias.id_categoria";
    return $conexion->query($consulta);
}

function listarCategorias($conexion) {
    return $conexion->query("SELECT * FROM categorias");
}
?>

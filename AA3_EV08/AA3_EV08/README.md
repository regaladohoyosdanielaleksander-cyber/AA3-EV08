# AA3-EV08 - Gestión de productos

Proyecto basado en la estructura de práctica AA3-EV04 entregada.

## Tecnologías
PHP, HTML, CSS, JavaScript y MySQL en XAMPP.

## Pasos
1. Copiar la carpeta `AA3_EV08` dentro de `C:\xampp\htdocs\`.
2. Iniciar Apache y MySQL en XAMPP.
3. Abrir phpMyAdmin (`http://localhost/phpmyadmin`), importar `database/sistema_inventario.sql` y ejecutar el script. Este crea la base de datos `sistema_inventario`, sus tablas y datos iniciales.
4. Si las credenciales de MySQL no son las predeterminadas de XAMPP (`root` sin contraseña), definir `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`, o actualizar sus valores predeterminados en `config/conexion.php`.
5. Abrir `http://localhost/AA3_EV08/`. Desde el inicio se puede abrir la gestión de productos y volver a la página principal.

La aplicación usa PDO para leer, registrar y actualizar productos en MySQL. Si la conexión falla, PHP mostrará el error de conexión; verifica que MySQL esté iniciado, que el script SQL se haya importado y que las credenciales coincidan.

## Funciones
- Registro de productos.
- Búsqueda por nombre o categoría.
- Filtro por estado.
- Edición de productos.
- Validación sencilla de precio y cantidad.

La base de datos entregada no tiene campos de descripción ni código de barras, por eso el buscador utiliza nombre y categoría disponibles.

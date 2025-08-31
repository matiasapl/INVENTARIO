use inventario;

/* INVENTARIO */

select producto, categoria, stock, precio_unitario, alerta from productos  where usuario = 1;

/* COMPRAS */
select producto, cantidad, precio, metodo_pago, fecha, responsable from compras where responsable = 1;

/* VENTAS */
select producto, cantidad, precio, metodo_pago, fecha, responsable from ventas where responsable = 1;

/* HISTORIAL */
select motivo, fecha, responsable, producto, categoria, stock, precio, alerta, tipo_edicion from inventario_historial where responsable = 1;


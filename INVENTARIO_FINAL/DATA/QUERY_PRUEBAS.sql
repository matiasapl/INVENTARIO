use inventario;

/* INVENTARIO */
select producto, categoria, stock, precio_unitario, alerta from productos  where usuario = 1;

/* COMPRAS */
select c.producto, c.cantidad, c.precio, c.metodo_pago, c.fecha, u.nombre
from compras c, usuarios u
where c.responsable = u.id and u.id = 1;

/* VENTAS */
select v.producto, v.cantidad, v.precio, v.metodo_pago, v.fecha, u.nombre
from ventas v, usuarios u
where v.responsable = u.id and u.id = 1;

/* HISTORIAL */
select h.motivo, h.fecha, u.nombre, h.producto, h.categoria, h.stock, h.precio, h.alerta, h.tipo_edicion
from inventario_historial h, usuarios u
where h.responsable = u.id and u.id = 1;

/* ADMINISTRACION */
select nombre, email from usuarios where id = 1;


/* DASHBOARD */

/* DASHBOARD: VENTAS */
select v.producto, v.cantidad, v.precio, v.metodo_pago, v.fecha, u.nombre
from ventas v, usuarios u
where v.responsable = u.id and u.id = 1
order by v.fecha desc
limit 10;
/* DASHBOARD: COMPRAS */
select c.producto, c.cantidad, c.precio, c.metodo_pago, c.fecha, u.nombre
from compras c, usuarios u
where c.responsable = u.id and u.id = 1
order by c.fecha desc
limit 10;

/* DASHBOARD: ALERTAS STOCK */
select producto, stock from productos  where stock < alerta and usuario = 1;

/* DASHBOARD: PRODUCTO MAS VENDIDO */
select v.producto, count(*) as repeticiones
from ventas v, usuarios u
where v.responsable = u.id and u.id = 1
group by v.producto
order by repeticiones desc
limit 1;
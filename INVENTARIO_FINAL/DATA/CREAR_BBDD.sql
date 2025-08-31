drop database inventario;

CREATE DATABASE IF NOT EXISTS inventario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventario;

create table if not exists usuarios (
id int auto_increment primary key,
nombre varchar(30),
email varchar(255),
pass varchar(255),
roles varchar(255),
esadmin tinyint,
habilitado tinyint
);

create table if not exists productos (
id int auto_increment primary key,
producto varchar(30),
categoria varchar(30),
stock int,
precio_unitario float,
alerta int,
usuario int,

foreign key (usuario) references usuarios(id)
);

create table if not exists compras (
id int auto_increment primary key,
producto varchar(30),
cantidad int,
precio float,
metodo_pago varchar(255),
fecha datetime,
responsable int,

foreign key (responsable) references usuarios(id)
);

create table if not exists ventas (
id int auto_increment primary key,
producto varchar(30),
cantidad int,
precio float,
metodo_pago varchar(255),
fecha datetime,
responsable int,

foreign key (responsable) references usuarios(id)
);

create table if not exists inventario_historial (
id int auto_increment primary key,
motivo varchar(255),
fecha datetime,
responsable int,
producto varchar(30),
categoria varchar(30),
stock int,
precio float,
alerta int,
tipo_edicion varchar(30),

foreign key (responsable) references usuarios(id)
);
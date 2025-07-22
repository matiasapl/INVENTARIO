<?php
//CONFIGURACION
$_RUTAS = '/PROYECTO_INVENTARIO/RUTAS.php';
$_HTACCESS = '/PROYECTO_INVENTARIO/.htaccess';

//RUTAS
$_MVC = '/PROYECTO_INVENTARIO/src/MVC';
$_Principales = '/VISTA/Principales';
$_Layouts = '/VISTA/Layouts';
$_Controlador = '/CONTROLADOR';
$_DDBB = '/MODELO/DDBB/';
$_vistas_ddbb = 'MODELO/Vistas/';

//LAYOUTS
$Layout_Inventario = '/Inventario.php';
$Layout_Alertas = 'Alertas.php';
$Layout_URI = '/Uri.php'; 
$Layout_Registro = '/Registros.php';
$Layout_Reportes = '/Reportes.php';
$Layout_administracion = '/Administracion.php';
$Layout_login = '/Login.php';
$Layout_Comun = '/Comun.php';
$Layout_Css = '/Styless.css';

//PRINCIPALES
$_Index = '/Index.php';
$_Publico = '/Publico.PHP';

//CONTROLADORES
$Controller = 'Controller.php';

//BASES DE DATOS
$Inventario = 'Inventario.db';
$DDBB = 'DDBB.db';

//VARIABLES DE ARCHIVOS
$Index = "'" . $_MVC . $_Principales . $_Index . "'";
$INVENTARIO = "'" . $_MVC . $_Layouts . $Layout_Inventario . "'";
$ADMINISTRACION = "'" . $_MVC . $_Layouts . $Layout_administracion . "'";
$LOGIN = "'" . $_MVC . $_Layouts . $Layout_login . "'";
$COMUN = "'" . $_MVC . $_Layouts . $Layout_Comun . "'";
$CSS = "'" . $_MVC . $_Layouts . $Layout_Css . "'";

?>

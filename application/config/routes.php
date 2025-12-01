<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Sesion';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rutas legibles
$route['Administracion_de_sistema/Logs_del_sistema'] = 'Configuracion/m1_s1';
$route['Administracion_de_transportes/Horarios'] = 'Transporte/m4_s3';
$route['Administracion_de_sistema/Inicio'] = 'Panel';
$route['Administracion_de_transportes/Rutas'] = 'Transporte/m4_s1';
$route['Administracion_de_transportes/Paradas'] = 'Transporte/m4_s2';
$route['Administracion_de_sistema/Historial_de_eventos'] = 'Configuracion/historial_eventos';
$route['Planear_ruta'] = 'MiRuta';
// Alias nuevo: Vista_visitante → MiRuta
$route['Vista_visitante'] = 'MiRuta';

// Aliases solicitados
// Eliminados alias duplicados de Inicio

// Transporte/nuevo_viaje (ruta unificada)
$route['Administracion_de_transportes/nuevo_viaje'] = 'Transporte/nuevo_viaje';

// Eliminados alias duplicados de MiRuta
?>

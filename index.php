<?php
/**
 * BASES - переменная для среды No direct script access allowed 
 *@var string
 */

define('BASES', 'sknt');

error_reporting(-1);

include('db_cfg.php');

//Классы
include('c/class_mysql.php');
include('c/class_log.php');
include('c/class_get_tarifs.php');
include('c/class_put_tarif.php');
include('c/class_error.php');
include('c/class_router.php');
include('c/class_controller.php');


/**
 * $router - РОУТЕР 
 */

$router = new router();	
new HTMLcontroller(new $router->method($router->data));


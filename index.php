<?php
define('BASES', 'sknt');

//настройки базы
include('db_cfg.php');
//Класс для вызова запросов к базе 
include('c/class_mysql.php');
//логирование ошибок Exception
include('c/class_log.php');

include('c/class_get_tarifs.php');
include('c/class_put_tarif.php');
include('c/class_error.php');

//роутер
include('c/class_router.php');
//Контр
include('c/class_controller.php');



$rout = new router();	
$j = new $rout->method($rout->data);
new HTML_controller($j);


<?php

use core\Core;

require_once 'vendor/autoload.php';


// load our environment files - used to store credentials & configuration
$dotenv = Dotenv\Dotenv::createImmutable(getcwd());
$dotenv->load();

require_once 'lib/autoload/autoload.php';
require_once 'lib/database/Connection.php';
require_once 'app/core/Core.php';
require_once 'app/core/Router.php';



$template = file_get_contents(getcwd() . '/app/template/template.html');


$core = new Core;
$response = $core->start();


echo str_replace('{{dynamic_area}}', $response, $template);




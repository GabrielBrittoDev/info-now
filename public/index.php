<?php

require_once 'app/core/Core.php';

require_once 'app/controller/ErrorController.php';

require_once 'vendor/autoload.php';


$rootDir = str_replace('public', '', __DIR__);

$dotenv = Dotenv\Dotenv::createImmutable($rootDir);
$dotenv->load();

$template = file_get_contents($rootDir . 'app/template/template.html');

ob_start();
$core = new Core;
$core->start($_GET);

$response = ob_get_contents();
ob_end_clean();

$finishedTemplate = str_replace('{{dynamic_area}}', $response, $template);


echo $finishedTemplate;

<?php

function loadControllers($className){
    if (strpos($className, 'Controller')) {
        $path = getcwd() . '/app/controller/';
        require_once $path . $className . '.php';
    }
}

function loadModels($className){
    $path = getcwd().'/app/model/';
    require_once $path . $className .'.php';
}

spl_autoload_register('loadControllers');
spl_autoload_register('loadModels');

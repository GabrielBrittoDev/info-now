<?php

class Core
{

    public function start($urlGet)
    {
        if ($urlGet){
            $controller = ucfirst($urlGet['page'].'Controller');
        } else {
            $controller = 'HomeController';
        }


        if (isset($urlGet['method'])) {
            $action = $urlGet['method'];
        } else {
            $action = 'index';
        }



        if (!class_exists($controller)) {
            $controller = 'ErrorController';
        }


        if (isset($urlGet['id']) && $urlGet['id'] != null) {
            $id = $urlGet['id'];
        } else {
            $id = null;
        }

        dd($urlGet);

        call_user_func_array(array(new $controller, $action), array('id' => $id));

    }
}
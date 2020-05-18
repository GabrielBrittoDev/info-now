<?php

namespace core;

class Core
{


    /**
     * @return string
     */
    public function start()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        ob_start();

        $route = new Router($uri, $requestMethod);
        include 'routes/Routes.php';
        $content = ob_get_contents();

        ob_end_clean();

        return $content ? $content : file_get_contents(getcwd() . '/app/view/not_found.html');
    }

}
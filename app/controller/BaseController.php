<?php


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait BaseController
{

    protected function renderView(string $view, $args = array(), $headerLocation = '', $viewsPath = 'app/view'){
        $loader = new FilesystemLoader($viewsPath);
        $twig = new Environment($loader);
        $template = $twig->load($view);
        if ($headerLocation !== ''){
            header("Location: ${$_SERVER['HTTP_HOST']}/". $headerLocation);
        }

        return $template->render($args);
    }

    protected function guest(){
        if (isset($_SESSION['user'])){
            echo $this->renderView('home.html', array(), 'home');
            return false;
        } else {
            return true;
        }
    }

}
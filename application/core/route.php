<?php

class Route
{
    static function start()
    {
        $default_catalog = "mvc";
        $controller_name = 'Main';
        $action_name = 'index';

        $uri_without_par = "";
        $str_pos = strripos($_SERVER['REQUEST_URI'], "?");
        if($str_pos){
            $uri_without_par = substr($_SERVER['REQUEST_URI'], 0, $str_pos);
        }
        else {
            $uri_without_par = $_SERVER["REQUEST_URI"];
        }

        if($uri_without_par[strlen($uri_without_par) - 1] != "/"){
            $uri_without_par .= "/";
        }

        $routes = explode('/', $uri_without_par);
        $routes_size = count($routes);

        $check_root = false;
        if(strtolower($routes[$routes_size - 2]) == $default_catalog){
            if(empty($routes[$routes_size - 1]))
                $check_root = true;
        }

        if(!$check_root) {
            if (!empty($routes[$routes_size - 3])) {
                $controller_name = $routes[$routes_size - 3];
            }

            // получаем имя экшена
            if (!empty($routes[$routes_size - 2])) {
                $action_name = $routes[$routes_size - 2];
            }
        }

        $model_name = 'Model_Main';
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;

        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;

        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
            throw new Exception('you not have ' . $action);
            //Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}
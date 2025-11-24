<?php

class Router {

    public static function route() {

        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
        $action = isset($_GET['action']) ? $_GET['action'] : 'publicHome';


        $controllerName = ucfirst($controller) . 'Controller';

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado: $controllerName");
        }

        require_once $controllerFile;

        $controllerObject = new $controllerName();

        if (!method_exists($controllerObject, $action)) {
            die("Acción no encontrada: $action");
        }

        $controllerObject->$action();
    }
}

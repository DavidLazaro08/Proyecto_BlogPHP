<?php

class Router
{
    public static function route()
    {
        // ================================
        //  CONTROLADOR Y ACCIÓN POR DEFECTO
        // ================================
        $controller = $_GET['controller'] ?? 'home';
        $action     = $_GET['action']     ?? 'publicHome';

        // ================================
        //  Construir nombre del controlador
        // ================================
        $controllerName = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        // ================================
        //  Verificar archivo del controlador
        // ================================
        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado: $controllerName");
        }

        require_once $controllerFile;

        // Crear instancia del controlador
        $controllerObject = new $controllerName();

        // ================================
        //  Verificar acción (método)
        // ================================
        if (!method_exists($controllerObject, $action)) {
            die("Acción no encontrada: $action");
        }

        // ================================
        //  Ejecutar acción
        // ================================
        $controllerObject->$action();
    }
}

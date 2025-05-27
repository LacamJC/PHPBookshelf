<?php

namespace Api\Core;

class Router
{
    private $routes = [];

    // Adicionando uma rota GET
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    // Adicionando uma rota POST
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function delete($path, $handler){
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch()
    {
        $url = $_GET['url'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = "@^$pattern$@";

            if (preg_match($pattern, $url, $matches)) {

                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controllerClass, $action] = explode('@', $handler);

                $fullControllerClass = "Api\\Controllers\\$controllerClass";

                if (class_exists($fullControllerClass)) {
                    $controller = new $fullControllerClass();
                    if (method_exists($controller, $action)) {
                        $controller->$action($params ?? []);
                        return;
                    }
                }
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "Página não encontrada";
    }
}

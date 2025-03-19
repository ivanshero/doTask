<?php
/**
 * Simple Router System
 * Current Date and Time (UTC): 2025-03-19 00:00:09
 * Current User: ivanshero
 */

class Router {
    private $routes = [];
    private $notFoundCallback;
    private $baseDir;

    public function __construct($baseDir = '') {
        $this->baseDir = $baseDir;
    }

    /**
     * Register a GET route
     */
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
        return $this;
    }

    /**
     * Register a POST route
     */
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
        return $this;
    }

    /**
     * Register a PUT route
     */
    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
        return $this;
    }

    /**
     * Register a DELETE route
     */
    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
        return $this;
    }

    /**
     * Register a 404 not found callback
     */
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
        return $this;
    }

    /**
     * Run the router
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string and base directory from URI
        if ($this->baseDir && strpos($uri, $this->baseDir) === 0) {
            $uri = substr($uri, strlen($this->baseDir));
        }
        
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Match static routes
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            return;
        }
        
        // Match dynamic routes
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            if (strpos($route, ':') !== false) {
                $routeRegex = preg_replace('/\/:([^\/]+)/', '/([^/]+)', $route);
                $routeRegex = '#^' . $routeRegex . '$#';
                
                if (preg_match($routeRegex, $uri, $matches)) {
                    array_shift($matches); // Remove the first match (full string)
                    call_user_func_array($callback, $matches);
                    return;
                }
            }
        }
        
        // No route matched, call not found callback
        if ($this->notFoundCallback) {
            call_user_func($this->notFoundCallback);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo '404 Page Not Found';
        }
    }
}
<?php

namespace Vendor;

class RouteManager {
    private $router;
    private $routeConfig;

    public function __construct($router) {
        $this->router = $router;
        $this->routeConfig = $this->loadRouteConfig();
    }

    protected function loadRouteConfig() {
        $configFile = __DIR__ . '/../routes/api.php';
        if (file_exists($configFile)) {
            return require $configFile;
        }
    }

    public function registerRoutes() {
        foreach ($this->routeConfig as $controller => $methods) {
            $this->registerGroup($controller, $methods);
        }
    }

    private function registerGroup($class, $methods) {
        $class = 'Controllers\\' . $class;  
        foreach ($methods as $method) {
            $this->router->register($method, $class, $method);
        }
    }
}

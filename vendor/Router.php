<?php

namespace Vendor;

class Router {
    private $routeTable;
    public function __construct() {
        $this->routeTable = [];
    }

    public function register($action, $class, $method) {
        $arr['class'] = $class;
        $arr['method'] = $method;
        $this->routeTable[$action] = $arr;
    }

    public function run($action) {
        if (isset($this->routeTable[$action])) {
            $class = $this->routeTable[$action]['class'];
            $method = $this->routeTable[$action]['method'];
            // require_once  __DIR__ . "/../app/Controllers/" . $class . ".php";
            $controller = new $class();
            $response = $controller->$method();
            return $response;
        } else {
            return ['status' => 404, 'message' => 'Action not found: ' . $action];
        }

    }
}
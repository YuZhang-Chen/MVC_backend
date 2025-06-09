<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

use Vendor\DB;
use Vendor\Router;
use Middlewares\AuthMiddleware;

class Main {
    static function run() {
        // 設定config
        $conf = parse_ini_file(__DIR__ . '/../vendor/.env');
        DB::$dbHost = $conf['DB_HOST'];
        DB::$dbName = $conf['DB_NAME'];
        DB::$dbUser = $conf['DB_USER'];
        DB::$dbPassword = $conf['DB_PASSWORD'];

        // 讀取action
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = "_no_action";
        }

        // 檢查token
        $response = $responseToken = AuthMiddleware::checkToken();
        if ($responseToken['status'] == 200) {
            if ($action !== "_no_action") {
                $router = new Router();
                require_once __DIR__ . "/../routes/web.php";
                $response = $router->run($action);  
            }
            $response['token'] = $responseToken['token'];
        } else {
            switch ($action) {
                case "doLogin":
                    $response = AuthMiddleware::doLogin();
                    break;
                default:
                    break;
            }
        }
        
        echo json_encode($response);
    }
}

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

        // 定義公開可存取的 actions（無須認證）
        $publicActions = ['doLogin', 'getProducts'];
        
        // 檢查是否為公開 action
        if (in_array($action, $publicActions)) {
            if ($action === "doLogin") {
                $response = AuthMiddleware::doLogin();
            } else {
                // 直接執行公開 action，不需要認證
                $router = new Router();
                require_once __DIR__ . "/../routes/web.php";
                $response = $router->run($action);
            }
        } else {
            // 需要認證的 actions
            $response = $responseToken = AuthMiddleware::checkToken();
            if ($responseToken['status'] == 200) {
                if ($action !== "_no_action") {
                    $response = AuthMiddleware::checkPrevilege($action);
                    if ($response['status'] == 200) {
                        $router = new Router();
                        require_once __DIR__ . "/../routes/web.php";
                        $response = $router->run($action);  
                    }
                }
                $response['token'] = $responseToken['token'];
            } else {
                // Token 無效時的回應
                $response = array(
                    "status" => 401,
                    "message" => "Authentication required"
                );
            }
        }
        
        echo json_encode($response);
    }
}

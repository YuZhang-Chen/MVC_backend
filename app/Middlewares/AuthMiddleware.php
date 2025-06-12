<?php

namespace Middlewares;
use \Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Vendor\Controller;
use Models\Member as memberModel;
use Models\Action;

class AuthMiddleware extends Controller {
    private static $id;

    public static function checkPrevilege($action) {
        $id = self::$id;
        $memberModel = new memberModel();
        $userResponse = $memberModel->getRoles($id);
        $user_roles = $userResponse["result"];
        $am = new Action();
        $actionResponse = $am->getRoles($action);
        $action_roles = $actionResponse["result"];
        $r = count(array_intersect($user_roles, $action_roles));
        if ($r != 0) {
            return self::response(200, "有權限");
        } else {
            return self::response(403, "權限不足");
        }
    }

    public static function checkToken() {
        // 使用 getallheaders() 獲取 Authorization header
        $headers = getallheaders();
        
        if (!isset($headers['Authorization'])) {
            return array(
                "status" => 401,
                "message" => "Authorization header not found"
            );
        }
        
        $jwt = $headers['Authorization'];
        
        // Remove "Bearer " prefix (7 characters) from the token if it exists
        if (strpos($jwt, 'Bearer ') === 0) {
            $jwt = substr($jwt, 7);
        }
        
        $conf = parse_ini_file(__DIR__ . '/../../vendor/.env');
        $secret_key = $conf['secret_key'];
        try {
            $payload = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            self::$id = $payload->data->id;
            $jwt = self::genToken($payload->data->id);
            $response = array(
                "status" => 200,
                "message" => "Access granted",
                "token" => $jwt
            );
        } catch (Exception $e) {
            $response = array(
                "status" => 401,
                "message" => $e->getMessage()
            );
        }
        return $response;
    }

    public static function doLogin() {
        // 獲取 JSON 輸入資料
        $input = json_decode(file_get_contents('php://input'), true);
        
        // 如果是 JSON 資料，從 $input 取得；否則從 $_POST 取得
        $mId = isset($input['mId']) ? $input['mId'] : (isset($_POST['mId']) ? $_POST['mId'] : null);
        $password = isset($input['password']) ? $input['password'] : (isset($_POST['password']) ? $_POST['password'] : null);
        
        if (!$mId || !$password) {
            return array(
                "status" => 400,
                "message" => "Missing mId or password"
            );
        }
        
        $memberModel = new memberModel();
        $response = $memberModel->verifyCredentials($mId, $password);

        if ($response['status'] == 200) {
            $jwt = self::genToken($mId);
            $res = array(
                "status" => 200,
                "message" => "Login successful",
                "token" => $jwt
            );
            return $res;
        } else {
            return array(
                "status" => 401,
                "message" => "Login failed"
            );
        }
    }

    public static function genToken($id) {
        $conf = parse_ini_file(__DIR__ . '/../../vendor/.env');
        
        $secret_key = $conf['secret_key'];
        $issuer_claim = "http://localhost";
        $audience_claim = "http://localhost";
        $issuedat_claim = time();
        $expiration_claim = $issuedat_claim + 600;
        $payload = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expiration_claim,
            "data" => array(
                "id" => $id,
            )
        );
        $jwt = JWT::encode($payload, $secret_key, 'HS256');
        return $jwt;
    }
}
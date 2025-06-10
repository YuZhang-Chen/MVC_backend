<?php

namespace Middlewares;
use \Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Vendor\Controller;
use Models\Member as memberModel;

class AuthMiddleware extends Controller {

    public static function checkToken() {
        $header = getallheaders();
        $jwt = $header['Authorization'];
        // Remove "Bearer " prefix (7 characters) from the token if it exists
        if (isset($jwt) && strpos($jwt, 'Bearer ') === 0) {
            $jwt = substr($jwt, 7);
        }
        $conf = parse_ini_file(__DIR__ . '/../../vendor/.env');
        $secret_key = $conf['secret_key'];
        try {
            $payload = JWT::decode($jwt, new Key($secret_key, 'HS256'));
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
        $mId = $_POST['mId'];
        $password = $_POST['password'];
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
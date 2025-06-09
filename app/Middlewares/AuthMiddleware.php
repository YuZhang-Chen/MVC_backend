<?php

namespace Middlewares;
use \Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Vendor\Controller;
use Models\Member;

class AuthMiddleware extends Controller {
    public static function checkToken() {
        $header = getallheaders();
        $jwt = $header['Auth'];
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
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            );
        }
        return $response;
    }

    public static function doLogin() {
        $mId = $_POST['mId'];
        $password = $_POST['password'];
        $memberModel = new Member();
        $response = $memberModel->verifyCredentials($mId, $password);
        if ($response['status'] == 200) {
            $jwt = self::genToken($mId);
            $response = array(
                "status" => 200,
                "message" => "Login successful",
                "token" => $jwt
            );
        }
        return $response;
    }

    public static function genToken($id) {
        $conf = parse_ini_file(__DIR__ . '/../../vendor/.env');
        $secret_key = $conf['secret_key'];
        $issuer_claim = "http://localhost";
        $audience_claim = "http://localhost";
        $issuedat_claim = time();
        $expiration_claim = $issuedat_claim + 5;
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
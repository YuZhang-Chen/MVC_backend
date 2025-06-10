<?php

namespace Vendor;
use Vendor\Controller;
use \PDO;
use \PDOException;

class DB extends Controller {
    public static $dbHost;
    public static $dbName;
    public static $dbUser;
    public static $dbPassword;
    private static $conn = null;

    static function connect() {
        if (self::$conn != null) {
            return;
        }

        $dsn = "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8";
        try {
            self::$conn = new PDO($dsn, self::$dbUser, self::$dbPassword);
        } catch (PDOException $e) {
            self::$conn = $e;
        }
    }

    static function read($sql, $args) {
        self::connect();
        if (self::$conn == null) {
            return self::response(500, "Database connection failed");
        }
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute($args);
        if ($result) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) === 0) {
                return self::response(404, "查無資料");
            }
            return self::response(200, "查詢成功", $rows);
        }
        return self::response(400, "SQL錯誤");
    }

    static function create($sql, $args) {
        self::connect();
        if (self::$conn == null) {
            return self::response(500, "Database connection failed");
        }
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute($args);
        if ($result) {
            $rowCount = $stmt->rowCount();
            return $rowCount > 0 ? self::response(200, "新增成功") : self::response(204, "新增失敗");
        }
        return self::response(400, "SQL錯誤");
    }

    static function update($sql, $args) {
        self::connect();
        if (self::$conn == null) {
            return self::response(500, "Database connection failed");
        }
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute($args);
        if ($result) {
            $rowCount = $stmt->rowCount();
            return $rowCount > 0 ? self::response(200, "更新成功") : self::response(204, "更新失敗");
        }
        return self::response(400, "SQL錯誤");
    }

    static function delete($sql, $args) {
        self::connect();
        if (self::$conn == null) {
            return self::response(500, "Database connection failed");
        }
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute($args);
        if ($result) {
            $rowCount = $stmt->rowCount();
            return $rowCount > 0 ? self::response(200, "刪除成功") : self::response(204, "刪除失敗");
        }
        return self::response(400, "SQL錯誤");
    }
}
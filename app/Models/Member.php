<?php

namespace Models;
use Vendor\DB;

class Member {
    public function getMembers() {
        $sql = "SELECT * FROM `member`";
        $args = null;
        return DB::read($sql, $args);
    }
    
    public function getMember($mId) {
        $sql = "SELECT * FROM `member` WHERE `mId` = ?";
        $args = [$mId];
        return DB::read($sql, $args);
    }

    public function newMember($mId, $name, $phone, $email, $password) {
        $sql = "INSERT INTO `member` (`mId`, `name`, `phone`, `email`, `password`) VALUES (?, ?, ?, ?, ?)";
        $args = [$mId, $name, $phone, $email, $password];
        return DB::create($sql, $args);
    }

    public function removeMember($mId) {
        $sql = "DELETE FROM `member` WHERE `mId` = ?";
        $args = [$mId];
        return DB::delete($sql, $args);
    }

    public function updateMember($name, $phone, $email, $password, $mId) {
        $sql = "UPDATE `member` SET `name` = ?, `phone` = ?, `email` = ?, `password` = ? WHERE `mId` = ?";
        $args = [$name, $phone, $email, $password, $mId];
        return DB::update($sql, $args);
    }

    public static function countMembers() {
        $sql = "SELECT COUNT(*) AS `count` FROM `member`";
        $args = null;
        return DB::read($sql, $args);
    }

    public static function verifyCredentials($mId, $password) {
        $sql = "SELECT * FROM `member` WHERE `mId` = ? AND `password` = ?";
        $args = [$mId, $password];
        return DB::read($sql, $args);
    }

    public function getRoles($id) {
        $sql = "SELECT `role_id` FROM `user_role` WHERE user_id=?";
        $arg = [$id];
        $response = DB::read($sql, $arg);
        $result = $response["result"];
        $cnt = count($result);
        for ($i=0; $i < $cnt; $i++) { 
            $result[$i] = $result[$i]["role_id"];
        }
        $response["result"] = $result;
        return $response;
    }
}

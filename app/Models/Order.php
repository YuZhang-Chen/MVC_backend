<?php

namespace Models;
use Vendor\DB;

class Order {
    public function getOrders() {
        $sql = "SELECT * FROM `order`";
        $args = null;
        return DB::read($sql, $args);
    }
    
    public function getOrder($oId) {
        $sql = "SELECT * FROM `order` WHERE `oId` = ?";
        $args = [$oId];
        return DB::read($sql, $args);
    }

    public function newOrder($mId, $datetime, $status) {
        $sql = "INSERT INTO `order` (`mId`, `datetime`, `status`) VALUES (?, ?, ?)";
        $args = [$mId, $datetime, $status];
        return DB::create($sql, $args);
    }

    public function removeOrder($oId) {
        $sql = "DELETE FROM `order` WHERE `oId` = ?";
        $args = [$oId];
        return DB::delete($sql, $args);
    }

    public function updateOrder($mId, $datetime, $status, $oId) {
        $sql = "UPDATE `order` SET `mId` = ?, `datetime` = ?, `status` = ? WHERE `oId` = ?";
        $args = [$mId, $datetime, $status, $oId];
        return DB::update($sql, $args);
    }    
    
    public static function countOrders() {
        $sql = "SELECT COUNT(*) AS `count` FROM `order`";
        $args = null;
        return DB::read($sql, $args);
    }
}

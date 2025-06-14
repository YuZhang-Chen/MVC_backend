<?php

namespace Models;
use Vendor\DB;

class OrderDetail {
    public function getOrderDetail($oId) {
        $sql = "
        SELECT 
            od.oId,
            od.pId,
            p.pName,
            p.category,
            od.price,
            p.size,
            od.quantity
        FROM 
            order_detail od
        JOIN 
            product p ON od.pId = p.pId
        WHERE 
            od.oId = ?;
        ";
        $args = [$oId];
        return DB::read($sql, $args);
    }

    public function newOrderDetail($oId, $pId, $quantity, $price) {
        $sql = "INSERT INTO `order_detail` (`oId`, `pId`, `quantity`, `price`) VALUES (?, ?, ?, ?);";
        $args = [$oId, $pId, $quantity, $price];
        return DB::create($sql, $args);
    }
}
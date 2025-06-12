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
            p.price,
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
}
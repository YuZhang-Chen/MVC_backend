<?php

namespace Models;
use Vendor\DB;

class Product {
    public function getProducts() {
        $sql = "SELECT * FROM `product`";
        $args = null;
        return DB::read($sql, $args);
    }
    
    public function getProduct($pId) {
        $sql = "SELECT * FROM `product` WHERE `pId` = ?";
        $args = [$pId];
        return DB::read($sql, $args);
    }    
    
    public function newProduct($pName, $category, $price, $size, $image_url = '') {
        $sql = "INSERT INTO `product` (`pName`, `category`, `price`, `size`, `image_url`) VALUES (?, ?, ?, ?, ?)";
        $args = [$pName, $category, $price, $size, $image_url];
        return DB::create($sql, $args);
    }

    public function removeProduct($pId) {
        $sql = "DELETE FROM `product` WHERE `pId` = ?";
        $args = [$pId];
        return DB::delete($sql, $args);
    }    
    
    public function updateProduct($pName, $category, $price, $size, $pId, $image_url = '') {
        $sql = "UPDATE `product` SET `pName` = ?, `category` = ?, `price` = ?, `size` = ?, `image_url` = ? WHERE `pId` = ?";
        $args = [$pName, $category, $price, $size, $image_url, $pId];
        return DB::update($sql, $args);
    }

    public static function countProducts() {
        $sql = "SELECT COUNT(*) AS `count` FROM `product`";
        $args = null;
        return DB::read($sql, $args);
    }
}

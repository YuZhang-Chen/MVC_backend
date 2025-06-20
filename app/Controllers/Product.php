<?php

namespace Controllers;
use Vendor\Controller;
use Models\Product as productModel;

class Product extends Controller{

    private $productModel;
    public function __construct()
    {
        $this->productModel = new productModel();
    }

    public function getProducts() {
        if (isset($_POST['pId'])) {
            $pId = $_POST['pId'];
            return $this->productModel->getProduct($pId);

        } else {
            return $this->productModel->getProducts();
        }
    }    
    
    public function newProduct() {
        if (isset($_POST['pName'], $_POST['category'], $_POST['price'], $_POST['size'])) {
            $pName = $_POST['pName'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $size = $_POST['size'];
            $image_url = $_POST['image_url'] ?? '';
            return $this->productModel->newProduct($pName, $category, $price, $size, $image_url);
        }
    }

    public function removeProduct() {
        $pId = $_POST['pId'];
        return $this->productModel->removeProduct($pId);
    }    public function updateProduct() {
        if (isset($_POST['pId'], $_POST['pName'], $_POST['category'], $_POST['price'], $_POST['size'])) {
            $pId = $_POST['pId'];
            $pName = $_POST['pName'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $size = $_POST['size'];
            $image_url = $_POST['image_url'] ?? '';
            return $this->productModel->updateProduct($pName, $category, $price, $size, $pId, $image_url);
        }
        return self::response(400, '所有欄位為必要輸入');
    }

    public function countProducts() {
        $result = $this->productModel->countProducts();
        if ($result['status'] == 200) {
            return self::response(200, '獲取會員數量成功', $result['result'][0]['count']);
        } else {
            return self::response($result['status'], $result['message']);
        }
    }
}

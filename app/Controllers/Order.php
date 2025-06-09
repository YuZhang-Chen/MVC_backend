<?php

namespace Controllers;
use Vendor\Controller;
use Models\Order as orderModel;

class Order extends Controller{

    private $orderModel;
    public function __construct()
    {
        $this->orderModel = new orderModel();
    }

    public function getOrders() {
        if (isset($_POST['oId'])) {
            $oId = $_POST['oId'];
            return $this->orderModel->getOrder($oId);

        } else {
            return $this->orderModel->getOrders();
        }
    }

    public function newOrder() {
        if (isset($_POST['mId'], $_POST['datetime'], $_POST['status'])) {
            $mId = $_POST['mId'];
            $datetime = $_POST['datetime'];
            $status = $_POST['status'];
            return $this->orderModel->newOrder($mId, $datetime, $status);
        }
        return self::response(400, '所有欄位為必要輸入');
    }

    public function removeOrder() {
        $oId = $_POST['oId'];
        return $this->orderModel->removeOrder($oId);
    }
    
    public function updateOrder() {
        if (isset($_POST['oId'], $_POST['mId'], $_POST['datetime'], $_POST['status'])) {
            $oId = $_POST['oId'];
            $mId = $_POST['mId'];
            $datetime = $_POST['datetime'];
            $status = $_POST['status'];
            return $this->orderModel->updateOrder($mId, $datetime, $status, $oId);
        }
        return self::response(400, '所有欄位為必要輸入');
    }

    public function countOrders() {
        $result = $this->orderModel->countOrders();
        if ($result['status'] == 200) {
            return self::response(200, '獲取會員數量成功', $result['result'][0]['count']);
        } else {
            return self::response($result['status'], $result['message']);
        }
    }
}

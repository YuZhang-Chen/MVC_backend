<?php

namespace Controllers;
use Vendor\Controller;
use Models\OrderDetail as OrderDetailModel;

class OrderDetail extends Controller {

    private $orderDetailModel;
    public function __construct() 
    {
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function getOrderDetail() {
        $oId = $_POST['oId'];
        return $this->orderDetailModel->getOrderDetail($oId);
    }

    public function newOrderDetail() {
        $oId = $_POST['oId'];
        $pId = $_POST['pId'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        return $this->orderDetailModel->newOrderDetail($oId, $pId, $quantity, $price);
    }
}
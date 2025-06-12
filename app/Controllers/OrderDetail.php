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
        if (isset($_POST['oId'])) {
            $oId = $_POST['oId'];
            return $this->orderDetailModel->getOrderDetail($oId);
        }
    }
}
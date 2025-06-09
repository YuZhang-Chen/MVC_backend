<?php
namespace Controllers;
use Vendor\Controller;
use Models\Member;
use Models\Product;
use Models\Order;

class Dashboard extends Controller {
    public function getDashboard() {
        try {
            echo json_encode([
                'status' => 200,
                'message' => '取得儀表板統計成功',
                'result' => [
                    'memberCount' => Member::countMembers()['result'][0]['count'],
                    'productCount' => Product::countProducts()['result'][0]['count'],
                    'orderCount' => Order::countOrders()['result'][0]['count']
                ]
            ]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
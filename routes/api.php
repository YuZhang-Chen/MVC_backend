<?php

return [
    //              2              3              4              5             
    'Member' => ['getMembers', 'newMember', 'removeMember', 'updateMember'],
    //              6                 7              8                 9           
    'Product' => ['getProducts', 'newProduct', 'removeProduct', 'updateProduct'],
    //              10           11            12            13             15
    'Order' => ['getOrders', 'newOrder', 'removeOrder', 'updateOrder', 'getOrderId'],
    //                      14                16
    'OrderDetail' => ['getOrderDetail', 'newOrderDetail'],
    //                    1
    'Dashboard' => ['getDashboard'],
];


// 訪客（公開action） -> 3, 6
// 管理者可以 -> 所有功能
// 顧客可以 -> 2, 10, 11, 14, 15, 16
<?php

return [
    //              2              3              4              5             
    'Member' => ['getMembers', 'newMember', 'removeMember', 'updateMember'],
    //              6                 7              8                 9           
    'Product' => ['getProducts', 'newProduct', 'removeProduct', 'updateProduct'],
    //              10           11            12            13             
    'Order' => ['getOrders', 'newOrder', 'removeOrder', 'updateOrder'],
    //                      14
    'OrderDetail' => ['getOrderDetail'],
    //                    1
    'Dashboard' => ['getDashboard'],
];


// 管理者可以 -> 所有功能
// 顧客可以 -> 2, 3, 6, 10, 11, 14
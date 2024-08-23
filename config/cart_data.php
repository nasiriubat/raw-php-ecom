<?php
// get_cart_data.php
include './helper_function.php';

header('Content-Type: application/json');


$totalAmount = showCart()['total_price'] +deliverCharge();

echo json_encode([
    'total_amount' => $totalAmount * 100,
]);

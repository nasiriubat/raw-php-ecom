<?php
ob_start();

include './helper_function.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_quantity') {
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);

        $cart = updateCartItemQuantity($productId, $quantity);
        ob_end_clean();
        echo json_encode($cart);
    } else {
        // Handle other actions if needed
    }

    exit;
}
?>

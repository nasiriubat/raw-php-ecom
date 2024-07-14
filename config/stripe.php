<?php
// create_payment_intent.php
// require 'vendor/autoload.php'; // Ensure you have installed the Stripe PHP library
require_once '../vendor/stripe-php/init.php';

\Stripe\Stripe::setApiKey('sk_test_51PcJZa2KWfFUQWKWzernIWD6Je6ocPTgQICtarAucZW34cE7QfZ9XmFjLz4hrdrDGn7tXsUDM7AUv8wPMZMpngYE00b76FgCfS');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $amount = $data['amount'];
    $currency = 'usd'; // Adjust as needed
    $email = $data['email'];

    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'receipt_email' => $email,
            'metadata' => [
                'integration_check' => 'accept_a_payment',
            ],
        ]);

        echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit;
}

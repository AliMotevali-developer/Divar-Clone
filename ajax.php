<?php
require_once "database.php";

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(403);
    exit("دسترسی غیرمجاز");
}

$from_user_id = $_SESSION['user_id'];
$to_user_id = filter_var($_POST["to_user"] ?? '', FILTER_SANITIZE_NUMBER_INT);
$pm = trim($_POST["chat_text"] ?? '');

if (empty($pm) || empty($to_user_id) || strlen($pm) > 500 || $from_user_id == $to_user_id) {
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO chat2 (text1, from_user_id, to_user_id, view1) VALUES (?, ?, ?, '0')");
    if ($stmt->execute([$pm, $from_user_id, $to_user_id])) {
        echo htmlspecialchars($pm, ENT_QUOTES, "UTF-8");
    }
} catch (PDOException $e) {
    echo "error";
}
?>
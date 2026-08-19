<?php
require_once "database.php";

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "GET") {
    exit();
}

$current_user = $_SESSION['user_id'];
$contact_id = filter_var($_GET["contact_id"] ?? '', FILTER_SANITIZE_NUMBER_INT);

if (empty($contact_id)) {
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT Id, text1 FROM chat2 WHERE to_user_id = ? AND from_user_id = ? AND view1 = '0' ORDER BY Id ASC LIMIT 1");
    $stmt->execute([$current_user, $contact_id]);
    $row = $stmt->fetch();

    if ($row) {
        $id = $row["Id"];
        $text = $row["text1"];
        
        $updateStmt = $pdo->prepare("UPDATE chat2 SET view1 = '1' WHERE Id = ?");
        $updateStmt->execute([$id]);
        
        echo htmlspecialchars($text, ENT_QUOTES, "UTF-8");
    }
} catch (PDOException $e) {
    exit();
}
?>
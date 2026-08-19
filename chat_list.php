<?php
require_once "database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION['user_id'];

try {
    $sql = "
        SELECT 
            u.id AS contact_id,
            u.Number1 AS contact_phone,
            c.text1 AS last_message,
            c.Id AS message_id
        FROM chat2 c
        INNER JOIN (
            SELECT 
                CASE 
                    WHEN from_user_id = :user_id THEN to_user_id 
                    ELSE from_user_id 
                END AS other_user_id,
                MAX(Id) AS max_id
            FROM chat2
            WHERE from_user_id = :user_id OR to_user_id = :user_id
            GROUP BY other_user_id
        ) latest ON (c.Id = latest.max_id)
        INNER JOIN user u ON u.id = latest.other_user_id
        ORDER BY c.Id DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $current_user]);
    $conversations = $stmt->fetchAll();

} catch (PDOException $e) {
    $conversations = [];
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چت‌ها و پیام‌ها | دیوار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
    <style>
        .chat-list-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #eee;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            padding: 15px;
        }
        .chat-list-card:hover {
            background-color: #fcfcfc;
            border-color: #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .user-avatar {
            width: 48px;
            height: 48px;
            background-color: #f1f3f5;
            color: #6c757d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-light pb-5 pb-md-0">

<nav class="main-header sticky-top py-3 border-bottom bg-white">
    <div class="container d-flex align-items-center">
        <a href="index.php" class="text-dark text-decoration-none me-3"><i class="fas fa-arrow-right"></i> بازگشت</a>
        <h6 class="m-0 fw-bold">صندوق پیام‌ها و چت‌ها</h6>
    </div>
</nav>

<div class="container my-4" style="max-width: 680px;">
    <div class="d-flex flex-column gap-2">
        <?php if (empty($conversations)): ?>
            <div class="bg-white p-5 text-center rounded-3 border text-muted">
                <i class="far fa-comments fs-1 mb-3 d-block text-secondary"></i>
                <p class="m-0">هیچ مکالمه‌ای یافت نشد.</p>
                <small class="text-muted">وقتی در آگهی‌ها به فروشنده‌ای پیام دهید یا پیامی دریافت کنید، چت‌ها اینجا نمایش داده می‌شوند.</small>
            </div>
        <?php else: ?>
            <?php foreach ($conversations as $chat): ?>
                <a href="chat.php?to=<?= $chat['contact_id'] ?>" class="chat-list-card">
                    <div class="user-avatar me-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold fs-6">کاربر دیوار (<?= htmlspecialchars($chat['contact_phone']) ?>)</span>
                        </div>
                        <p class="text-muted small text-truncate m-0"><?= htmlspecialchars($chat['last_message']) ?></p>
                    </div>
                    <i class="fas fa-chevron-left text-muted ms-2"></i>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include "down_btns.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
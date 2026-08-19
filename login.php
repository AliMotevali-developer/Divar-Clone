<?php
require_once "database.php";

$number = "";
$error_msg = "";
$success_msg = "";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["number"])) {
    $number = trim($_POST["number"]);
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

    if (empty($number)) {
        $error_msg = "لطفاً شماره موبایل خود را وارد کنید.";
    } elseif (strlen($number) != 11 || substr($number, 0, 2) != "09") {
        $error_msg = "شماره موبایل نامعتبر است (مثال: 09123456789).";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM user WHERE Number1 = ?");
            $stmt->execute([$number]);
            $user = $stmt->fetch();

            if ($user) {
                $user_id = $user['id'];
            } else {
                $stmt = $pdo->prepare("INSERT INTO user (Number1) VALUES (?)");
                $stmt->execute([$number]);
                $user_id = $pdo->lastInsertId();
            }

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_phone'] = $number;

            $success_msg = "ورود با موفقیت انجام شد. در حال انتقال...";
            echo '<meta http-equiv="refresh" content="2; url=index.php">';
            
        } catch (PDOException $e) {
            $error_msg = "خطایی در سیستم رخ داد. لطفاً مجدداً تلاش کنید.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به حساب کاربری | دیوار بوشهر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <style>
        body { font-family: 'Vazirmatn'; background-color: #f8f9fa; }
        .login-box { max-width: 420px; margin: 80px auto; background: #fff; padding: 40px 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-control:focus { border-color: #a62626; box-shadow: 0 0 0 0.25rem rgba(166, 38, 38, 0.25); }
        .btn-brand { background-color: #a62626; border-color: #a62626; color: white; transition: 0.2s; }
        .btn-brand:hover { background-color: #8a1f1f; border-color: #8a1f1f; color: white; }
        .phone-input { direction: ltr; text-align: left; font-size: 1.1rem; letter-spacing: 1px; }
        
        @media (max-width: 576px) {
            .login-box { margin: 20px auto; padding: 30px 20px; box-shadow: none; border: 1px solid #eee; }
            body { background-color: #fff; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-box">
        <h4 class="mb-3 fw-bold text-dark">ورود به حساب کاربری</h4>
        <p class="text-muted small mb-4">برای استفاده از امکانات دیوار و ثبت آگهی، لطفاً شماره موبایل خود را وارد کنید.</p>

        <?php if ($error_msg): ?>
            <div class="alert alert-danger small py-2 border-0 rounded-3"><?= $error_msg ?></div>
        <?php endif; ?>

        <?php if ($success_msg): ?>
            <div class="alert alert-success small py-2 border-0 rounded-3"><?= $success_msg ?></div>
        <?php endif; ?>

        <form action="login.php" method="post" id="loginForm">
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">شماره موبایل</label>
                <div class="input-group" dir="ltr">
                    <input type="tel" name="number" class="form-control phone-input" placeholder="09123456789" maxlength="11" value="<?= htmlspecialchars($number) ?>" required autocomplete="off">
                </div>
            </div>
            
            <button type="submit" class="btn btn-brand w-100 py-2 fw-bold rounded-3">ورود به دیوار</button>
        </form>
    </div>
</div>

</body>
</html>
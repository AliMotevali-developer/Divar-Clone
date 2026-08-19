<?php
require_once "database.php";

$ad_id = filter_var($_GET['id'] ?? '', FILTER_SANITIZE_NUMBER_INT);

if (empty($ad_id)) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT agahi.*, user.Number1 FROM agahi JOIN user ON agahi.user_id = user.id WHERE agahi.Id = ?");
    $stmt->execute([$ad_id]);
    $ad = $stmt->fetch();

    if (!$ad) {
        die('<div class="p-5 text-center" dir="rtl">آگهی مورد نظر یافت نشد یا حذف شده است. <br><a href="index.php" class="btn btn-danger mt-3">بازگشت به خانه</a></div>');
    }

    $price = is_numeric($ad['gheymat']) ? number_format($ad['gheymat']) . " تومان" : htmlspecialchars($ad['gheymat']);
} catch (PDOException $e) {
    die("خطا در بارگذاری آگهی.");
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ad['onvan']) ?> | دیوار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
    <style>
        .ad-description { line-height: 1.8; color: #444; white-space: pre-wrap; text-align: justify; }
    </style>
</head>
<body class="bg-light pb-5 pb-md-0">

<nav class="main-header sticky-top py-3 border-bottom bg-white">
    <div class="container d-flex align-items-center">
        <a href="index.php" class="text-dark text-decoration-none me-3"><i class="fas fa-arrow-right"></i> بازگشت</a>
        <h6 class="m-0 fw-bold">جزئیات آگهی</h6>
    </div>
</nav>

<div class="container my-4">
    <div class="row bg-white p-3 p-md-4 rounded-3 border g-4">
        
        <div class="col-md-6 text-center">
            <img src="<?= htmlspecialchars($ad['img']) ?>" class="img-fluid rounded-3 border" style="max-height: 420px; width: 100%; object-fit: cover;" alt="عکس آگهی">
        </div>

        <div class="col-md-6 d-flex flex-column">
            <div>
                <h4 class="fw-bold mb-3"><?= htmlspecialchars($ad['onvan']) ?></h4>
                <p class="text-muted small mb-4"><i class="far fa-clock me-1"></i> <?= htmlspecialchars($ad['hour1']) ?></p>

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">وضعیت</span>
                    <span class="fw-bold"><?= htmlspecialchars($ad['karkard']) ?></span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">قیمت</span>
                    <span class="fw-bold text-danger fs-5"><?= $price ?></span>
                </div>
            </div>

            <div class="mt-4 flex-grow-1">
                <h5 class="fw-bold mb-3">توضیحات</h5>
                <p class="ad-description"><?= htmlspecialchars($ad['tozihat'] ?? 'توضیحاتی برای این آگهی ثبت نشده است.') ?></p>
            </div>

            <div class="mt-4 pt-3 border-top sticky-bottom bg-white pb-2">
                <div class="d-flex gap-2">
                    <?php 
                    $is_my_ad = (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $ad['user_id']);
                    if ($is_my_ad): 
                    ?>
                        <button class="btn btn-secondary flex-grow-1 py-2 fw-bold" disabled>
                            <i class="fas fa-user-check me-2"></i> این آگهی شماست
                        </button>
                    <?php else: ?>
                        <a href="chat.php?to=<?= $ad['user_id'] ?>" class="btn btn-danger flex-grow-1 py-2 fw-bold">
                            <i class="far fa-comment-dots me-2"></i> چت در دیوار
                        </a>
                        <a href="tel:<?= htmlspecialchars($ad['Number1']) ?>" class="btn btn-outline-secondary py-2 px-3">
                            <i class="fas fa-phone-alt"></i> اطلاعات تماس
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "down_btns.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
require_once "database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_phone = $_SESSION['user_phone'] ?? 'کاربر دیوار';
$success_msg = "";

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM agahi WHERE Id = ? AND user_id = ?");
        $stmt->execute([$del_id, $user_id]);
        $success_msg = "آگهی با موفقیت حذف شد.";
    } catch (PDOException $e) {
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دیوار من | مدیریت آگهی‌ها</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
</head>
<body class="pb-5 pb-md-0 bg-light">

<nav class="main-header sticky-top py-3 border-bottom bg-white">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="index.php" class="text-dark text-decoration-none me-3">
                <i class="fas fa-arrow-right"></i> بازگشت
            </a>
            <h5 class="m-0 fw-bold">
                <i class="fas fa-user-circle text-secondary me-1"></i> دیوار من
            </h5>
        </div>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">خروج از حساب</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="bg-white p-4 rounded-3 border text-center">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-user fs-1 text-secondary"></i>
                </div>
                <h6 class="fw-bold mb-1">شماره موبایل:</h6>
                <p class="text-muted" dir="ltr"><?= htmlspecialchars($user_phone) ?></p>
                <hr>
                <div class="d-grid gap-2 text-start">
                    <a href="mydivar.php" class="btn btn-light text-start text-danger fw-bold">
                        <i class="fas fa-list me-2"></i> آگهی‌های من
                    </a>
                    <a href="chat_list.php" class="btn btn-light text-start">
                        <i class="far fa-comment me-2"></i> چت‌های من
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-9">
            <h5 class="mb-3 fw-bold">آگهی‌های ثبت شده شما</h5>
            
            <?php if ($success_msg): ?>
                <div class="alert alert-success py-2"><?= $success_msg ?></div>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-md-2 g-3">
                <?php
                try {
                    $stmt = $pdo->prepare("SELECT Id, onvan, gheymat, karkard, img FROM agahi WHERE user_id = ? ORDER BY Id DESC");
                    $stmt->execute([$user_id]);
                    $my_ads = $stmt->fetchAll();

                    if (count($my_ads) == 0) {
                        echo '<div class="col-12"><div class="alert alert-light border text-center py-5">شما هنوز هیچ آگهی‌ای ثبت نکرده‌اید.</div></div>';
                    } else {
                        foreach ($my_ads as $ad) {
                            $price = is_numeric($ad['gheymat']) ? number_format($ad['gheymat']) . " تومان" : htmlspecialchars($ad['gheymat']);
                            echo '
                            <div class="col">
                                <div class="bg-white border rounded-3 p-3 d-flex flex-column h-100">
                                    <div class="d-flex gap-3 mb-3">
                                        <img src="'.htmlspecialchars($ad['img']).'" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="fw-bold mb-1">'.htmlspecialchars($ad['onvan']).'</h6>
                                            <div class="text-muted small mb-1">'.$price.'</div>
                                            <div class="text-muted small">'.htmlspecialchars($ad['karkard']).'</div>
                                        </div>
                                    </div>
                                    <div class="mt-auto d-flex gap-2">
                                        <a href="?delete='.$ad['Id'].'" class="btn btn-sm btn-outline-danger flex-grow-1" onclick="return confirm(\'آیا از حذف این آگهی مطمئن هستید؟\')"><i class="fas fa-trash"></i> حذف آگهی</a>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo '<div class="alert alert-danger">خطا در دریافت اطلاعات.</div>';
                }
                ?>
            </div>
        </div>
        
    </div>
</div>

<?php include "down_btns.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
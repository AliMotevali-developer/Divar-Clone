<?php
require_once "database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error_msg = "";
$success_msg = "";
$agahi_img = "";
$agahi_img2 = "";

$onvan = "";
$gheymat = "";
$karkard = "";
$tozihat = "";
$category = ""; 

if (isset($_POST["submit_img"])) {
    $onvan = htmlspecialchars(trim($_POST["onvan"] ?? ''));
    $gheymat = filter_var(trim($_POST["gheymat"] ?? ''), FILTER_SANITIZE_NUMBER_INT);
    $karkard = htmlspecialchars(trim($_POST["karkard"] ?? ''));
    $tozihat = htmlspecialchars(trim($_POST["tozihat"] ?? ''));
    $category = htmlspecialchars(trim($_POST["category"] ?? ''));

    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $upload_dir = "upload/";
        $file_tmp = $_FILES["fileToUpload"]["tmp_name"];
        $file_size = $_FILES["fileToUpload"]["size"];
        $file_name = $_FILES["fileToUpload"]["name"];
        
        $file_pasvand = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_pasvand = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($file_pasvand, $allowed_pasvand)) {
            $error_msg = "فرمت عکس انتخابی معتبر نیست.";
        } elseif ($file_size > 2 * 1024 * 1024) {
            $error_msg = "حجم عکس انتخابی بیشتر از ۲ مگابایت است.";
        } elseif (getimagesize($file_tmp) === false) {
            $error_msg = "فایل انتخاب شده یک تصویر معتبر نیست.";
        } else {
            $new_name = random_int(100000, 999999) . "_" . time() . "." . $file_pasvand;
            $upload_path = $upload_dir . $new_name;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $agahi_img = $new_name;
                $success_msg = "تصویر با موفقیت بارگذاری شد. حالا فرم را تکمیل کنید.";
            } else {
                $error_msg = "خطا در ذخیره‌سازی فایل رخ داد.";
            }
        }
    } else {
        $error_msg = "لطفاً ابتدا یک تصویر را انتخاب کنید.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_agahi"])) {
    $onvan = htmlspecialchars(trim($_POST["onvan"]));
    $gheymat = filter_var(trim($_POST["gheymat"]), FILTER_SANITIZE_NUMBER_INT);
    $karkard = htmlspecialchars(trim($_POST['karkard']));
    $tozihat = htmlspecialchars(trim($_POST['tozihat']));
    $category = htmlspecialchars(trim($_POST['category'])); 
    $agahi_img = $_POST["image_name"] ?? '';
    
    if (empty($agahi_img)) {
        $error_msg = "لطفاً ابتدا تصویر آگهی را بارگذاری کنید.";
    } elseif (empty($category)) {
        $error_msg = "لطفاً دسته‌بندی آگهی را انتخاب کنید.";
    } elseif (empty($onvan) || strlen($onvan) < 5) {
        $error_msg = "عنوان آگهی نباید خالی یا کمتر از ۵ حرف باشد.";
    } elseif (empty($gheymat)) {
        $error_msg = "لطفاً قیمت آگهی را وارد کنید.";
    } elseif (empty($karkard)) {
        $error_msg = "لطفاً وضعیت کارکرد را وارد کنید.";
    } elseif (empty($tozihat) || strlen($tozihat) < 10) {
        $error_msg = "توضیحات آگهی نمی‌تواند کمتر از ۱۰ حرف باشد.";
    } else {
        try {
            $user_id = $_SESSION['user_id'];
            $agahi_img2 = "upload/" . $agahi_img;
            $hour = "دقایقی پیش در بوشهر";

            $stmt = $pdo->prepare("INSERT INTO agahi (user_id, category, onvan, gheymat, karkard, tozihat, img, hour1) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $category, $onvan, $gheymat, $karkard, $tozihat, $agahi_img2, $hour]);
            
            $success_msg = "آگهی شما با موفقیت ثبت شد.";
            echo '<meta http-equiv="refresh" content="2; url=index.php">';
        } catch (PDOException $e) {
            $error_msg = "خطا در ثبت آگهی. لطفاً مجدداً تلاش کنید.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت آگهی جدید | دیوار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
    <style>
        .form-container { max-width: 600px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #eaeaea; }
        .img-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px dashed #ccc; }
        .btn-brand { background-color: #a62626; color: white; border: none; }
        .btn-brand:hover { background-color: #8a1f1f; color: white; }
        .form-control:focus, .form-select:focus { border-color: #a62626; box-shadow: 0 0 0 0.25rem rgba(166, 38, 38, 0.25); }
        .help-text { font-size: 0.8rem; color: #888; margin-top: 5px; }
        @media (max-width: 576px) { .form-container { margin: 0; border: none; border-radius: 0; padding: 20px; } body{background-color: #fff;} }
    </style>
</head>
<body class="pb-5 pb-md-0 bg-light">

<nav class="main-header sticky-top py-3 border-bottom bg-white">
    <div class="container d-flex align-items-center">
        <a href="index.php" class="text-dark text-decoration-none me-3"><i class="fas fa-arrow-right"></i></a>
        <h5 class="m-0 fw-bold">ثبت آگهی جدید</h5>
    </div>
</nav>

<div class="container p-0 p-md-3">
    <div class="form-container">
        
        <?php if ($error_msg): ?>
            <div class="alert alert-danger small py-2 fw-bold"><i class="fas fa-exclamation-triangle me-1"></i> <?= $error_msg ?></div>
        <?php endif; ?>

        <?php if ($success_msg): ?>
            <div class="alert alert-success small py-2 fw-bold"><i class="fas fa-check-circle me-1"></i> <?= $success_msg ?></div>
        <?php endif; ?>

        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold mb-3">عکس آگهی</h6>
            <p class="text-muted small mb-3">آگهی‌های دارای عکس تا ۳ برابر بیشتر دیده می‌شوند.</p>
            
            <?php if (!empty($agahi_img)): ?>
                <div class="d-flex align-items-center gap-3">
                    <img src="upload/<?= htmlspecialchars($agahi_img) ?>" class="img-preview" alt="پیش‌نمایش">
                    <span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> عکس بارگذاری شد</span>
                </div>
            <?php else: ?>
                <form method="post" action="new_item.php" enctype="multipart/form-data">
                    <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                    <input type="hidden" name="onvan" value="<?= htmlspecialchars($onvan) ?>">
                    <input type="hidden" name="karkard" value="<?= htmlspecialchars($karkard) ?>">
                    <input type="hidden" name="gheymat" value="<?= htmlspecialchars($gheymat) ?>">
                    <input type="hidden" name="tozihat" value="<?= htmlspecialchars($tozihat) ?>">
                    
                    <div class="d-flex gap-2">
                        <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required accept="image/*">
                        <button type="submit" name="submit_img" class="btn btn-secondary px-4">آپلود</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <form action="new_item.php" method="post">
            <input type="hidden" name="image_name" value="<?= htmlspecialchars($agahi_img) ?>">
            
            <div class="mb-4">
                <label class="form-label fw-bold">دسته‌بندی</label>
                <select name="category" class="form-select" required>
                    <option value="" disabled <?= empty($category) ? 'selected' : '' ?>>انتخاب کنید...</option>
                    <option value="real-estate" <?= $category == 'real-estate' ? 'selected' : '' ?>>املاک</option>
                    <option value="vehicles" <?= $category == 'vehicles' ? 'selected' : '' ?>>وسایل نقلیه</option>
                    <option value="digital" <?= $category == 'digital' ? 'selected' : '' ?>>کالای دیجیتال</option>
                    <option value="home" <?= $category == 'home' ? 'selected' : '' ?>>خانه و آشپزخانه</option>
                    <option value="services" <?= $category == 'services' ? 'selected' : '' ?>>خدمات</option>
                    <option value="other" <?= $category == 'other' ? 'selected' : '' ?>>سایر موارد</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">عنوان آگهی</label>
                <input type="text" name="onvan" class="form-control" placeholder="مثال: گوشی سامسونگ S21 الترا، 256 گیگ" value="<?= htmlspecialchars($onvan) ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">وضعیت (کارکرد)</label>
                <select name="karkard" class="form-select" required>
                    <option value="" disabled <?= empty($karkard) ? 'selected' : '' ?>>انتخاب کنید...</option>
                    <option value="نو (آکبند)" <?= $karkard == 'نو (آکبند)' ? 'selected' : '' ?>>نو (آکبند)</option>
                    <option value="در حد نو" <?= $karkard == 'در حد نو' ? 'selected' : '' ?>>در حد نو</option>
                    <option value="کارکرده" <?= $karkard == 'کارکرده' ? 'selected' : '' ?>>کارکرده</option>
                    <option value="نیاز به تعمیر" <?= $karkard == 'نیاز به تعمیر' ? 'selected' : '' ?>>نیاز به تعمیر</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">قیمت (تومان)</label>
                <input type="tel" name="gheymat" class="form-control" placeholder="مثال: 5000000" value="<?= htmlspecialchars($gheymat) ?>" required dir="ltr" style="text-align: right;">
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold">توضیحات آگهی</label>
                <textarea name="tozihat" class="form-control" rows="5" placeholder="جزئیات دستگاه، خط و خش، گارانتی، وسایل همراه و شرایط فروش خود را بنویسید..." required><?= htmlspecialchars($tozihat) ?></textarea>
            </div>

            <button type="submit" name="submit_agahi" class="btn btn-brand w-100 py-3 rounded-3 fw-bold fs-6">ثبت و انتشار آگهی</button>
        </form>

    </div>
</div>

<?php include "down_btns.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
require_once "database.php";

$is_logged_in = isset($_SESSION['user_id']);
$profile_link = $is_logged_in ? "mydivar.php" : "login.php";
$profile_text = $is_logged_in ? "دیوار من" : "ورود / ثبت‌نام";
$chat_link = $is_logged_in ? "chat_list.php" : "login.php";

$current_cat = filter_var($_GET['cat'] ?? '', FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دیوار بوشهر : نیازمندی‌های رایگان، آگهی‌های خرید و فروش</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
    <style>
        .active-cat { background-color: #fce4e4 !important; color: #a62626 !important; font-weight: bold; border-right: 3px solid #a62626; }
        .sidebar-category { padding-right: 12px; }
        
        .mobile-cat-scroll {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            gap: 8px;
            padding-bottom: 8px;
            scrollbar-width: none;
        }
        .mobile-cat-scroll::-webkit-scrollbar { display: none; }
        .cat-chip {
            background: #fff;
            border: 1px solid #ddd;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            color: #555;
            text-decoration: none;
            flex-shrink: 0;
        }
        .cat-chip.active {
            background: #a62626;
            color: #fff;
            border-color: #a62626;
        }
    </style>
</head>
<body class="pb-5 pb-md-0">

<nav class="main-header sticky-top py-2">
    <div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3 col-8 col-md-6">
            <a href="index.php" class="text-danger fw-bold fs-4 text-decoration-none me-2">دیوار</a>
            <div class="text-muted small border-end pe-3 d-none d-md-block">
                <i class="fas fa-map-marker-alt"></i> بوشهر
            </div>
            
            <div class="search-box d-flex align-items-center flex-grow-1">
                <i class="fas fa-search text-muted me-2"></i>
                <input type="text" id="searchInput" onkeyup="searchAjax(this.value)" placeholder="جستجو در همه آگهی‌ها..." autocomplete="off">
            </div>
        </div>

        <div class="d-none d-md-flex align-items-center gap-3">
            <a href="<?= $profile_link ?>" class="text-dark text-decoration-none">
                <i class="fas fa-user"></i> <?= $profile_text ?>
            </a>
            <a href="<?= $chat_link ?>" class="text-dark text-decoration-none">
                <i class="far fa-comment"></i> چت
            </a>
            <a href="new_item.php" class="btn btn-danger px-4 rounded-3">ثبت آگهی</a>
        </div>
    </div>
</nav>

<div class="container-fluid mt-3 px-3 px-md-4">
    
    <div class="d-md-none mb-3">
        <div class="mobile-cat-scroll">
            <a href="index.php" class="cat-chip <?= empty($current_cat) ? 'active' : '' ?>">همه آگهی‌ها</a>
            <a href="index.php?cat=real-estate" class="cat-chip <?= $current_cat == 'real-estate' ? 'active' : '' ?>"><i class="fas fa-home me-1"></i> املاک</a>
            <a href="index.php?cat=vehicles" class="cat-chip <?= $current_cat == 'vehicles' ? 'active' : '' ?>"><i class="fas fa-car me-1"></i> وسایل نقلیه</a>
            <a href="index.php?cat=digital" class="cat-chip <?= $current_cat == 'digital' ? 'active' : '' ?>"><i class="fas fa-mobile-alt me-1"></i> دیجیتال</a>
            <a href="index.php?cat=home" class="cat-chip <?= $current_cat == 'home' ? 'active' : '' ?>"><i class="fas fa-couch me-1"></i> خانه</a>
            <a href="index.php?cat=services" class="cat-chip <?= $current_cat == 'services' ? 'active' : '' ?>"><i class="fas fa-concierge-bell me-1"></i> خدمات</a>
        </div>
    </div>

    <div class="row">
        
        <aside class="col-md-3 d-none d-md-block pe-4">
            <h6 class="fw-bold mb-3">دسته‌ها</h6>
            <nav class="d-flex flex-column gap-1">
                <a href="index.php" class="sidebar-category <?= empty($current_cat) ? 'active-cat' : '' ?>"><i class="fas fa-list me-2"></i> همه آگهی‌ها</a>
                <a href="index.php?cat=real-estate" class="sidebar-category <?= $current_cat == 'real-estate' ? 'active-cat' : '' ?>"><i class="fas fa-home me-2"></i> املاک</a>
                <a href="index.php?cat=vehicles" class="sidebar-category <?= $current_cat == 'vehicles' ? 'active-cat' : '' ?>"><i class="fas fa-car me-2"></i> وسایل نقلیه</a>
                <a href="index.php?cat=digital" class="sidebar-category <?= $current_cat == 'digital' ? 'active-cat' : '' ?>"><i class="fas fa-mobile-alt me-2"></i> کالای دیجیتال</a>
                <a href="index.php?cat=home" class="sidebar-category <?= $current_cat == 'home' ? 'active-cat' : '' ?>"><i class="fas fa-couch me-2"></i> خانه و آشپزخانه</a>
                <a href="index.php?cat=services" class="sidebar-category <?= $current_cat == 'services' ? 'active-cat' : '' ?>"><i class="fas fa-concierge-bell me-2"></i> خدمات</a>
            </nav>
        </aside>

      <main class="col-12 col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-muted fw-normal fs-6 m-0">دیوار بوشهر: انواع آگهی‌ها و خدمات</h5>
                <?php if (!empty($current_cat)): ?>
                    <a href="index.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-times me-1"></i> حذف فیلتر</a>
                <?php endif; ?>
            </div>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3" id="resultContainer">
                <?php
                try {
                    if (!empty($current_cat)) {
                        $stmt = $pdo->prepare("SELECT Id, onvan, gheymat, karkard, img, hour1 FROM agahi WHERE category = ? ORDER BY Id DESC");
                        $stmt->execute([$current_cat]);
                    } else {
                        $stmt = $pdo->query("SELECT Id, onvan, gheymat, karkard, img, hour1 FROM agahi ORDER BY Id DESC");
                    }
                    
                    $ads = $stmt->fetchAll();

                    if (count($ads) == 0) {
                        echo '<div class="col-12 w-100 text-center py-5 text-muted"><i class="fas fa-box-open fs-1 mb-3"></i><p>هنوز آگهی‌ای در این دسته ثبت نشده است.</p></div>';
                    } else {
                        foreach ($ads as $row) {
                            $id = $row["Id"];
                            $onvan = htmlspecialchars(trim($row["onvan"]));
                            $gheymat = htmlspecialchars(trim($row["gheymat"]));
                            $karkard = htmlspecialchars(trim($row["karkard"]));
                            $aks = htmlspecialchars(trim($row["img"]));
                            $hour = htmlspecialchars(trim($row["hour1"]));
                            
                            if (is_numeric($gheymat)) {
                                $gheymat = number_format($gheymat) . " تومان";
                            }

                            echo '
                            <div class="col">
                                <a href="ad.php?id='.$id.'" class="ad-card">
                                    <div class="ad-details">
                                        <div class="ad-title">'.$onvan.'</div>
                                        <div class="mb-1">
                                            <div class="ad-meta mb-1">'.$karkard.'</div>
                                            <div class="ad-price">'.$gheymat.'</div>
                                            <div class="ad-meta mt-1">'.$hour.'</div>
                                        </div>
                                    </div>
                                    <img src="'.$aks.'" alt="'.$onvan.'" class="ad-img">
                                </a>
                            </div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo '<div class="alert alert-danger w-100">خطا در بارگذاری آگهی‌ها.</div>';
                }
                ?>
            </div>
        </main>
    </div>
</div>

<?php include "down_btns.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/search.js"></script>
</body>
</html>
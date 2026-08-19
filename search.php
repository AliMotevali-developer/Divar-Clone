<?php
require_once "database.php";

$search = trim($_GET["search"] ?? '');
$search = htmlspecialchars($search, ENT_QUOTES, "UTF-8");

try {
    if (strlen($search) < 2) {
        $stmt = $pdo->query("SELECT Id, onvan, gheymat, karkard, img, hour1 FROM agahi ORDER BY Id DESC");
    } else {
        $sql = "SELECT Id, onvan, gheymat, karkard, img, hour1 FROM agahi WHERE onvan LIKE ? ORDER BY Id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%" . $search . "%"]);
    }

    $ads = $stmt->fetchAll();

    if (count($ads) == 0) {
        echo '<div class="col-12"><div class="alert alert-secondary text-center py-4 w-100">هیچ آگهی‌ای با این عبارت پیدا نشد.</div></div>';
        exit;
    }

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
} catch (PDOException $e) {
    echo '<div class="alert alert-danger w-100">خطا در پردازش جستجو.</div>';
}
?>
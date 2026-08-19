<?php
$page = basename($_SERVER["PHP_SELF"]);

$is_logged_in = isset($_SESSION['user_id']);
$profile_link = $is_logged_in ? "mydivar.php" : "login.php";
$profile_text = $is_logged_in ? "دیوار من" : "ورود";
$chat_link = $is_logged_in ? "chat_list.php" : "login.php";

$is_index_active = ($page == 'index.php' && empty($_GET['cat'])) ? 'active' : '';
$is_cat_active = !empty($_GET['cat']) ? 'active' : '';
$is_new_active = ($page == 'new_item.php') ? 'active' : '';
$is_chat_active = ($page == 'chat.php' || $page == 'chat_list.php') ? 'active' : '';
$is_profile_active = ($page == 'login.php' || $page == 'mydivar.php') ? 'active' : '';
?>

<div class="bottom-nav bg-white fixed-bottom border-top d-md-none d-flex justify-content-around align-items-center pb-2 pt-1">
    
    <a href="index.php" class="nav-item-bottom text-center w-100 <?php echo $is_index_active; ?>">
        <i class="fas fa-home fs-5 d-block mb-1"></i> آگهی‌ها
    </a>
    
    <button type="button" class="nav-item-bottom text-center w-100 border-0 bg-transparent <?php echo $is_cat_active; ?>" data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas">
        <i class="fas fa-list-ul fs-5 d-block mb-1"></i> دسته‌ها
    </button>
    
    <a href="new_item.php" class="nav-item-bottom text-center w-100 <?php echo $is_new_active; ?>">
        <i class="fas fa-plus-circle fs-5 d-block mb-1"></i> ثبت آگهی
    </a>
    
    <a href="<?php echo $chat_link; ?>" class="nav-item-bottom text-center w-100 <?php echo $is_chat_active; ?>">
        <i class="far fa-comment fs-5 d-block mb-1"></i> چت
    </a>
    
    <a href="<?php echo $profile_link; ?>" class="nav-item-bottom text-center w-100 <?php echo $is_profile_active; ?>">
        <i class="fas fa-user fs-5 d-block mb-1"></i> <?php echo $profile_text; ?>
    </a>
    
</div>

<div class="offcanvas offcanvas-bottom rounded-top-4 d-md-none" tabindex="-1" id="categoriesOffcanvas" style="height: 60vh;">
    <div class="offcanvas-header border-bottom py-3">
        <h6 class="offcanvas-title fw-bold"><i class="fas fa-list-ul text-danger me-2"></i> انتخاب دسته‌بندی</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
    </div>
    <div class="offcanvas-body p-3">
        <div class="d-flex flex-column gap-2">
            <a href="index.php" class="sidebar-category border-bottom py-2"><i class="fas fa-list text-muted me-2"></i> همه آگهی‌ها</a>
            <a href="index.php?cat=real-estate" class="sidebar-category border-bottom py-2"><i class="fas fa-home text-muted me-2"></i> املاک</a>
            <a href="index.php?cat=vehicles" class="sidebar-category border-bottom py-2"><i class="fas fa-car text-muted me-2"></i> وسایل نقلیه</a>
            <a href="index.php?cat=digital" class="sidebar-category border-bottom py-2"><i class="fas fa-mobile-alt text-muted me-2"></i> کالای دیجیتال</a>
            <a href="index.php?cat=home" class="sidebar-category border-bottom py-2"><i class="fas fa-couch text-muted me-2"></i> خانه و آشپزخانه</a>
            <a href="index.php?cat=services" class="sidebar-category border-bottom py-2"><i class="fas fa-concierge-bell text-muted me-2"></i> خدمات</a>
        </div>
    </div>
</div>
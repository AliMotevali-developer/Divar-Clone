<div align="center">

# 🛒 Divar Clone - Online Classifieds & Marketplace Platform

**A full-stack classifieds marketplace featuring real-time messaging, instant search, and categorized listings.**

[English](#-english) • [فارسی](#-فارسی)

</div>

---

<a name="-english"></a>
## 🇬🇧 English

A comprehensive, modular, and responsive online classifieds marketplace platform built with **PHP (PDO)** and **MySQL**. It enables direct peer-to-peer trading, multi-category browsing, real-time asynchronous chat, and secure user management.

### 📸 Screenshots

| Login Page | Dashboard | Listing Details | Live Chat |
| :---: | :---: | :---: | :---: |
| ![Login](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/login.png) | ![Dashboard](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/dashboard.png) | ![Listing](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/item.png) | ![Chat](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/chat.png) |

### ✨ Features
- 🔐 **Session-Based Authentication:** Phone number validation with server-side protected sessions and secure credential management.
- 📂 **Multi-Level Categorization:** Responsive navigation with an offcanvas mobile drawer and persistent desktop sidebar.
- ⚡ **Live AJAX Search:** Instant keyword lookup with debounce optimization to minimize server load.
- 📝 **Ad Management Pipeline:** Multi-file image uploading with strict MIME-type and size validation linked to user ownership (`user_id`).
- 💬 **Real-Time Direct Chat:** Peer-to-peer buyer/seller messaging powered by asynchronous Fetch API polling.
- 📊 **User Dashboard:** Dedicated portal for monitoring, editing, and deleting published listings.

### 🛠️ Tech Stack
- **Backend:** PHP 8.x (PDO Data Access Layer)
- **Database:** MySQL (InnoDB, Foreign Key Constraints, utf8mb4)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+ / Fetch API)
- **UI Frameworks:** Bootstrap 5 RTL, FontAwesome 6

### 🚀 Getting Started

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/AliMotevali-developer/Divar-Clone.git](https://github.com/AliMotevali-developer/Divar-Clone.git)
   cd Divar-Clone

   Setup Database:

Create a new MySQL database (e.g., divar_db).
Import the provided schema/tables (user, agahi, chat2).

Configure Connection:
Rename database.example.php to database.php and set your credentials:
$host = "localhost";
$dbname = "divar_db";
$username = "root";
$password = "";

Verify Upload Directory:
Ensure the upload/ folder exists in the project root with proper write permissions.

Run Application:
Serve via local web server (XAMPP/Laragon) or built-in PHP server:
php -S localhost:8000


-------------------------------------------------------------------------------------------------------------------------------------------------------------------

🇮🇷 فارسی
یک سامانه جامع، ماژولار و ریسپانسیو برای ثبت آگهی، خرید و فروش بدون واسطه و گفتگوی آنلاین خریدار و فروشنده با معماری امن PHP (PDO) و پایگاه داده رابطه‌ای MySQL.




| Login Page | Dashboard | Listing Details | Live Chat |
| :---: | :---: | :---: | :---: |
| ![Login](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/login.png) | ![Dashboard](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/dashboard.png) | ![Listing](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/item.png) | ![Chat](https://raw.githubusercontent.com/AliMotevali-developer/Divar-Clone/main/chat.png) |


✨ ویژگی‌های کلیدی سیستم
🔐 احراز هویت امن: ثبت‌نام و ورود کاربران با اعتبارسنجی شماره همراه و نشست‌های امن سمت سرور.

📂 فیلتر دسته‌بندی هوشمند: منوی کشویی دسته‌بندی در موبایل (Offcanvas) و سایدبار تفکیک‌شده در دسکتاپ.

⚡ جستجوی آنی (Live AJAX Search): جستجوی بدون رفرش با تکنیک Debounce جهت بهینه‌سازی بار پردازشی سرور.

📝 ثبت و مدیریت آگهی: آپلود تصاویر با اعتبارسنجی نوع فایل/حجم و اختصاص شناسه مالکیت (user_id).

💬 چت زنده خریدار و فروشنده: تبادل مستقیم پیام‌ها بر پایه Fetch API و بروزرسانی وضعیت پیام‌ها.

📊 داشبورد اختصاصی (دیوار من): پنل کاربری برای مشاهده، مدیریت و حذف آگهی‌های ثبت‌شده.

🛠️ پشته فناوری (Tech Stack)
بک‌اند: PHP 8.x (لایه ارتباط داده PDO)

پایگاه داده: MySQL (موتور InnoDB، روابط کلید خارجی و utf8mb4)

فرانت‌اند: HTML5, CSS3, JavaScript (ES6+ Fetch API)

فریم‌ورک رابط کاربری: Bootstrap 5 RTL و FontAwesome 6

🚀 راهنمای نصب و راه‌اندازی
۱. کلون ریپازیتوری:
git clone [https://github.com/AliMotevali-developer/Divar-Clone.git](https://github.com/AliMotevali-developer/Divar-Clone.git)
cd Divar-Clone

۲. تنظیم پایگاه داده:
در مدیریت دیتابیس (مانند phpMyAdmin) یک دیتابیس بسازید (مثلاً divar_db).

جداول مربوطه (user، agahi، chat2) را ایمپورت کنید.

۳. پیکربندی اتصال:
فایل database.example.php را به database.php تغییر نام داده و اطلاعات دیتابیس را وارد نمایید:
$host = "localhost";
$dbname = "divar_db";
$username = "root";
$password = "";

۴. پوشه آپلود:
مطمئن شوید پوشه upload/ در ریشه پروژه وجود دارد و مجوز نوشتن (Write Permission) دارد.

# 🛒 پلتفرم نیازمندی و بازارگاه آنلاین (Divar Clone)

یک سامانه جامع، ماژولار و ریسپانسیو برای ثبت آگهی، خرید و فروش بدون واسطه و گفتگوی زنده خریدار و فروشنده با معماری امن **PHP (PDO)** و پایگاه داده رابطه‌ای **MySQL**.

---

## ✨ ویژگی‌های کلیدی سیستم

* **احراز هویت امن (Session-Based Auth):** ثبت‌نام و ورود کاربران با اعتبارسنجی شماره همراه و نشست‌های امن سمت سرور.
* **فیلتر دسته‌بندی هوشمند:** منوی کشویی دسته‌بندی در موبایل (Offcanvas) و سایدبار تفکیک‌شده در دسکتاپ.
* **جستجوی آنی (Live Ajax Search):** جستجوی بدون رفرش با تکنیک Debounce جهت بهینه‌سازی بار سرور.
* **ثبت و مدیریت آگهی:** آپلود تصاویر با اعتبارسنجی نوع فایل/حجم و اختصاص شناسه مالکیت (`user_id`).
* **چت زنده خریدار و فروشنده:** تبادل مستقیم پیام‌ها بر پایه Fetch API و بروزرسانی خودکار پیام‌های نخوانده.
* **داشبورد اختصاصی (دیوار من):** پنل کاربری برای مشاهده، مدیریت و حذف آگهی‌های ثبت‌شده.

---

## 🛠️ پشته فناوری (Tech Stack)

* **Backend:** PHP 8.x (PDO Data Layer)
* **Database:** MySQL (InnoDB, Foreign Key Cascading, UTF-8 MB4)
* **Frontend:** HTML5, CSS3, JavaScript (ES6+ Fetch API)
* **UI Framework:** Bootstrap 5 RTL & FontAwesome 6

---

## 🚀 راهنمای نصب و راه‌اندازی

### ۱. کلون ریپازیتوری
```bash
git clone [https://github.com/YOUR_USERNAME/divar-clone.git](https://github.com/YOUR_USERNAME/divar-clone.git)
cd divar-clone

 تنظیم پایگاه داده
۱. در نرم‌افزار مدیریت دیتابیس (مانند phpMyAdmin) یک پایگاه داده بسازید (مثلاً divar_db).
۲. جداول مربوط به user، agahi و chat2 را ایمپورت کنید.

. پیکربندی اتصال
فایل database.example.php را به database.php تغییر نام داده و اطلاعات دیتابیس لوکال خود را وارد نمایید:

$host = "localhost";
$dbname = "divar_db";
$username = "root";
$password = "";

 ایجاد پوشه آپلود
مطمئن شوید پوشه upload/ در ریشه پروژه وجود دارد و مجوز دسترسی نوشتن (Write Permission) به آن داده شده است.
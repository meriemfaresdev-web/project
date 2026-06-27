<?php
// إعدادات الاتصال بقاعدة البيانات
$host = "localhost";
$db_name = "ecole_formation";
$username = "root";
$password = ""; // غالباً خاوية في XAMPP

try {
    // إنشاء اتصال PDO مع إعدادات الحماية واللغة
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    
    // تفعيل وضع الأخطاء لإظهار أي مشكل في الـ SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // جلب البيانات على شكل مصفوفات ترابطية (Fetch Associative Array) بشكل تلقائي
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // في حالة فشل الاتصال، كيبان هاد المساج
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
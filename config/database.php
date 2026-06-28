<?php
// Railway كيعمر هاد المتغيرات تلقائياً أونلاين، وكيقراو localhost ف اللوكال
$host = getenv('MYSQLHOST') ?: 'localhost';
$port = getenv('MYSQLPORT') ?: '3306';
$db_name = getenv('MYSQLDATABASE') ?: 'ecole_formation'; 
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; // خاوية ف XAMPP

try {
    // إنشاء اتصال PDO مع زيادة المنفذ (port) حيت Railway كيحتاجو
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    
    // تفعيل وضع الأخطاء لإظهار أي مشكل في الـ SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // جلب البيانات على شكل مصفوفات ترابطية (Fetch Associative Array) بشكل تلقائي
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // في حالة فشل الاتصال، كيبان هاد المساج
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
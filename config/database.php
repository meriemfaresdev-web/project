<?php
// Railway كيعمر هاد المتغيرات تلقائياً أونلاين
// 127.0.0.1 عوض localhost ف اللوكال كتجبر السيرفر يخدم ب الـ TCP بلا مشاكل
$host = getenv('MYSQLHOST') ?: '127.0.0.1';
$port = getenv('MYSQLPORT') ?: '3306';
$db_name = getenv('MYSQLDATABASE') ?: 'ecole_formation'; 
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; 

try {
    // زيادة إعداد تحديد الاتصال عبر الشبكة (PDO::MYSQL_ATTR_INIT_COMMAND) تفادياً لأي خلط في السيرفر
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", 
        $username, 
        $password,
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
    );
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
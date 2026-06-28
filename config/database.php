<?php
// إعدادات قاعدة البيانات الذكية
if (getenv('MYSQLHOST')) {
    // ---- الاتصال الداخلي السريع والمضمون أونلاين على Railway ----
    $host     = getenv('MYSQLHOST'); 
    $port     = getenv('MYSQLPORT') ?: '3306';
    $db_name  = getenv('MYSQLDATABASE') ?: 'railway';                                 
    $username = getenv('MYSQLUSER') ?: 'root';                                   
    $password = getenv('MYSQLPASSWORD'); 
} else {
    // ---- لوكال على XAMPP ف الكمبيوتر ----
    $host     = '127.0.0.1';
    $port     = '3306';
    $db_name  = 'ecole_formation';
    $username = 'root';
    $password = ''; 
}

try {
    // الاتصال الداخلي المباشر
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
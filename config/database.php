<?php
// إعدادات قاعدة البيانات الذكية
// غانقراو المتغيرات كيفما كان الاسم ديالها ف Railway
$host     = getenv('MYSQLHOST') ?: getenv('MYSQL_HOST') ?: '127.0.0.1';
$port     = getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: '3306';
$db_name  = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: 'railway';                                 
$username = getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: 'root';                                   
$password = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: ''; 

// إذا كان هاد المتغير كاين، كيعني أن Railway عاطي رابط كامل واجد
if (getenv('MYSQL_URL')) {
    $database_url = getenv('MYSQL_URL');
    $dbparts = parse_url($database_url);
    $host     = $dbparts['host'] ?? $host;
    $port     = $dbparts['port'] ?? $port;
    $username = $dbparts['user'] ?? $username;
    $password = $dbparts['pass'] ?? $password;
    $db_name  = ltrim($dbparts['path'] ?? $db_name, '/');
}

try {
    // الاتصال بالـ PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
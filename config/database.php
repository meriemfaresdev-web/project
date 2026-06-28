<?php
// إعدادات قاعدة البيانات الذكية
if ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1') {
    // ---- أونلاين على Railway (الرابط الخارجي العام الصحيح) ----
    $host = 'roundhouse.proxy.rlwy.net'; 
    $port = '3306'; // ⚠️ تأكدي فقط من هاد الرقم واش هو اللي عندك ف الـ MYSQLPORT، إلا كان مبدل بدليه
    $db_name = 'railway';                                 
    $username = 'root';                                   
    $password = 'RRSsvCCXrqbvkLEcGSPtaLGEqJiEhgxn'; 
} else {
    // ---- لوكال على XAMPP ف الكمبيوتر ----
    $host = '127.0.0.1';
    $port = '3306';
    $db_name = 'ecole_formation';
    $username = 'root';
    $password = ''; 
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
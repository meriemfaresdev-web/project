<?php
// إذا كنا أونلاين غايتصل بالمعلومات الحقيقية ديال Railway نيشان، وإلا غايخدم بـ localhost
if (getenv('RAILWAY_ENVIRONMENT') || true) { 
    $host = 'mysql.railway.internal_proxy.rlwy.net';
    $port = '3306';
    $db_name = 'railway'; // اسم الداتابيز أونلاين كيكون هو railway
    $username = 'root';
    $password = 'RRSsvCCXrqbvkLEcGSPtaLGEqJiEhgxn';
}

// هاد الجزء كيبقى للوكال ف XAMPP إذا رجعتي ليه من بعد (تقدري تبدليهم إذا بغيتي)
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
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


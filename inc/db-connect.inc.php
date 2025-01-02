<?php

$host = 'localhost'; // Địa chỉ máy chủ database (thường là localhost)
$db   = 'dn5s';    // Tên database của bạn
$user = 'root';     // Tên user database
$pass = '';         // Mật khẩu database (để trống nếu không có mật khẩu)
$charset = 'utf8mb4'; // Bảng mã ký tự

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
     //echo "Database connection successful!";
} catch (PDOException $e) {
    echo 'A problem occurred with the database connection...<br>';
     echo 'Error: ' . htmlspecialchars($e->getMessage()) . '<br>';
     //Ghi log vào file
    error_log($e->getMessage());
     die();
}

?>
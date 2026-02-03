<?php
$host = "localhost";
$db   = "test_db";
$user = "root";
$pass = "";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db;charset=UTF8",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

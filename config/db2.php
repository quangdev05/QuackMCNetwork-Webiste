<?php
$servername = "localhost";
$username = "quackmc_net";
$password = "WwGhC2kwxdpdtF3r";
$dbname = "quackmc_net";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
    exit;
}
?>
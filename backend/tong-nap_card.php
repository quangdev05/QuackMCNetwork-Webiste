<?php
require_once(__DIR__."/../config/db2.php");

$sql = "
    SELECT 
        user_id, 
        REPLACE(FORMAT(SUM(IFNULL(amount, 0)) + SUM(REPLACE(IFNULL(amount2, '0'), '.', '')), 0), ',', '.') as tongnap
    FROM 
        recharge_logs
    WHERE 
        status = 1
    GROUP BY 
        user_id
";

$stmt = $conn->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$insertSql = "
    INSERT INTO tong_nap (user_id, tongnap)
    VALUES (:user_id, :tongnap)
    ON DUPLICATE KEY UPDATE tongnap = :tongnap
";
$insertStmt = $conn->prepare($insertSql);

foreach ($results as $row) {
    $insertStmt->execute([
        ':user_id' => $row['user_id'],
        ':tongnap' => $row['tongnap']
    ]);
}

echo "Dữ liệu đã được tổng hợp và ghi vào bảng tong_nap.";

$conn = null;
?>

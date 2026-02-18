<?php
require_once 'config.php';
checkUserLogin();

$conn = getDBConnection();
$realname = $_SESSION['realname'];

// 获取统计数据（通过姓名关联）
$stmt = $conn->prepare("SELECT 
    COUNT(*) as total_records,
    COALESCE(SUM(commission), 0) as total_commission,
    COALESCE(SUM(CASE WHEN is_paid = 1 THEN commission ELSE 0 END), 0) as paid_commission,
    COALESCE(SUM(CASE WHEN is_paid = 0 THEN commission ELSE 0 END), 0) as unpaid_commission
    FROM records WHERE realname = ?");
$stmt->bind_param("s", $realname);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();

$stmt->close();
$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'stats' => $stats), JSON_UNESCAPED_UNICODE);
?>

<?php
require_once 'config.php';
checkSalespersonLogin();

$conn = getDBConnection();
$salesperson_id = $_SESSION['salesperson_id'];

// 获取统计数据
$sql_stats = "SELECT 
    COUNT(*) as total_records,
    COALESCE(SUM(commission), 0) as total_amount
    FROM records WHERE salesperson_id = $salesperson_id";

$result_stats = $conn->query($sql_stats);
$stats = $result_stats->fetch_assoc();

// 获取记录列表
$sql = "SELECT * FROM records WHERE salesperson_id = $salesperson_id ORDER BY record_date DESC, id DESC";
$result = $conn->query($sql);

$records = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'records' => $records, 'stats' => $stats), JSON_UNESCAPED_UNICODE);
?>


<?php
require_once 'config.php';
checkSalespersonLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的记录ID');
}

$conn = getDBConnection();
$salesperson_id = $_SESSION['salesperson_id'];

// 验证记录是否属于当前业务员
$stmt = $conn->prepare("SELECT * FROM records WHERE id = ? AND salesperson_id = ?");
$stmt->bind_param("ii", $id, $salesperson_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => true, 'message' => '获取成功', 'record' => $record), JSON_UNESCAPED_UNICODE);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => '记录不存在或无权限访问'), JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$conn->close();
?>


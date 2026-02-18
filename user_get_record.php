<?php
require_once 'config.php';
checkUserLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => '无效的记录ID'), JSON_UNESCAPED_UNICODE);
    exit();
}

$conn = getDBConnection();
$realname = $_SESSION['realname'];

// 确保只能获取自己姓名的记录
$stmt = $conn->prepare("SELECT * FROM records WHERE id = ? AND realname = ?");
$stmt->bind_param("is", $id, $realname);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => true, 'message' => '获取成功', 'record' => $record), JSON_UNESCAPED_UNICODE);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => '记录不存在或无权访问'), JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$conn->close();
?>

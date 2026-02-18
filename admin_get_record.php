<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => '无效的记录ID'), JSON_UNESCAPED_UNICODE);
    exit();
}

$conn = getDBConnection();

$sql = "SELECT * FROM records WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => true, 'message' => '获取成功', 'record' => $record), JSON_UNESCAPED_UNICODE);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => '记录不存在'), JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>


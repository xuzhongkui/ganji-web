<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的支出ID');
}

$conn = getDBConnection();

$sql = "SELECT * FROM expenses WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $expense = $result->fetch_assoc();
    json_response(true, '获取成功', array('expense' => $expense));
} else {
    json_response(false, '支出记录不存在');
}

$conn->close();
?>


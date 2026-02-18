<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$status = isset($_GET['status']) ? intval($_GET['status']) : 0;

if ($id <= 0) {
    json_response(false, '无效的业务员ID');
}

$conn = getDBConnection();

$sql = "UPDATE salesperson SET status = $status WHERE id = $id";
if ($conn->query($sql)) {
    json_response(true, '操作成功');
} else {
    json_response(false, '操作失败');
}

$conn->close();
?>


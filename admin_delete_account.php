<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的账号ID');
}

$conn = getDBConnection();

$sql = "DELETE FROM payment_accounts WHERE id = $id";
if ($conn->query($sql)) {
    json_response(true, '删除成功');
} else {
    json_response(false, '删除失败');
}

$conn->close();
?>


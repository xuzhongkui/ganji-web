<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的用户ID');
}

$conn = getDBConnection();

// 删除用户（不删除记录，因为记录是通过姓名关联的）
$sql = "DELETE FROM users WHERE id = $id";
if ($conn->query($sql)) {
    json_response(true, '删除成功');
} else {
    json_response(false, '删除失败');
}

$conn->close();
?>


<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的业务员ID');
}

$conn = getDBConnection();

// 先删除该业务员录入的所有记录
$conn->query("DELETE FROM records WHERE salesperson_id = $id");

// 再删除业务员
$sql = "DELETE FROM salesperson WHERE id = $id";
if ($conn->query($sql)) {
    json_response(true, '删除成功');
} else {
    json_response(false, '删除失败');
}

$conn->close();
?>


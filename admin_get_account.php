<?php
require_once 'config.php';
checkAdminLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    json_response(false, '无效的账号ID');
}

$conn = getDBConnection();

$sql = "SELECT * FROM payment_accounts WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $account = $result->fetch_assoc();
    json_response(true, '获取成功', array('account' => $account));
} else {
    json_response(false, '账号不存在');
}

$conn->close();
?>


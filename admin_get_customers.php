<?php
require_once 'config.php';
checkAdminLogin();

$conn = getDBConnection();

$sql = "SELECT id, username, realname, create_time, status FROM users ORDER BY id DESC";
$result = $conn->query($sql);

$customers = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'customers' => $customers), JSON_UNESCAPED_UNICODE);
?>


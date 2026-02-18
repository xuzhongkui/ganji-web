<?php
require_once 'config.php';
checkAdminLogin();

$conn = getDBConnection();

$sql = "SELECT id, username, realname, create_time, status FROM salesperson ORDER BY id DESC";
$result = $conn->query($sql);

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'users' => $users), JSON_UNESCAPED_UNICODE);
?>


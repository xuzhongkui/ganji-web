<?php
require_once 'config.php';
checkAdminLogin();

$conn = getDBConnection();

$search_name = isset($_GET['search_name']) ? safe_input($_GET['search_name']) : '';

$sql = "SELECT * FROM payment_accounts WHERE 1=1";

// 按用户姓名精确搜索
if (!empty($search_name)) {
    $sql .= " AND realname = '" . $conn->real_escape_string($search_name) . "'";
}

$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);

$accounts = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
}

$conn->close();

json_response(true, '获取成功', array('accounts' => $accounts));
?>


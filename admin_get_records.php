<?php
require_once 'config.php';
checkAdminLogin();

$conn = getDBConnection();

$filter_paid = isset($_GET['filter_paid']) ? $_GET['filter_paid'] : '';
$search_name = isset($_GET['search_name']) ? safe_input($_GET['search_name']) : '';

$sql = "SELECT * FROM records WHERE 1=1";

// 按发放状态筛选
if ($filter_paid !== '') {
    $sql .= " AND is_paid = " . intval($filter_paid);
}

// 按用户姓名精确搜索
if (!empty($search_name)) {
    $sql .= " AND realname = '" . $conn->real_escape_string($search_name) . "'";
}

$sql .= " ORDER BY record_date DESC, id DESC";

$result = $conn->query($sql);

$records = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'records' => $records), JSON_UNESCAPED_UNICODE);
?>

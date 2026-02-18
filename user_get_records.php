<?php
require_once 'config.php';
checkUserLogin();

$conn = getDBConnection();
$realname = $_SESSION['realname'];

$filter_paid = isset($_GET['filter_paid']) ? $_GET['filter_paid'] : '';

// 通过姓名关联查询数据
$sql = "SELECT * FROM records WHERE realname = ?";
if ($filter_paid !== '') {
    $sql .= " AND is_paid = " . intval($filter_paid);
}
$sql .= " ORDER BY record_date DESC, id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $realname);
$stmt->execute();
$result = $stmt->get_result();

$records = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'message' => '获取成功', 'records' => $records), JSON_UNESCAPED_UNICODE);
?>

<?php
require_once 'config.php';
checkAdminLogin();

$conn = getDBConnection();

$category = isset($_GET['category']) ? safe_input($_GET['category']) : '';
$project = isset($_GET['project']) ? safe_input($_GET['project']) : '';
$start_date = isset($_GET['start_date']) ? safe_input($_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? safe_input($_GET['end_date']) : '';

$sql = "SELECT * FROM expenses WHERE 1=1";

// 按类别精确搜索（也可以改为模糊搜索）
if (!empty($category)) {
    $sql .= " AND category LIKE '%" . $conn->real_escape_string($category) . "%'";
}

// 按支出项目模糊搜索
if (!empty($project)) {
    $sql .= " AND project LIKE '%" . $conn->real_escape_string($project) . "%'";
}

// 按时间范围筛选
if (!empty($start_date)) {
    $sql .= " AND expense_date >= '" . $conn->real_escape_string($start_date) . "'";
}

if (!empty($end_date)) {
    $sql .= " AND expense_date <= '" . $conn->real_escape_string($end_date) . "'";
}

$sql .= " ORDER BY expense_date DESC, id DESC";

$result = $conn->query($sql);

$expenses = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
}

$conn->close();

json_response(true, '获取成功', array('expenses' => $expenses));
?>


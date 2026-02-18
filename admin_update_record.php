<?php
require_once 'config.php';
checkAdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $realname = safe_input($_POST['realname']);
    $record_date = safe_input($_POST['record_date']);
    $deposit = floatval($_POST['deposit']);
    $location = safe_input($_POST['location']);
    $fare = floatval($_POST['fare']);
    $project_fee = floatval($_POST['project_fee']);
    $overtime_fee = floatval($_POST['overtime_fee']);
    $commission = floatval($_POST['commission']);
    $is_paid = intval($_POST['is_paid']);
    
    if (empty($realname) || empty($record_date)) {
        json_response(false, '姓名和日期不能为空');
    }
    
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("UPDATE records SET realname=?, record_date=?, deposit=?, location=?, fare=?, project_fee=?, overtime_fee=?, commission=?, is_paid=? WHERE id=?");
    $stmt->bind_param("ssdsddddii", $realname, $record_date, $deposit, $location, $fare, $project_fee, $overtime_fee, $commission, $is_paid, $id);
    
    if ($stmt->execute()) {
        json_response(true, '更新成功');
    } else {
        json_response(false, '更新失败');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


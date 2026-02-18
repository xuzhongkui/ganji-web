<?php
require_once 'config.php';
checkUserLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $record_date = safe_input($_POST['record_date']);
    $deposit = floatval($_POST['deposit']);
    $location = safe_input($_POST['location']);
    $fare = floatval($_POST['fare']);
    $project_fee = floatval($_POST['project_fee']);
    $overtime_fee = floatval($_POST['overtime_fee']);
    $commission = floatval($_POST['commission']);
    // actual_salary字段保留在数据库中，但前端不再显示，这里设置为0
    $actual_salary = 0;
    
    if (empty($record_date)) {
        json_response(false, '日期不能为空');
    }
    
    $conn = getDBConnection();
    $realname = $_SESSION['realname'];
    
    // 确保只能更新自己姓名的记录
    $stmt = $conn->prepare("UPDATE records SET record_date=?, deposit=?, location=?, fare=?, project_fee=?, overtime_fee=?, commission=?, actual_salary=? WHERE id=? AND realname=?");
    $stmt->bind_param("sdsdddddis", $record_date, $deposit, $location, $fare, $project_fee, $overtime_fee, $commission, $actual_salary, $id, $realname);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            json_response(true, '更新成功');
        } else {
            json_response(false, '记录不存在或无权修改');
        }
    } else {
        json_response(false, '更新失败');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>

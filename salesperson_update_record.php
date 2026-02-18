<?php
require_once 'config.php';
checkSalespersonLogin();

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
    
    if (empty($realname) || empty($record_date)) {
        json_response(false, '姓名和日期不能为空');
    }
    
    $conn = getDBConnection();
    $salesperson_id = $_SESSION['salesperson_id'];
    
    // 验证记录是否属于当前业务员
    $check_sql = "SELECT id FROM records WHERE id = $id AND salesperson_id = $salesperson_id";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows == 0) {
        json_response(false, '记录不存在或无权限修改');
    }
    
    $stmt = $conn->prepare("UPDATE records SET realname=?, record_date=?, deposit=?, location=?, fare=?, project_fee=?, overtime_fee=?, commission=? WHERE id=? AND salesperson_id=?");
    $stmt->bind_param("ssdsddddii", $realname, $record_date, $deposit, $location, $fare, $project_fee, $overtime_fee, $commission, $id, $salesperson_id);
    
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


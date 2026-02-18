<?php
require_once 'config.php';
checkUserLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $user_id = $_SESSION['user_id'];
    $realname = $_SESSION['realname'];
    
    // 业务员信息设置为0和"用户自录"，表示是用户自己录入的
    $salesperson_id = 0;
    $salesperson_name = "用户自录";
    
    $stmt = $conn->prepare("INSERT INTO records (salesperson_id, salesperson_name, realname, record_date, deposit, location, fare, project_fee, overtime_fee, commission, actual_salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdsddddd", $salesperson_id, $salesperson_name, $realname, $record_date, $deposit, $location, $fare, $project_fee, $overtime_fee, $commission, $actual_salary);
    
    if ($stmt->execute()) {
        json_response(true, '数据录入成功');
    } else {
        json_response(false, '数据录入失败');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


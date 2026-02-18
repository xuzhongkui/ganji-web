<?php
require_once 'config.php';
checkAdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $category = safe_input($_POST['category']);
    $project = safe_input($_POST['project']);
    $amount = floatval($_POST['amount']);
    $expense_date = safe_input($_POST['expense_date']);
    $remark = safe_input($_POST['remark']);
    
    if (empty($category) || empty($project) || empty($expense_date)) {
        json_response(false, '类别、支出项目和日期不能为空');
    }
    
    if ($amount <= 0) {
        json_response(false, '金额必须大于0');
    }
    
    $conn = getDBConnection();
    
    if ($id > 0) {
        // 更新
        $stmt = $conn->prepare("UPDATE expenses SET category=?, project=?, amount=?, expense_date=?, remark=? WHERE id=?");
        $stmt->bind_param("ssdssi", $category, $project, $amount, $expense_date, $remark, $id);
        
        if ($stmt->execute()) {
            json_response(true, '更新成功');
        } else {
            json_response(false, '更新失败');
        }
    } else {
        // 新增
        $stmt = $conn->prepare("INSERT INTO expenses (category, project, amount, expense_date, remark) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $category, $project, $amount, $expense_date, $remark);
        
        if ($stmt->execute()) {
            json_response(true, '新增成功');
        } else {
            json_response(false, '新增失败');
        }
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


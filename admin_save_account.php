<?php
require_once 'config.php';
checkAdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $realname = safe_input($_POST['realname']);
    $pay_id = safe_input($_POST['pay_id']);
    $bsb = safe_input($_POST['bsb']);
    $acc = safe_input($_POST['acc']);
    
    if (empty($realname)) {
        json_response(false, '用户姓名不能为空');
    }
    
    $conn = getDBConnection();
    
    if ($id > 0) {
        // 更新
        $stmt = $conn->prepare("UPDATE payment_accounts SET realname=?, pay_id=?, bsb=?, acc=? WHERE id=?");
        $stmt->bind_param("ssssi", $realname, $pay_id, $bsb, $acc, $id);
        
        if ($stmt->execute()) {
            json_response(true, '更新成功');
        } else {
            json_response(false, '更新失败');
        }
    } else {
        // 新增
        $stmt = $conn->prepare("INSERT INTO payment_accounts (realname, pay_id, bsb, acc) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $realname, $pay_id, $bsb, $acc);
        
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


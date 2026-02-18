<?php
require_once 'config.php';
checkSalespersonLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    
    if (empty($old_password) || empty($new_password)) {
        json_response(false, '密码不能为空');
    }
    
    if (strlen($new_password) < 6) {
        json_response(false, '新密码至少6个字符');
    }
    
    $conn = getDBConnection();
    $salesperson_id = $_SESSION['salesperson_id'];
    
    // 验证原密码
    $stmt = $conn->prepare("SELECT id FROM salesperson WHERE id = ? AND password = MD5(?)");
    $stmt->bind_param("is", $salesperson_id, $old_password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        json_response(false, '原密码错误');
    }
    
    // 更新密码
    $stmt = $conn->prepare("UPDATE salesperson SET password = MD5(?) WHERE id = ?");
    $stmt->bind_param("si", $new_password, $salesperson_id);
    
    if ($stmt->execute()) {
        json_response(true, '密码修改成功');
    } else {
        json_response(false, '密码修改失败');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


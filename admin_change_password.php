<?php
require_once 'config.php';
checkAdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    
    if (empty($old_password) || empty($new_password)) {
        json_response(false, '密码不能为空');
    }
    
    $conn = getDBConnection();
    $admin_id = $_SESSION['admin_id'];
    
    // 验证原密码
    $stmt = $conn->prepare("SELECT id FROM admin WHERE id = ? AND password = MD5(?)");
    $stmt->bind_param("is", $admin_id, $old_password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        json_response(false, '原密码错误');
    }
    
    // 更新密码
    $stmt = $conn->prepare("UPDATE admin SET password = MD5(?) WHERE id = ?");
    $stmt->bind_param("si", $new_password, $admin_id);
    
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


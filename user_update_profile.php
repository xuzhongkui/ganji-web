<?php
require_once 'config.php';
checkUserLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $realname = safe_input($_POST['realname']);
    
    if (empty($realname)) {
        json_response(false, '姓名不能为空');
    }
    
    $conn = getDBConnection();
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("UPDATE users SET realname = ? WHERE id = ?");
    $stmt->bind_param("si", $realname, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['realname'] = $realname;
        
        // 同时更新records表中的姓名
        $stmt2 = $conn->prepare("UPDATE records SET realname = ? WHERE user_id = ?");
        $stmt2->bind_param("si", $realname, $user_id);
        $stmt2->execute();
        $stmt2->close();
        
        json_response(true, '资料更新成功');
    } else {
        json_response(false, '资料更新失败');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


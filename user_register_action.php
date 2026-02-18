<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = safe_input($_POST['username']);
    $password = $_POST['password'];
    $realname = safe_input($_POST['realname']);
    
    if (empty($username) || empty($password) || empty($realname)) {
        json_response(false, '所有字段都不能为空');
    }
    
    if (strlen($username) < 4) {
        json_response(false, '用户名至少4个字符');
    }
    
    if (strlen($password) < 6) {
        json_response(false, '密码至少6个字符');
    }
    
    $conn = getDBConnection();
    
    // 检查用户名是否已存在
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        json_response(false, '用户名已存在');
    }
    
    // 插入新用户
    $stmt = $conn->prepare("INSERT INTO users (username, password, realname) VALUES (?, MD5(?), ?)");
    $stmt->bind_param("sss", $username, $password, $realname);
    
    if ($stmt->execute()) {
        json_response(true, '注册成功，请登录');
    } else {
        json_response(false, '注册失败，请重试');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


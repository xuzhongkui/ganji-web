<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = safe_input($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        json_response(false, '用户名和密码不能为空');
    }
    
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, username, realname, status FROM users WHERE username = ? AND password = MD5(?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($user['status'] == 0) {
            json_response(false, '账号已被禁用，请联系管理员');
        }
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['realname'] = $user['realname'];
        json_response(true, '登录成功');
    } else {
        json_response(false, '用户名或密码错误');
    }
    
    $stmt->close();
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = safe_input($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        json_response(false, '用户名和密码不能为空');
    }
    
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, username FROM admin WHERE username = ? AND password = MD5(?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
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


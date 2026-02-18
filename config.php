<?php
// 数据库配置文件
header('Content-Type: text/html; charset=utf-8');

// 数据库配置
define('DB_HOST', 'localhost');
define('DB_USER', 'feiyongtj_com');
define('DB_PASS', '562tdjPhc7H7FJmX');
define('DB_NAME', 'feiyongtj_com');

// 创建数据库连接
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// 启动会话
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 检查管理员登录状态
function checkAdminLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: admin_login.html');
        exit();
    }
}

// 检查业务员登录状态
function checkSalespersonLogin() {
    if (!isset($_SESSION['salesperson_id'])) {
        header('Location: salesperson_login.html');
        exit();
    }
}

// 检查用户登录状态
function checkUserLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: user_login.html');
        exit();
    }
}

// 安全过滤函数
function safe_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// 返回JSON响应
function json_response($success, $message, $data = null) {
    header('Content-Type: application/json; charset=utf-8');
    $response = array(
        'success' => $success,
        'message' => $message
    );
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
?>

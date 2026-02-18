<?php
require_once 'config.php';

if (isset($_SESSION['admin_id'])) {
    json_response(true, '已登录', array(
        'admin_id' => $_SESSION['admin_id'],
        'username' => $_SESSION['admin_username']
    ));
} else {
    json_response(false, '未登录');
}
?>


<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    json_response(true, '已登录', array(
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'realname' => $_SESSION['realname']
    ));
} else {
    json_response(false, '未登录');
}
?>


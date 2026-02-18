<?php
require_once 'config.php';

if (isset($_SESSION['salesperson_id'])) {
    json_response(true, '已登录', array(
        'salesperson_id' => $_SESSION['salesperson_id'],
        'username' => $_SESSION['salesperson_username'],
        'realname' => $_SESSION['salesperson_realname']
    ));
} else {
    json_response(false, '未登录');
}
?>


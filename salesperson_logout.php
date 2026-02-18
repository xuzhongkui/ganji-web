<?php
require_once 'config.php';

session_destroy();
header('Location: salesperson_login.html');
exit();
?>


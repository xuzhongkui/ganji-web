<?php
require_once 'config.php';
checkAdminLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $ids = $_POST['ids'];
    
    if (empty($ids)) {
        json_response(false, '未选择记录');
    }
    
    $conn = getDBConnection();
    
    $ids_array = explode(',', $ids);
    $ids_safe = array_map('intval', $ids_array);
    $ids_str = implode(',', $ids_safe);
    
    if ($action == 'delete') {
        $sql = "DELETE FROM records WHERE id IN ($ids_str)";
        if ($conn->query($sql)) {
            json_response(true, '删除成功');
        } else {
            json_response(false, '删除失败');
        }
    } else if ($action == 'mark_paid') {
        $sql = "UPDATE records SET is_paid = 1 WHERE id IN ($ids_str)";
        if ($conn->query($sql)) {
            json_response(true, '标记已发成功');
        } else {
            json_response(false, '标记失败');
        }
    } else if ($action == 'mark_unpaid') {
        $sql = "UPDATE records SET is_paid = 0 WHERE id IN ($ids_str)";
        if ($conn->query($sql)) {
            json_response(true, '标记未发成功');
        } else {
            json_response(false, '标记失败');
        }
    } else {
        json_response(false, '无效的操作');
    }
    
    $conn->close();
} else {
    json_response(false, '非法请求');
}
?>


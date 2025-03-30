<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

// Nhận ID đơn hàng từ URL
$order_id = $_GET['id'] ?? 0;
$order_id = (int) $order_id;

if ($order_id > 0) {
    // Kiểm tra xem đơn hàng có tồn tại không
    $stmt = $db->prepare('SELECT COUNT(*) FROM nv5_vi_petshop_orders WHERE id = :id');
    $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        // Xóa đơn hàng
        $stmt = $db->prepare('DELETE FROM nv5_vi_petshop_orders WHERE id = :id');
        $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
                . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=orders');
            exit();
        } else {
            echo 'Lỗi khi xóa đơn hàng.';
        }
    } else {
        echo 'Đơn hàng không tồn tại.';
    }
} else {
    echo 'ID đơn hàng không hợp lệ.';
}

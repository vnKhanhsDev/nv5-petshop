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

$post_id = $_GET['id'] ?? 0;

if ($post_id > 0) {
    // Kiểm tra xem bài viết có tồn tại không
    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_posts WHERE id = :id');
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        // Xóa bài viết
        $stmt = $db->prepare('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_posts WHERE id = :id');
        $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
                . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=posts');
            exit();
        } else {
            echo 'Lỗi khi xóa bài viết.';
        }
    } else {
        echo 'Bài viết không tồn tại.';
    }
} else {
    echo 'ID bài viết không hợp lệ.';
}

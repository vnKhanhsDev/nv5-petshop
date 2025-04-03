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

$accessories_id = $_GET['id'] ?? 0;
 
 if ($accessories_id > 0) {
     // Kiểm tra xem phụ kiện có tồn tại không
     $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories WHERE id = :id');
     $stmt->bindParam(':id', $accessories_id, PDO::PARAM_INT);
     $stmt->execute();
     
     if ($stmt->fetchColumn() > 0) {
         // Xóa phụ kiện
         $stmt = $db->prepare('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories WHERE id = :id');
         $stmt->bindParam(':id', $accessories_id, PDO::PARAM_INT);
         
         if ($stmt->execute()) {
             header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
                 . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=accessories');
             exit();
         } else {
             echo 'Lỗi khi xóa phụ kiện.';
         }
     } else {
         echo 'phụ kiện không tồn tại.';
     }
 } else {
     echo 'ID phụ kiện không hợp lệ.';
 }
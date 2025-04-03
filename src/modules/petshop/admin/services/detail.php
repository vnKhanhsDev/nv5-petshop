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
 
 $page_title = $nv_Lang->getModule('edit_service');
 
 $service_id = $_GET['id'] ?? 0;
 
 if ($service_id > 0) {
     // Lấy thông tin sản phẩm từ database
     $stmt = $db->prepare('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_services WHERE id = :id');
     $stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
     $stmt->execute();
     $service = $stmt->fetch();
 
     if (!$service) {
         die('Dịch vụ không tồn tại.');
     }
 } else {
     die('ID dịch vụ không hợp lệ.');
 }


  // Load template
  $xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/services/');
  $xtpl->assign('SERVICE', $service);
  $xtpl->parse('detail');
  $contents = $xtpl->text('detail');
  
  include NV_ROOTDIR . '/includes/header.php';
  echo nv_admin_theme($contents);
  include NV_ROOTDIR . '/includes/footer.php';
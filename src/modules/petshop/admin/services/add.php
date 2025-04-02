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
 
 $page_title = $nv_Lang->getModule('add_service');;
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $name = $_POST['name'] ?? '';
     $price = $_POST['price'] ?? 0;
     $discount = $_POST['discount'] ?? 0;
     $estimated_time = $_POST['estimated_time'] ?? 0;
     $requires_appointment = $_POST['requires_appointment'] ?? 0;
     $rating = $_POST['rating'] ?? 0;
     $description = $_POST['description'] ?? '';
     $image = $_POST['image'] ?? '';
     $is_show = $_POST['is_show'] ?? 1;
     $created_at = time();
     $updated_at = time();
 
     if (!empty($name) && !empty($category_id)) {
         $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_services 
             (name, price, discount, estimated_time, requires_appointment, rating, description, image, is_show, created_at, updated_at) 
             VALUES (:name, :price, :discount, :estimated_time, :requires_appointment, :rating, :description, :image, :is_show, :created_at, :updated_at)');
 
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->bindParam(':price', $price, PDO::PARAM_INT);
         $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
         $stmt->bindParam(':estimated_time', $estimated_time, PDO::PARAM_INT);
         $stmt->bindParam(':requires_appointment', $requires_appointment, PDO::PARAM_INT);
         $stmt->bindParam(':rating', $rating, PDO::PARAM_FLOAT);
         $stmt->bindParam(':description', $description, PDO::PARAM_STR);
         $stmt->bindParam(':image', $image, PDO::PARAM_STR);
         $stmt->bindParam(':is_show', $is_show, PDO::PARAM_INT);
         $stmt->bindParam(':created_at', $created_at, PDO::PARAM_INT);
         $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);
 
         if ($stmt->execute()) {
             header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
                 . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=services');
             exit();
         } else {
             echo 'Lỗi khi thêm dịch vụ.';
         }
     } else {
         echo 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
     }
 }
 
 // Load giao diện add.tpl
 $xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/services/');
 $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
 $xtpl->parse('add');
 $contents = $xtpl->text('add');
 
 include (NV_ROOTDIR . "/includes/header.php");
 echo nv_admin_theme($contents);
 include (NV_ROOTDIR . "/includes/footer.php");
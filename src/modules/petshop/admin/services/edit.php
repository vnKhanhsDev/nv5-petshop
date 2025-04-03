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
 
 // Nếu người dùng submit form (POST request)
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_services 
         SET name = :name, price = :price, discount = :discount, estimated_time = :estimated_time, requires_appointment = :requires_appointment, description = :description, is_show = :is_show 
         WHERE id = :id';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = '';
        $upload = new NukeViet\Files\Upload(
                $admin_info['allow_files_type'], 
                $global_config['forbid_extensions'], 
                $global_config['forbid_mimes'], 
                NV_UPLOAD_MAX_FILESIZE, 
                NV_MAX_WIDTH, 
                NV_MAX_HEIGHT
            );
    
        // Thiết lập ngôn ngữ
        $upload->setLanguage($lang_global);
    
        // Xác định thư mục lưu ảnh
        $target_dir = NV_UPLOADS_REAL_DIR . '/' . $module_name . '/services/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có
        }
    
        // Tải file lên server
        $upload_info = $upload->save_file($_FILES['image'], $target_dir, false, $global_config['nv_auto_resize']);
    
        // Kiểm tra lỗi upload
        if (!empty($upload_info['error'])) {
            die('Lỗi upload file: ' . $upload_info['error']);
        } else {
            // Đường dẫn ảnh đã upload
            $image_path = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/services/' . $upload_info['basename'];
        }
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_services 
         SET name = :name, price = :price, discount = :discount, estimated_time = :estimated_time, requires_appointment = :requires_appointment, description = :description, image = :image, is_show = :is_show 
         WHERE id = :id';
    }


     $name = trim($_POST['name']);
     $price = floatval($_POST['price']);
     $discount = intval($_POST['discount']);
     $estimated_time = intval($_POST['estimated_time']);
     $requires_appointment = intval($_POST['requires_appointment']);
     $description = trim($_POST['description']);
     $is_show = intval($_POST['is_show']);
     $image = $image_path ?? '';
     if ($name == '' || $price <= 0 || $quantity < 0) {
         die('Dữ liệu không hợp lệ.');
     }
 
     // Cập nhật sản phẩm vào database
     $stmt = $db->prepare($sql);
 
     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
     $stmt->bindParam(':price', $price, PDO::PARAM_STR);
     $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
     $stmt->bindParam(':estimated_time', $estimated_time, PDO::PARAM_INT);
     $stmt->bindParam(':requires_appointment', $requires_appointment, PDO::PARAM_INT);
     $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
    }
     $stmt->bindParam(':is_show', $is_show, PDO::PARAM_INT);
     $stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
 
     if ($stmt->execute()) {
         header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
             . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=services');
         exit();
     } else {
         echo 'Lỗi khi cập nhật dịch vụ.';
     }
 }
 
 // Load template
 $xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/services/');
 $xtpl->assign('SERVICE', $service);
 $xtpl->assign('SAVE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
     . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=services/edit&id=' . $service_id);
 $xtpl->parse('edit');
 $contents = $xtpl->text('edit');
 
 include NV_ROOTDIR . '/includes/header.php';
 echo nv_admin_theme($contents);
 include NV_ROOTDIR . '/includes/footer.php';
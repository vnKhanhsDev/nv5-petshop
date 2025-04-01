<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
$page_title = 'Thêm phụ kiện';

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessory_types';
$types = $db->query($sql)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $type_id = $_POST['type_id'] ?? 0;
    $brand = $_POST['brand'] ?? '';
    $material = $_POST['material'] ?? '';
    $origin = $_POST['origin'] ?? '';
    $expiration_date = $_POST['expiration_date'] ?? '';
    $color = $_POST['color'] ?? '' ;
    $size = $_POST['size'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $discount = $_POST['discount'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $tags = isset($_POST['tags']) ? implode(',', $_POST['tags']) : ''; // Chuyển mảng thành chuỗi
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    $is_show = $_POST['is_show'] ?? 0;
    $rating = 0; // Giá trị mặc định
    $created_at = time();
    $updated_at = time();
    if (!empty($name) && !empty($type_id) && !empty($brand) && !empty($material) && !empty($origin) && !empty($expiration_date) && !empty($color) && !empty($size) && !empty($price) && !empty($discount) && !empty($stock)) {
        $sql  = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_accessories
                (name, type_id, brand, material, origin, expiration_date, color, size, price, discount, stock, tags, rating, description, image, is_show, created_at, updated_at)
                VALUES 
                (:name, :type_id, :brand, :material, :origin, :expiration_date, :color, :size, :price, :discount, :stock, :tags, :rating, :description, :image, :is_show, :created_at, :updated_at)';
        // Thực hiện truy vấn
         $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':material', $material, PDO::PARAM_STR);
        $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
        $stmt->bindParam(':expiration_date', $expiration_date, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':is_show', $is_show, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=accessories');
            exit();
            
        } else {
            echo 'Lỗi khi thêm phụ kiện.';
        }
    } else {
        echo 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
    }
}

// Load giao diện add.tpl
$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/accessories/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

foreach ($types as $type_list) {
    $xtpl->assign('ID', $type_list['id']);
    $xtpl->assign('TYPE_NAME', htmlspecialchars($type_list['name']));
    $xtpl->parse('main.type');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
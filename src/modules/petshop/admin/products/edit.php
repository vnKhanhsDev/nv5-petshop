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

$page_title = 'Sửa thông tin sản phẩm';

$product_id = $_GET['id'] ?? 0;

if ($product_id > 0) {
    // Lấy thông tin sản phẩm từ database
    $stmt = $db->prepare('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_products WHERE id = :id');
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();

    if (!$product) {
        die('Sản phẩm không tồn tại.');
    }
} else {
    die('ID sản phẩm không hợp lệ.');
}

// Nếu người dùng submit form (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $status = intval($_POST['status']);

    if ($name == '' || $price <= 0 || $quantity < 0) {
        die('Dữ liệu không hợp lệ.');
    }

    // Cập nhật sản phẩm vào database
    $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_products 
        SET name = :name, price = :price, quantity = :quantity, status = :status 
        WHERE id = :id');

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
            . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=products');
        exit();
    } else {
        echo 'Lỗi khi cập nhật sản phẩm.';
    }
}

// Load template
$xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/products/');
$xtpl->assign('PRODUCT', $product);
$xtpl->assign('SAVE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
    . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=products/edit&id=' . $product_id);
$xtpl->parse('edit');
$contents = $xtpl->text('edit');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
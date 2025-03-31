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

$page_title = 'Thêm sản phẩm';

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_species';
$specie_list = $db->query($sql)->fetchAll();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_breeds';
$breeds = $db->query($sql)->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $specie_id = $_POST['specie_id'] ?? 0;
    $breed_id = $_POST['breed_id'] ?? 0;
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? 0;
    $fur_color = $_POST['fur_color'] ?? '';
    $weight = $_POST['weight'] ?? 0;
    $origin = $_POST['origin'] ?? '';
    $is_vaccinated = $_POST['is_vaccinated'] ?? 0;
    $vaccination_details = $_POST['vaccination_details'] ?? '';
    $price = $_POST['price'] ?? 0;
    $discount = $_POST['discount'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    $status = $_POST['status'] ?? 0;
    $created_at = time();
    $updated_at = time();

    // if (!empty($name) && !empty($category_id)) {
    //     $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_products 
    //         (name, category_id, price, quantity, image, description, status, created_at, updated_at) 
    //         VALUES (:name, :category_id, :price, :quantity, :image, :description, :status, :created_at, :updated_at)');

    //     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    //     $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    //     $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    //     $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    //     $stmt->bindParam(':image', $image, PDO::PARAM_STR);
    //     $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    //     $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    //     $stmt->bindParam(':created_at', $created_at, PDO::PARAM_INT);
    //     $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);

    //     if ($stmt->execute()) {
    //         header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA 
    //             . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=products');
    //         exit();
    //     } else {
    //         echo 'Lỗi khi thêm sản phẩm.';
    //     }
    // } else {
    //     echo 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
    // }
}

// Load giao diện add.tpl
$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

foreach ($specie_list as $specie) {
    $xtpl->assign('SPECIE_ID', $specie['id']);
    $xtpl->assign('SPECIE_NAME', htmlspecialchars($specie['name']));
    $xtpl->parse('main.specie');
}

foreach ($breeds as $breed) {
    $xtpl->assign('BREED_ID', $breed['id']);
    $xtpl->assign('BREED_NAME', htmlspecialchars($breed['name']));
    $xtpl->assign('SPECIE_ID', $breed['species_id']); // Thêm SPECIE_ID để lọc sau này
    $xtpl->parse('main.breed');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
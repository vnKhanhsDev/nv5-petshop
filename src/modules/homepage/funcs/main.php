<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_PAGE')) {
    exit('Stop!!!');
}


$contents = "Trang chủ";

$xtpl = new XTemplate('homepage.tpl', NV_ROOTDIR . '/themes/default/modules/' . $module_file);
// echo NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file;
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

//Lấy dữ liệu thú cưng mới
$module_petshop = 'petshop'; // Tên module quản lý thú cưng

$sql = "SELECT * 
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_pets 
        WHERE FIND_IN_SET('new', tags) > 0 AND is_show = 1 
        ORDER BY created_at DESC 
        LIMIT 8";

$_row = $db->query($sql)->fetchAll(); // Lấy tất cả dữ liệu từ truy vấn

foreach ($_row as $pet) {  // Duyệt từng dòng dữ liệu đúng
    $pet['price_discount'] = $pet['price'] * (1 - $pet['discount'] / 100);
    $xtpl->assign('PET', $pet);
    $xtpl->parse('main.pet');
}

//Láy dữ liệu phụ kiện mới nhât
$sql = "SELECT *
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_accessories 
        WHERE FIND_IN_SET('new', tags) > 0 AND is_show = 1 
        ORDER BY created_at DESC 
        LIMIT 8";

$result = $db->query($sql);
$accessories = $result->fetchAll();

foreach ($accessories as &$accessory) {
    $accessory['price_discount'] = $accessory['price'] * (1 - $accessory['discount'] / 100);
    $xtpl->assign('ACCESSORY', $accessory);
    $xtpl->parse('main.accessory');
}

//Lấy dự liệu dịch vụ mới
$sql = "SELECT * 
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_services
        WHERE is_show = 1  
        ORDER BY created_at DESC  
        LIMIT 8";
$result = $db->query($sql);
$services = $result->fetchAll();

foreach ($services as $service) {
    $service['price_discount'] = $service['price'] * (1 - $service['discount'] / 100);
    $service['requires_appointment_text'] = ($service['requires_appointment'] == 1) ? 'Có' : 'Không';
    $xtpl->assign('SERVICE', $service);
    $xtpl->parse('main.service');
}

//Lấy dữ liệu thú cưng được đánh giá cao
$sql = "SELECT * 
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_pets 
        WHERE FIND_IN_SET('best-seller', tags) > 0 AND is_show = 1 
        ORDER BY created_at DESC 
        LIMIT 8";

$result = $db->query($sql);
$hot_pets = $result->fetchAll();

foreach ($hot_pets as &$hot_pet) {
    $hot_pet['price_discount'] = $hot_pet['price'] * (1 - $hot_pet['discount'] / 100);
    $xtpl->assign('HOT_PET', $hot_pet);
    $xtpl->parse('main.hotPet');
}

//Lấy dữ liệu dịch vụ có đánh giá cao
$sql = "SELECT *
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_accessories 
        WHERE FIND_IN_SET('best-seller', tags) > 0 AND is_show = 1 
        ORDER BY created_at DESC 
        LIMIT 8";

$result = $db->query($sql);
$hot_services = $result->fetchAll();

foreach ($hot_services as &$hot_service) {
    $hot_service['price_discount'] = $hot_service['price'] * (1 - $hot_service['discount'] / 100);
    $hot_service['appointment_text'] = $hot_service['requires_appointment'] ? "Cần đặt trước" : "Không cần đặt trước";
    $xtpl->assign('HOT_SERVICE', $hot_service);
    $xtpl->parse('main.hotService');
}

//Lấy dữ liệu bài đăng mới
$sql = "SELECT id, title, description, image, views, likes, created_at  
        FROM " . NV_PREFIXLANG . "_" . $module_petshop . "_posts  
        WHERE status = 1  
        ORDER BY created_at DESC  
        LIMIT 6";

$result = $db->query($sql);

$posts = $result->fetchAll();
foreach ($posts as &$post) {
    $post['formatted_date'] = date('d/m/Y', $post['created_at']);
    $post['short_description'] = mb_strimwidth($post['description'], 0, 100, '...');
    $xtpl->assign('POST', $post);
    $xtpl->parse('main.post');
}



$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
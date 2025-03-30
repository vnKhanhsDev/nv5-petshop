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

$page_title = $nv_Lang->getModule('product_list');

$page = $nv_Request->get_int('page', 'get', 1);
$per_page = 10;
$offset = ($page - 1) * $per_page;  // Vị trí bắt đầu lấy dữ liệu

// Lấy tổng số sản phẩm (Số dòng dữ liệu)
$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_products';
$total_rows = $db->query($sql)->fetchColumn();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_products ORDER BY id DESC LIMIT ' . $offset . ', ' . $per_page;

$_rows = $db->query($sql)->fetchAll();
$num = count($_rows);

// Tạo URL phân trang
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=products';
$generate_page = nv_generate_page($base_url, $total_rows, $per_page, $page);

$xtpl = new XTemplate('products.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ADD_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=products/add');

if (!empty($_rows)) {
    foreach ($_rows as $row) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
} else {
    $contents = "Không có sản phẩm";
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

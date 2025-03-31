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

$page_title = $nv_Lang->getModule('Quản lý phụ kiện');

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=accessories';

// Lấy tổng số sản phẩm (Số dòng dữ liệu)
$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories';
$total_rows = $db->query($sql)->fetchColumn(); 

// Số dòng dữ liệu trên một trang
$per_page = 10;

// Lấy trang hiện tại
$page = $nv_Request->get_int('page', 'get', 1);

// Tạo URL phân trang
$generate_page = nv_generate_page($base_url, $total_rows, $per_page, $page);

// Lấy dữ liệu fill vào trang hiện tại
$offset = ($page - 1) * $per_page;  // Vị trí bắt đầu lấy dữ liệu
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories ORDER BY id DESC LIMIT ' . $offset . ', ' . $per_page;
$_rows = $db->query($sql)->fetchAll();

$xtpl = new XTemplate('accessories.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ADD_URL', $base_url . '/add');

if (!empty($_rows)) {
    foreach ($_rows as $row) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
} else {
    $contents = "Không có phụ kiện";
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
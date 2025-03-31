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

$page_title = $nv_Lang->getModule('services');

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_services ORDER BY id DESC';
 $_rows = $db->query($sql)->fetchAll();
 $num = count($_rows);
 
 $xtpl = new XTemplate('services.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
 // echo NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file;
 $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
 $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
 
//  $add_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=products/add';
//  $xtpl->assign('ADD_URL', $add_url);
 
 if ($num) {
    foreach ($_rows as $key => $row) {
        // Xử lý trạng thái trước khi gán vào template
        $row['status_text'] = ($row['status'] == 1) ? 'Hoạt động' : 'Dừng hoạt động';

        // Gán dữ liệu vào template
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
 } else {
     $contents = "Không có sản phẩm";
 }

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
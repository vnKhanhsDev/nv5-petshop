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

$page_title = $nv_Lang->getModule('pet_list');

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=pets';

$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_pets';
$total_rows = (int) $db->query($sql)->fetchColumn();

// Tạo template
$xtpl = new XTemplate('pets.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ADD_URL', $base_url . '/add');

if ($total_rows === 0) {
    $xtpl->parse('empty');
    $contents = $xtpl->text('empty');
} else {
    // Số dòng dữ liệu trên một trang
    $per_page = 10;
    $page = max(1, $nv_Request->get_int('page', 'get', 1));

    // Lấy dữ liệu danh sách thú cưng
    $offset = ($page - 1) * $per_page;

    $sql = 'SELECT p.*, s.name AS specie_name, b.name AS breed_name 
        FROM ' . NV_PREFIXLANG . '_' . $module_data . '_pets p
        INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_species s ON p.species_id = s.id
        INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_breeds b ON p.breed_id = b.id
        ORDER BY p.id DESC LIMIT :offset, :per_page';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    $_rows = $stmt->fetchAll();

    foreach ($_rows as $row) {
        $row['detail_url'] = $base_url . '/detail&id=' . $row['id'];
        $row['edit_url'] = $base_url . '/edit&id=' . $row['id'];
        $row['delete_url'] = $base_url . '/delete&id=' . $row['id'];

        $row['gender'] = $row['gender'] === 'male' ? 'Đực' : 'Cái';
        $row['status'] = $row['status'] === 1 ? 'Hiện' : 'Ẩn';
        $row['price'] = number_format($row['price'], 0, ',', '.');

        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }

    // Tạo phân trang
    $xtpl->assign('GENERATE_PAGE', nv_generate_page($base_url, $total_rows, $per_page, $page));
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
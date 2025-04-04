<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

// Lấy tất cả các loại phụ kiện
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessory_types';
$types = $db->query($sql)->fetchAll();

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

// Lấy dữ liệu fill vào trang hiện tại với join bảng _accessories và _accessory_types
$offset = ($page - 1) * $per_page;  // Vị trí bắt đầu lấy dữ liệu
$sql = 'SELECT a.*, t.name AS type_name 
        FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories a
        LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_accessory_types t ON a.type_id = t.id
        ORDER BY a.id DESC LIMIT ' . $offset . ', ' . $per_page;

$_rows = $db->query($sql)->fetchAll();

$xtpl = new XTemplate('accessories.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ADD_URL', $base_url . '/add');
$xtpl->assign('DETAIL_URL', $base_url . '/detail');
$xtpl->assign('DELETE_URL', $base_url . '/delete');
$xtpl->assign('EDIT_URL', $base_url . '/edit');

if (!empty($_rows)) {
    foreach ($_rows as $row) {
        $row['DETAIL_URL'] = $base_url . '/detail&id=' . $row['id'];
        $row['DELETE_URL'] = $base_url . '/delete&id=' . $row['id'];
        $row['EDIT_URL'] = $base_url . '/edit&id=' . $row['id'];

        // Thêm type_name vào mỗi dòng
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
} else {
    $contents = "Không có dữ liệu về phụ kiện";
}

// Truyền tất cả loại phụ kiện vào template
foreach ($types as $type_list) {
    $xtpl->assign('ID', $type_list['id']);
    $xtpl->assign('TYPE_NAME', htmlspecialchars($type_list['name']));
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
?>

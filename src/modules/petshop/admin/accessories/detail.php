<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = 'Chi tiết phụ kiện';

$accessories_id = $_GET['id'] ?? 0;
$accessories_id = intval($accessories_id);

// Kiểm tra ID phụ kiện
if ($accessories_id <= 0) {
    die('ID phụ kiện không hợp lệ.');
}

// Lấy thông tin về các loại phụ kiện
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessory_types';
$types = $db->query($sql)->fetchAll();

// Lấy thông tin chi tiết phụ kiện
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $accessories_id, PDO::PARAM_INT);
$stmt->execute();
$accessories = $stmt->fetch();

// Kiểm tra phụ kiện tồn tại
if (!$accessories) {
    die('Không tìm thấy phụ kiện.');
}

// Chọn tên loại phụ kiện dựa trên type_id
$type_name = '';
foreach ($types as $type_list) {
    if ($type_list['id'] == $accessories['type_id']) {
        $type_name = $type_list['name'];
        break;
    }
}

// Khởi tạo template
$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/accessories/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

// Truyền thông tin vào template
$xtpl->assign('TYPE_NAME', htmlspecialchars($type_name));
$xtpl->assign('accessories', $accessories);
$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . '/includes/header.php');
echo nv_admin_theme($contents);
include (NV_ROOTDIR . '/includes/footer.php');
?>

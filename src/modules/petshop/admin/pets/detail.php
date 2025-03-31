<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = 'Chi tiết thú cưng';

$pet_id = $_GET['id'] ?? 0;
$pet_id = intval($pet_id);

if ($pet_id <= 0) {
    die('ID thú cưng không hợp lệ.');
}

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_pets WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $pet_id, PDO::PARAM_INT);
$stmt->execute();
$pet = $stmt->fetch();

if (!$pet) {
    die('Không tìm thấy thú cưng.');
}

$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('PET', $pet);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . '/includes/header.php');
echo nv_admin_theme($contents);
include (NV_ROOTDIR . '/includes/footer.php');
<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('detail_pet');

$pet_id = intval($_GET['id'] ?? 0);

if ($pet_id <= 0) {
    die('ID thú cưng không hợp lệ.');
}

$sql = 'SELECT
            p.*,
            s.name AS specie_name,
            b.name AS breed_name
        FROM ' . NV_PREFIXLANG . '_' . $module_data . '_pets p
        LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_species s ON p.species_id = s.id
        LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_breeds b ON p.breed_id = b.id
        WHERE p.id = :id';

$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $pet_id, PDO::PARAM_INT);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    die('Không tìm thấy thú cưng.');
}

$images = !empty($pet['images']) ? explode(',', $pet['images']) : [];

$xtpl = new XTemplate('pet_form.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('PET', $pet);
$xtpl->assign('PET_ID', $pet['id']);
$xtpl->assign('ACTION', 'detail');

$xtpl->assign('IMAGE_LIST', ''); // Khởi tạo giá trị trống

if (!empty($images)) {
    foreach ($images as $image) {
        $xtpl->assign('IMAGE_SRC', NV_BASE_SITEURL . $image);
        $xtpl->parse('main.image'); // Parse block image
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . '/includes/header.php');
echo nv_admin_theme($contents);
include (NV_ROOTDIR . '/includes/footer.php');
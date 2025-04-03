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

// Lấy danh sách loài và giống
$sql = 'SELECT id, name FROM ' . NV_PREFIXLANG . '_' . $module_data . '_species';
$_species = $db->query($sql)->fetchAll();

$sql = 'SELECT id, name, species_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_breeds';
$breeds = $db->query($sql)->fetchAll();

if (!$pet) {
    die('Không tìm thấy thú cưng.');
}

$images = !empty($pet['images']) ? explode(',', $pet['images']) : [];

$xtpl = new XTemplate('pet_form.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$pet['created_at'] = date('d-m-Y H:i:s', $pet['created_at']);
$pet['updated_at'] = date('d-m-Y H:i:s', $pet['updated_at']);

$xtpl->assign('PET', $pet);
$xtpl->assign('PET_ID', $pet['id']);
$xtpl->assign('ACTION', 'detail');

$xtpl->assign('IMAGE_LIST', ''); // Khởi tạo giá trị trống

$images = explode(',', $pet['images']);
foreach($images as $image) {
    $xtpl->assign('IMAGE_URL', $image);
    $xtpl->parse('main.images');
}

foreach ($_species as $species) {
    $xtpl->assign('SPECIES_ID', $species['id']);
    $xtpl->assign('SPECIES_NAME', $species['name']);
    $xtpl->parse('main.species');
}

foreach ($breeds as $breed) {
    $xtpl->assign('BREED_ID', $breed['id']);
    $xtpl->assign('BREED_NAME', $breed['name']);
    $xtpl->assign('SPECIES_ID', $breed['species_id']);
    $xtpl->parse('main.breed');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . '/includes/header.php');
echo nv_admin_theme($contents);
include (NV_ROOTDIR . '/includes/footer.php');
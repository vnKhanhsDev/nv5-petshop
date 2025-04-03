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

$page_title = "Sửa thông tin thú cưng";

$pet_id = intval($_GET['id'] ?? 0);

if ($pet_id <= 0) {
    die('ID thú cưng không hợp lệ.');
}

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_species';
$specie_list = $db->query($sql)->fetchAll();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_breeds';
$breeds = $db->query($sql)->fetchAll();

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

$xtpl = new XTemplate('pet_form.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('PET', $pet);
$xtpl->assign('PET_ID', $pet['id']);
$xtpl->assign('ACTION', 'edit');

foreach ($specie_list as $specie) {
    $xtpl->assign('SPECIE_ID', $specie['id']);
    $xtpl->assign('SPECIE_NAME', htmlspecialchars($specie['name']));
    $xtpl->parse('main.specie');
}

foreach ($breeds as $breed) {
    $xtpl->assign('BREED_ID', $breed['id']);
    $xtpl->assign('BREED_NAME', htmlspecialchars($breed['name']));
    $xtpl->assign('SPECIE_ID', $breed['species_id']); // Thêm SPECIE_ID để lọc sau này
    $xtpl->parse('main.breed');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . '/includes/header.php');
echo nv_admin_theme($contents);
include (NV_ROOTDIR . '/includes/footer.php');
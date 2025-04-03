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

// Lấy danh sách loài và giống
$sql = 'SELECT id, name FROM ' . NV_PREFIXLANG . '_' . $module_data . '_species';
$_species = $db->query($sql)->fetchAll();

$sql = 'SELECT id, name, species_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_breeds';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $species_id = $_POST['species_id'] ?? 0;
    $breed_id = $_POST['breed_id'] ?? 0;
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? 0;
    $fur_color = $_POST['fur_color'] ?? '';
    $weight = $_POST['weight'] ?? 0;
    $origin = $_POST['origin'] ?? '';
    $is_vaccinated = $_POST['is_vaccinated'] ?? 0;
    $vaccination_details = $_POST['vaccination_details'] ?? '';
    $price = $_POST['price'] ?? 0;
    $discount = $_POST['discount'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $tags = isset($_POST['tags']) ? implode(',', $_POST['tags']) : '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 0;
    $updated_at = time();

    // Kiểm tra dữ liệu bắt buộc
    if (empty($name) || $species_id == 0 || $breed_id == 0) {
        echo 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
        exit();
    }

    // Xử lý cập nhật hình ảnh
    $image_urls = explode(',', $pet['images']); // Giữ lại hình ảnh cũ nếu không có ảnh mới
    if (!empty($_FILES['image']['name'][0])) {
        $upload_dir = NV_ROOTDIR . '/uploads/' . $module_name . '/pets/';
        foreach ($_FILES['image']['name'] as $key => $filename) {
            $tmp_name = $_FILES['image']['tmp_name'][$key];
            $new_name = uniqid() . '_' . basename($filename);
            $target_file = $upload_dir . $new_name;
            if (move_uploaded_file($tmp_name, $target_file)) {
                $image_urls[] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/pets/' . $new_name;
            }
        }
    }
    $images = implode(',', $image_urls);

    // Câu lệnh UPDATE thay vì INSERT
    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_pets SET 
                name = :name,
                species_id = :species_id,
                breed_id = :breed_id,
                gender = :gender,
                age = :age,
                fur_color = :fur_color,
                weight = :weight,
                origin = :origin,
                is_vaccinated = :is_vaccinated,
                vaccination_details = :vaccination_details,
                price = :price,
                discount = :discount,
                stock = :stock,
                tags = :tags,
                description = :description,
                images = :images,
                status = :status,
                updated_at = :updated_at
            WHERE id = :id';

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $pet_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':species_id', $species_id, PDO::PARAM_INT);
    $stmt->bindParam(':breed_id', $breed_id, PDO::PARAM_INT);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':fur_color', $fur_color, PDO::PARAM_STR);
    $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
    $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
    $stmt->bindParam(':is_vaccinated', $is_vaccinated, PDO::PARAM_INT);
    $stmt->bindParam(':vaccination_details', $vaccination_details, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':images', $images, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=pets');
        exit();
    } else {
        echo 'Lỗi khi cập nhật thông tin thú cưng.';
    }
}

$xtpl = new XTemplate('pet_form.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/pets/');
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('PET', $pet);
$xtpl->assign('PET_ID', $pet['id']);
$xtpl->assign('ACTION', 'edit');

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
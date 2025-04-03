<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = 'Sửa phụ kiện';

// Lấy dữ liệu loại phụ kiện từ cơ sở dữ liệu
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessory_types';
$types = $db->query($sql)->fetchAll();

// Kiểm tra nếu có ID phụ kiện trong URL
if (isset($_GET['id'])) {
    $accessory_id = intval($_GET['id']); // Lấy ID từ URL và chuyển thành số nguyên

    // Lấy thông tin phụ kiện từ cơ sở dữ liệu
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_accessories WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $accessory_id, PDO::PARAM_INT);
    $stmt->execute();
    $accessory = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nếu không tìm thấy phụ kiện, hiển thị lỗi và dừng script
    if (!$accessory) {
        die('Phụ kiện không tồn tại.');
    }
} else {
    die('ID phụ kiện không được cung cấp.');
}

// Xử lý khi người dùng nhấn "Cập nhật"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $image_path = '';
    $upload = new NukeViet\Files\Upload(
            $admin_info['allow_files_type'], 
            $global_config['forbid_extensions'], 
            $global_config['forbid_mimes'], 
            NV_UPLOAD_MAX_FILESIZE, 
            NV_MAX_WIDTH, 
            NV_MAX_HEIGHT
        );

        // Thiết lập ngôn ngữ
        $upload->setLanguage($lang_global);

        // Xác định thư mục lưu ảnh
        $target_dir = NV_UPLOADS_REAL_DIR . '/' . $module_name . '/accessories/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có
        }

        // Tải file lên server
        $upload_info = $upload->save_file($_FILES['image'], $target_dir, false, $global_config['nv_auto_resize']);

        // Kiểm tra lỗi upload
        if (!empty($upload_info['error'])) {
            die('Lỗi upload file: ' . $upload_info['error']);
        } else {
            // Đường dẫn ảnh đã upload
            $image_path = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/accessories/' . $upload_info['basename'];
        }
    $name = $_POST['name'] ?? '';
    $type_id = $_POST['type_id'] ?? 0;
    $brand = $_POST['brand'] ?? '';
    $material = $_POST['material'] ?? '';
    $origin = $_POST['origin'] ?? '';
    $expiration_date = $_POST['expiration_date'] ?? '';
    if (empty($expiration_date)) {
        $expiration_date = null; // Nếu trống, gán giá trị NULL
    }
    $color = $_POST['color'] ?? '';
    $size = $_POST['size'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $discount = $_POST['discount'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $tags = isset($_POST['tags']) ? implode(',', $_POST['tags']) : ''; // Chuyển mảng thành chuỗi
    $description = $_POST['description'] ?? '';
    $image = $image_path ?? ''; // Nếu không có ảnh mới, giữ nguyên ảnh cũ
    $is_show = $_POST['is_show'] ?? 0;
    $updated_at = time(); // Thời gian cập nhật

    // Kiểm tra các trường bắt buộc và nếu có thay đổi
    $fieldsChanged = false;
    if ($name !== $accessory['name']) $fieldsChanged = true;
    if ($type_id !== $accessory['type_id']) $fieldsChanged = true;
    if ($brand !== $accessory['brand']) $fieldsChanged = true;
    if ($material !== $accessory['material']) $fieldsChanged = true;
    if ($origin !== $accessory['origin']) $fieldsChanged = true;
    if ($expiration_date !== $accessory['expiration_date']) $fieldsChanged = true;
    if ($color !== $accessory['color']) $fieldsChanged = true;
    if ($size !== $accessory['size']) $fieldsChanged = true;
    if ($price !== $accessory['price']) $fieldsChanged = true;
    if ($discount !== $accessory['discount']) $fieldsChanged = true;
    if ($stock !== $accessory['stock']) $fieldsChanged = true;
    if ($tags !== $accessory['tags']) $fieldsChanged = true;
    if ($description !== $accessory['description']) $fieldsChanged = true;
    if ($image !== $accessory['image']) $fieldsChanged = true;
    if ($is_show !== $accessory['is_show']) $fieldsChanged = true;

    // Nếu có thay đổi dữ liệu, tiến hành cập nhật
    if ($fieldsChanged) {
        $sql  = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_accessories
                SET name = :name, type_id = :type_id, brand = :brand, material = :material, origin = :origin, expiration_date = :expiration_date, 
                    color = :color, size = :size, price = :price, discount = :discount, stock = :stock, tags = :tags, description = :description, 
                    image = :image, is_show = :is_show, updated_at = :updated_at
                WHERE id = :id';
        
        // Thực hiện truy vấn cập nhật
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':material', $material, PDO::PARAM_STR);
        $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
        $stmt->bindParam(':expiration_date', $expiration_date, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':is_show', $is_show, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_INT);
        $stmt->bindParam(':id', $accessory_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=accessories');
            exit();
        } else {
            echo 'Lỗi khi sửa phụ kiện.';
        }
    } else {
        echo 'Không có thay đổi nào để cập nhật.';
    }
}

// Load giao diện edit.tpl
$xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/accessories/');

// Điền thông tin loại phụ kiện vào form
foreach ($types as $type_list) {
    // Gán các giá trị cần thiết vào template
    $xtpl->assign('ID', $type_list['id']);
    $xtpl->assign('TYPE_NAME', htmlspecialchars($type_list['name']));
    // Kiểm tra nếu type_id của phụ kiện trùng với id của loại phụ kiện
    // Nếu trùng thì gán 'selected' cho thẻ option
    $xtpl->assign('SELECTED', $accessory['type_id'] == $type_list['id'] ? 'selected' : '');
    
    // Parse phần type trong template
    $xtpl->parse('main.type');
}
    
// Chia chuỗi tags thành mảng

$type_name = '';
foreach ($types as $type_list) {
    if ($type_list['id'] == $accessory['type_id']) {
        $type_name = $type_list['name']; // Lấy type_name tương ứng với type_id
        break; // Thoát khỏi vòng lặp khi tìm thấy
    }
}
$xtpl->assign('name', $accessory['name']);  
$xtpl->assign('type_id', $accessory['type_id']); 
$xtpl->assign('type_name', htmlspecialchars($type_name)); 
$xtpl->assign('brand', $accessory['brand']);
$xtpl->assign('origin', $accessory['origin']);
$xtpl->assign('material', $accessory['material']);
$xtpl->assign('expiration_date', $accessory['expiration_date'] ?? ''); 
$xtpl->assign('color', $accessory['color']);
$xtpl->assign('size', $accessory['size']);
$xtpl->assign('price', $accessory['price']);
$xtpl->assign('discount', $accessory['discount']);
$xtpl->assign('stock', $accessory['stock']);
$xtpl->assign('description', $accessory['description']);
$xtpl->assign('image', $accessory['image']);
$xtpl->assign('is_show', $accessory['is_show']);
$xtpl->assign('tags', $accessory['tags']);
$xtpl->assign('ACCESSORY', $accessory);  

// Parse giao diện
$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>

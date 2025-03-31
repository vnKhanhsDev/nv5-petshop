<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

header('Content-Type: application/json');

require NV_ROOTDIR . '/includes/core/user_functions.php'; // Đảm bảo NV_PREFIXLANG hoạt động

global $db; // Đảm bảo biến $db có thể sử dụng

$order_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

if ($order_id > 0 && !empty($status)) {
    // Kiểm tra xem đơn hàng có tồn tại không
    $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_petshop_orders WHERE id = :id');
    $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetch()) {
        // Cập nhật trạng thái đơn hàng
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_petshop_orders SET status = :status WHERE id = :id');
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Không thể cập nhật trạng thái"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Đơn hàng không tồn tại"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
}

exit();

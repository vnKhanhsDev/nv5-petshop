<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

header('Content-Type: application/json');

$order_id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';

$order_id = (int) $order_id;
$status = trim($status);

if ($order_id > 0 && !empty($status)) {
    // Kiểm tra xem đơn hàng có tồn tại không
    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_petshop_orders WHERE id = :id');
    $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        // Cập nhật trạng thái đơn hàng
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_petshop_orders SET status = :status WHERE id = :id');
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật trạng thái"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Đơn hàng không tồn tại"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
}

exit();
?>

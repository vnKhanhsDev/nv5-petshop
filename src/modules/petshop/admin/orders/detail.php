<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

// Nhận ID đơn hàng từ URL
$order_id = $nv_Request->get_int('id', 'get', 0);

if ($order_id <= 0) {
    die('Lỗi: ID đơn hàng không hợp lệ.');
}

// Truy vấn lấy thông tin đơn hàng từ bảng `nv5_vi_petshop_orders`
$sql = "SELECT * FROM nv5_vi_petshop_orders WHERE id = :order_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch();

if (!$order) {
    die('Lỗi: Không tìm thấy đơn hàng với ID ' . $order_id);
}

// Xác định template
$template = isset($module_info['template']) ? $module_info['template'] : 'admin_default';
$xtpl = new XTemplate('orders_detail.tpl', NV_ROOTDIR . "/themes/$template/modules/petshop");

// Gán dữ liệu đơn hàng vào template
$order['created_at'] = date('d/m/Y H:i', strtotime($order['created_at']));
$order['updated_at'] = date('d/m/Y H:i', strtotime($order['updated_at']));
$order['total_price'] = number_format($order['total_price'], 0, ',', '.') . ' VNĐ';
$order['url_detail'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=petshop&op=orders/detail&id=" . $order['id'];
$order['url_delete'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=petshop&op=orders/delete&id=" . $order['id'];
$order['back_url'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=petshop&op=orders"; // Quay lại danh sách

$xtpl->assign('ORDER', $order);

// Hiển thị template
$xtpl->parse('main');
$page_title = "Chi tiết đơn hàng #" . $order['order_code'];
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

?>

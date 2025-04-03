<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

global $db, $module_name, $module_file, $op;

// Lấy danh sách đơn hàng từ database
$sql = "SELECT id, order_code, customer_name, created_at, status, product_name, quantity FROM " . NV_PREFIXLANG . "_petshop_orders ORDER BY id ASC";
$result = $db->query($sql);
$orders = $result->fetchAll(PDO::FETCH_ASSOC); // Đảm bảo lấy dữ liệu dạng mảng liên kết

// Load template
$xtpl = new XTemplate("orders.tpl", NV_ROOTDIR . "/themes/admin_default/modules/petshop/");

foreach ($orders as $order) {
    // Chuyển đổi định dạng ngày
    $order['created_at'] = nv_date('d/m/Y', strtotime($order['created_at']));

    // Định dạng trạng thái hiển thị (nếu có trạng thái cụ thể)
    switch ($order['status']) {
        case 'pending':
            $order['status_text'] = 'Đang xử lý';
            break;
        case 'completed':
            $order['status_text'] = 'Hoàn thành';
            break;
        case 'cancelled':
            $order['status_text'] = 'Đã hủy';
            break;
        default:
            $order['status_text'] = $order['status']; // Nếu không có trạng thái đặc biệt, giữ nguyên
    }

    $order['url_detail'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders/detail&id=" . $order['id'];
    $order['url_delete'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders/delete&id=" . $order['id'];
    $order['url_update'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders/update&id=" . $order['id'];
    $order['url_edit'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders/edit&id=" . $order['id'];

    $xtpl->assign("ORDER", $order);
    $xtpl->parse("main.order");
}

$xtpl->parse("main");
$page_title = "Danh sách đơn hàng";
$contents = $xtpl->text("main");

include NV_ROOTDIR . "/includes/header.php";
echo nv_admin_theme($contents);
include NV_ROOTDIR . "/includes/footer.php";


?>

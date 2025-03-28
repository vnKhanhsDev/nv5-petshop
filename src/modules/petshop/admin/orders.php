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

global $db, $module_name, $module_file, $op;

// Xử lý xóa đơn hàng
if ($op == 'delete_order' && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    
    $sql = "DELETE FROM nv5_petshop_orders WHERE id = :order_id";
    $query = $db->prepare($sql);
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query->execute();
    
    header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders");
    exit();
}

// Nếu có tham số ID trong URL (trang chi tiết đơn hàng)
if ($op == 'orders_detail' && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // Truy vấn lấy thông tin đơn hàng
    $sql = "SELECT * FROM nv5_petshop_orders WHERE id = :order_id";
    $query = $db->prepare($sql);
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query->execute();
    $order = $query->fetch();

    if (!$order) {
        die("Không tìm thấy đơn hàng.");
    }

    // Truy vấn danh sách sản phẩm trong đơn hàng
    $sql = "SELECT * FROM nv5_petshop_order_items WHERE order_id = :order_id";
    $query = $db->prepare($sql);
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query->execute();
    $products = $query->fetchAll();

    // Khởi tạo template chi tiết đơn hàng
    $xtpl = new XTemplate("orders_detail.tpl", NV_ROOTDIR . "/themes/admin_default/modules/petshop/");

    // Gán dữ liệu vào template
    $xtpl->assign("ORDER", $order);
    $xtpl->assign("CREATED_AT", nv_date('d/m/Y', strtotime($order['created_at'])));
    $xtpl->assign("STATUS", htmlspecialchars($order['status']));

    foreach ($products as $product) {
        $xtpl->assign("PRODUCT", $product);
        $xtpl->assign("TOTAL_PRICE", number_format($product['price'] * $product['quantity']));
        $xtpl->parse("main.product");
    }

    $xtpl->parse("main");
    $contents = $xtpl->text("main");

    include NV_ROOTDIR . "/includes/header.php";
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . "/includes/footer.php";
    exit();
}

// Nếu không phải trang chi tiết, hiển thị danh sách đơn hàng
$sql = "SELECT * FROM nv5_petshop_orders ORDER BY id DESC";
$result = $db->query($sql);
$orders = $result->fetchAll();

// Khởi tạo template danh sách đơn hàng
$xtpl = new XTemplate("orders.tpl", NV_ROOTDIR . "/themes/admin_default/modules/petshop/");

if (!empty($orders)) {
    foreach ($orders as &$order) {
        $order['created_at'] = nv_date('d/m/Y', strtotime($order['created_at']));
        $order['url_detail'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=orders_detail&id=" . $order['id'];
        $order['url_delete'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=delete_order&id=" . $order['id'];
        $xtpl->assign("ORDER", $order);
        $xtpl->parse("main.order");
    }
}

$xtpl->parse("main");
$page_title = "Danh sách đơn hàng";
$contents = $xtpl->text("main");

include NV_ROOTDIR . "/includes/header.php";
echo nv_admin_theme($contents);
include NV_ROOTDIR . "/includes/footer.php";

?>
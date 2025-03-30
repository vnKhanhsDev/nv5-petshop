<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$order_id = $_GET['id'] ?? 0;
$order_id = (int) $order_id;

if ($order_id <= 0) {
    die('ID không hợp lệ!');
}

// Lấy thông tin đơn hàng từ database
$sql = 'SELECT status FROM ' . NV_PREFIXLANG . '_petshop_orders WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch();

if (!$order) {
    die('Không tìm thấy đơn hàng!');
}

$status = $order['status'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái</title>
</head>
<body>
    <h2>Cập nhật trạng thái đơn hàng</h2>
    <form action="update_status.php" method="POST">
    <input type="hidden" name="id" value="<?= $order_id ?>">
    <label for="status">Chọn trạng thái:</label>
    <select name="status" id="status">
        <option value="Đang xử lý" <?= ($status == 'Đang xử lý') ? 'selected' : '' ?>>Đang xử lý</option>
        <option value="Đang giao hàng" <?= ($status == 'Đang giao hàng') ? 'selected' : '' ?>>Đang giao hàng</option>
        <option value="Đã hủy" <?= ($status == 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
        <option value="Đã giao thành công" <?= ($status == 'Đã giao thành công') ? 'selected' : '' ?>>Đã giao thành công</option>
    </select>
    
    <button type="submit">Lưu</button> <!-- Nút lưu phải nằm trong form -->
</form>

<!-- Link quay lại danh sách -->
<a href="orders.php">Quay lại danh sách</a>

</body>
</html>

<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_orders;';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_orders` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `order_code` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Mã đơn hàng',
    `customer_id` INT NOT NULL COMMENT 'ID khách hàng',
    `customer_name` VARCHAR(255) NOT NULL COMMENT 'Tên khách hàng',
    `customer_phone` VARCHAR(20) NOT NULL COMMENT 'Số điện thoại',
    `customer_email` VARCHAR(255) NOT NULL COMMENT 'Email khách hàng',
    `customer_address` TEXT NOT NULL COMMENT 'Địa chỉ giao hàng',
    `total_price` DECIMAL(10,2) NOT NULL COMMENT 'Tổng giá trị đơn hàng',
    `status` ENUM(
        'Đang xử lý',
        'Đã giao hàng',
        'Đã hủy',
        'Đã giao thành công'
    ) NOT NULL DEFAULT 'Đang xử lý' COMMENT 'Trạng thái đơn hàng',
    `payment_method` ENUM('COD', 'Bank Transfer', 'Paypal') NOT NULL COMMENT 'Phương thức thanh toán',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo đơn',
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách đơn hàng';";

// Chèn dữ liệu mẫu vào bảng đơn hàng
$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_orders` 
(`order_code`, `customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `total_price`, `status`, `payment_method`) VALUES
('ORD001', 1, 'Nguyễn Văn A', '0987654321', 'nguyenvana@example.com', 'Hà Nội, Việt Nam', 1500000, 'Đang xử lý', 'COD'),
('ORD002', 2, 'Trần Thị B', '0978123456', 'tranthib@example.com', 'Hồ Chí Minh, Việt Nam', 2500000, 'Đã giao hàng', 'Bank Transfer'),
('ORD003', 3, 'Lê Văn C', '0912345678', 'levanc@example.com', 'Đà Nẵng, Việt Nam', 1200000, 'Đã hủy', 'Paypal'),
('ORD004', 4, 'Phạm Thị D', '0908765432', 'phamthid@example.com', 'Cần Thơ, Việt Nam', 1750000, 'Đã giao thành công', 'COD'),
('ORD005', 5, 'Hoàng Văn E', '0923456789', 'hoangvane@example.com', 'Hải Phòng, Việt Nam', 950000, 'Đang xử lý', 'Bank Transfer');";

?>
<?php
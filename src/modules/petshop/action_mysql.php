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
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_services;';

$sql_create_module = $sql_drop_module;

// Thêm bảng dịch vụ
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_services` (
     `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã dịch vụ',
     `name` VARCHAR(255) NOT NULL COMMENT 'Tên dịch vụ',
     `price` DECIMAL(10,2) NOT NULL COMMENT 'Giá dịch vụ',
     `image` VARCHAR(255) NOT NULL COMMENT 'Đường dẫn ảnh dịch vụ',
     `description` TEXT NOT NULL COMMENT 'Mô tả dịch vụ',
     `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái. 0: ẩn - 1: hiện',
     `created_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tạo lúc',
     `updated_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Cập nhật gần nhất',
     PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách dịch vụ';";

//Thêm dữ liệu khởi tạo cho bảng dịch vụ
$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_services` 
(`name`, `price`, `image`, `description`, `status`, `created_at`, `updated_at`) 
VALUES
('Tắm cho thú cưng', 150000, 'uploads/bath.jpg', 'Dịch vụ tắm sạch sẽ cho chó mèo với dầu gội chuyên dụng.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cắt tỉa lông', 250000, 'uploads/haircut.jpg', 'Cắt tỉa lông theo yêu cầu, tạo kiểu cho thú cưng.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Trông giữ thú cưng', 500000, 'uploads/pet_hotel.jpg', 'Dịch vụ trông giữ thú cưng với không gian thoải mái, an toàn.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Khám sức khỏe định kỳ', 300000, 'uploads/health_check.jpg', 'Kiểm tra sức khỏe toàn diện cho thú cưng bởi bác sĩ thú y.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tiêm phòng', 200000, 'uploads/vaccine.jpg', 'Dịch vụ tiêm phòng các loại vaccine cần thiết cho thú cưng.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

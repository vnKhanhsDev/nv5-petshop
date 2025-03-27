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
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_products;';

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_products` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã sản phẩm',
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên sản phẩm',
    `category_id` INT NOT NULL COMMENT 'Mã danh mục sản phẩm',
    `price` DECIMAL(10,2) NOT NULL COMMENT 'Giá sản phẩm',
    `quantity` INT NOT NULL COMMENT 'Số lượng tồn kho',
    `image` VARCHAR(255) NOT NULL COMMENT 'Đường dẫn ảnh sản phẩm',
    `description` TEXT NOT NULL COMMENT 'Mô tả sản phẩm',
    `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái. 0: ẩn - 1: hiện',
    `created_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`),
    INDEX (`category_id`)
) ENGINE = InnoDB COMMENT = 'Danh sách sản phẩm';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_products` 
(`name`, `category_id`, `price`, `quantity`, `image`, `description`, `status`, `created_at`, `updated_at`) 
VALUES
('Chó Poodle nhỏ', 1, 5000000.00, 5, 'uploads/products/poodle.jpg', 'Chó Poodle lông xoăn màu nâu đỏ, 2 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Corgi chân ngắn', 1, 7000000.00, 3, 'uploads/products/corgi.jpg', 'Chó Corgi lông vàng trắng, dễ thương, 3 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Husky Siberian', 1, 9000000.00, 2, 'uploads/products/husky.jpg', 'Chó Husky thuần chủng, mắt xanh, 4 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Anh lông ngắn', 2, 4000000.00, 4, 'uploads/products/meo_anh_long_ngan.jpg', 'Mèo Anh lông ngắn màu xám xanh, dễ nuôi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Ba Tư lông dài', 2, 6000000.00, 3, 'uploads/products/meo_ba_tu.jpg', 'Mèo Ba Tư lông dài, lông trắng, mắt xanh.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Scottish tai cụp', 2, 7500000.00, 2, 'uploads/products/meo_scottish.jpg', 'Mèo Scottish tai cụp đáng yêu, phù hợp nuôi trong nhà.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Lồng vận chuyển cho chó mèo', 3, 300000.00, 10, 'uploads/products/long_van_chuyen.jpg', 'Lồng vận chuyển kích thước trung bình, phù hợp cho chó mèo.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bát ăn đôi cho thú cưng', 3, 150000.00, 15, 'uploads/products/bat_an_doi.jpg', 'Bát ăn đôi bằng nhựa cao cấp, chống trượt.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Vòng cổ chống ve rận', 3, 200000.00, 20, 'uploads/products/vong_co.jpg', 'Vòng cổ chống ve rận, bảo vệ thú cưng suốt 6 tháng.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";
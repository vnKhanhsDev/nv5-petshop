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
// $sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_products` (
//     `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã sản phẩm',
//     `name` VARCHAR(255) NOT NULL COMMENT 'Tên sản phẩm',
//     `category_id` INT NOT NULL COMMENT 'Mã danh mục sản phẩm',
//     `price` DECIMAL(10,2) NOT NULL COMMENT 'Giá sản phẩm',
//     `quantity` INT NOT NULL COMMENT 'Số lượng tồn kho',
//     `image` VARCHAR(255) NOT NULL COMMENT 'Đường dẫn ảnh sản phẩm',
//     `description` TEXT NOT NULL COMMENT 'Mô tả sản phẩm',
//     `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái. 0: ẩn - 1: hiện',
//     `created_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tạo lúc',
//     `updated_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Cập nhật gần nhất',
//     PRIMARY KEY (`id`),
//     INDEX (`category_id`)
// ) ENGINE = InnoDB COMMENT = 'Danh sách sản phẩm';";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã sản phẩm',
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên sản phẩm',
    `category_id` INT UNSIGNED NOT NULL COMMENT 'Mã danh mục sản phẩm',
    `price` DECIMAL(10, 2) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giá sản phẩm',
    `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Phần trăm giảm giá',
    `quantity` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượng trong kho',
    `tags` SET('new', 'featured', 'bestseller') DEFAULT NULL COMMENT 'Nhãn sản phẩm',
    `rating` DECIMAL(2, 1) NOT NULL DEFAULT 0 COMMENT 'Điểm đánh giá trung bình (0-5)',
    `description` TEXT NOT NULL DEFAULT '' COMMENT 'Mô tả sản phẩm',
    `image` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Hình ảnh sản phẩm',
    `is_show` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái: 0-ẩn, 1-hiện',
    `created_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT '0' COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách sản phẩm';";

// $sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_products` 
// (`name`, `category_id`, `price`, `quantity`, `image`, `description`, `status`, `created_at`, `updated_at`) 
// VALUES
// ('Chó Poodle nhỏ', 1, 5000000.00, 5, 'uploads/products/poodle.jpg', 'Chó Poodle lông xoăn màu nâu đỏ, 2 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Chó Corgi chân ngắn', 1, 7000000.00, 3, 'uploads/products/corgi.jpg', 'Chó Corgi lông vàng trắng, dễ thương, 3 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Chó Husky Siberian', 1, 9000000.00, 2, 'uploads/products/husky.jpg', 'Chó Husky thuần chủng, mắt xanh, 4 tháng tuổi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Mèo Anh lông ngắn', 2, 4000000.00, 4, 'uploads/products/meo_anh_long_ngan.jpg', 'Mèo Anh lông ngắn màu xám xanh, dễ nuôi.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Mèo Ba Tư lông dài', 2, 6000000.00, 3, 'uploads/products/meo_ba_tu.jpg', 'Mèo Ba Tư lông dài, lông trắng, mắt xanh.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Mèo Scottish tai cụp', 2, 7500000.00, 2, 'uploads/products/meo_scottish.jpg', 'Mèo Scottish tai cụp đáng yêu, phù hợp nuôi trong nhà.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Lồng vận chuyển cho chó mèo', 3, 300000.00, 10, 'uploads/products/long_van_chuyen.jpg', 'Lồng vận chuyển kích thước trung bình, phù hợp cho chó mèo.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Bát ăn đôi cho thú cưng', 3, 150000.00, 15, 'uploads/products/bat_an_doi.jpg', 'Bát ăn đôi bằng nhựa cao cấp, chống trượt.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
// ('Vòng cổ chống ve rận', 3, 200000.00, 20, 'uploads/products/vong_co.jpg', 'Vòng cổ chống ve rận, bảo vệ thú cưng suốt 6 tháng.', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_products`
(`name`, `category_id`, `price`, `discount`, `quantity`, `tags`, `rating`, `description`, `image`, `is_show`, `created_at`, `updated_at`)
VALUES
('Chó Corgi thuần chủng', 1, 12000000, 5, 5, 'new,featured', 4.8, 'Chó Corgi chân ngắn, đáng yêu.', 'corgi.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Golden Retriever', 1, 15000000, 10, 3, 'bestseller', 4.9, 'Chó Golden thông minh, thân thiện.', 'golden.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Husky Siberian', 1, 13000000, 8, 4, 'new', 4.7, 'Husky lông dày, đáng yêu.', 'husky.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Poodle Tiny', 1, 9000000, 0, 6, 'featured', 4.5, 'Chó Poodle nhỏ gọn, dễ chăm sóc.', 'poodle.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Alaska Giant', 1, 20000000, 12, 2, 'bestseller', 4.6, 'Chó Alaska to khỏe, đẹp.', 'alaska.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Chihuahua mini', 1, 7000000, 0, 8, '', 4.2, 'Chihuahua nhỏ, đáng yêu.', 'chihuahua.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Shiba Inu', 1, 18000000, 5, 3, 'featured', 4.8, 'Shiba Inu thông minh, dễ huấn luyện.', 'shiba.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Bulldog Pháp', 1, 17000000, 10, 2, 'new', 4.6, 'Bulldog mặt nhăn, dễ thương.', 'bulldog.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Pug mặt xệ', 1, 10000000, 0, 5, 'bestseller', 4.3, 'Pug nhỏ gọn, dễ nuôi.', 'pug.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chó Doberman', 1, 25000000, 15, 1, '', 4.7, 'Doberman mạnh mẽ, trung thành.', 'doberman.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Anh lông ngắn', 2, 8000000, 5, 7, 'bestseller', 4.9, 'Mèo Anh lông ngắn, đáng yêu.', 'anh-long-ngan.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Munchkin chân ngắn', 2, 9000000, 10, 6, 'featured', 4.8, 'Munchkin đáng yêu, chân ngắn.', 'munchkin.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Ba Tư lông dài', 2, 7000000, 0, 5, 'new', 4.7, 'Mèo Ba Tư sang trọng.', 'batu.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Scottish Fold', 2, 8500000, 5, 4, '', 4.6, 'Mèo tai cụp đáng yêu.', 'scottish.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Bengal vằn', 2, 10000000, 12, 3, 'bestseller', 4.5, 'Mèo Bengal hoang dã, mạnh mẽ.', 'bengal.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Ragdoll', 2, 11000000, 8, 2, 'featured', 4.9, 'Ragdoll hiền lành, thân thiện.', 'ragdoll.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Sphynx không lông', 2, 15000000, 10, 1, '', 4.2, 'Mèo không lông độc lạ.', 'sphynx.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Maine Coon', 2, 12000000, 5, 3, 'bestseller', 4.7, 'Maine Coon to lớn, sang trọng.', 'mainecoon.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Mỹ lông ngắn', 2, 6000000, 0, 5, '', 4.4, 'Mèo Mỹ thân thiện, dễ nuôi.', 'mylongngan.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo Xiêm Thái', 2, 7500000, 0, 4, 'new', 4.3, 'Mèo Xiêm thông minh, nhanh nhẹn.', 'xiem.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chuồng sắt cho chó/mèo', 3, 500000, 10, 20, 'bestseller', 4.7, 'Chuồng sắt chắc chắn.', 'chuong.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Balo phi hành gia', 3, 350000, 5, 15, 'featured', 4.6, 'Balo mang thú cưng ra ngoài.', 'balo.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dây dắt cho chó/mèo', 3, 150000, 0, 25, '', 4.5, 'Dây dắt bền chắc.', 'daydat.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bát ăn chống trượt', 3, 80000, 0, 30, 'bestseller', 4.3, 'Bát ăn chống trơn trượt.', 'batan.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cát vệ sinh hữu cơ', 3, 200000, 10, 50, 'featured', 4.8, 'Cát vệ sinh không mùi.', 'catvesinh.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Nhà gỗ cho thú cưng', 3, 1200000, 15, 10, '', 4.9, 'Nhà gỗ đẹp, chắc chắn.', 'nhago.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Đồ chơi gặm nhấm', 3, 100000, 0, 40, 'bestseller', 4.4, 'Đồ chơi giúp giảm stress.', 'dochoi.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Áo len mùa đông', 3, 200000, 5, 25, '', 4.6, 'Áo len giữ ấm mùa đông.', 'aolen.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Nệm lót chuồng', 3, 300000, 8, 20, 'new', 4.5, 'Nệm mềm cho thú cưng.', 'nem.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Máy lọc nước tự động', 3, 900000, 10, 10, 'featured', 4.8, 'Máy lọc nước cho thú cưng.', 'maylocnuoc.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";
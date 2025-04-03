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
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_pets;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_breeds;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_species;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_accessories;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_accessory_types;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_services;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_posts;';

$sql_create_module = $sql_drop_module;
// Table: Species (Các loài thú cưng)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_species` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã loài thú cưng',
    `name` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Tên loài thú cưng (chó, mèo, hamster,...)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách các loài thú cưng';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_species`
(`name`, `created_at`, `updated_at`) 
VALUES
('Chó', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mèo', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Hamster', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Thỏ', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: Breeds (Các giống thú cưng)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_breeds` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã giống thú cưng',
    `species_id` INT NOT NULL COMMENT 'Mã loài thú cưng',
    `name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Tên giống thú cưng (Golden Retriever, Poodle,...)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`species_id`) REFERENCES `nv5_vi_petshop_species`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB COMMENT = 'Danh sách các giống thú cưng';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_breeds`
(`species_id`, `name`, `created_at`, `updated_at`) 
VALUES
(1, 'Golden Retriever', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 'Poodle', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 'Husky', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Mèo Anh Lông Ngắn', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Mèo Ba Tư', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Mèo Scottish Fold', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Hamster Bear', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Hamster Robo', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'Thỏ Lông Xù', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'Thỏ Tai Dài', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: Pets (Danh sách thú cưng)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_pets` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã thú cưng',
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên thú cưng',
    `species_id` INT NOT NULL COMMENT 'Mã loài thú cưng',
    `breed_id` INT NOT NULL COMMENT 'Mã giống thú cưng',
    `gender` ENUM('male', 'female') NOT NULL COMMENT 'Giới tính',
    `age` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Tuổi (tháng)',
    `fur_color` VARCHAR(50) NOT NULL COMMENT 'Màu lông',
    `weight` FLOAT(3,1) UNSIGNED NOT NULL COMMENT 'Cân nặng (kg)',
    `origin` VARCHAR(255) NOT NULL COMMENT 'Nguồn gốc (trại giống, nhập khẩu, cứu hộ,...)',
    `is_vaccinated` BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Đã tiêm phòng hay chưa',
    `vaccination_details` TEXT NULL COMMENT 'Chi tiết các mũi tiêm nếu có',
    `price` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giá thú cưng (VND)',
    `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giảm giá (%)',
    `stock` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượng trong kho',
    `tags` SET('new', 'hot', 'best-seller') NOT NULL COMMENT 'Nhãn thú cưng (mới, nổi bật, bán chạy)',
    `rating` FLOAT(3,2) NOT NULL DEFAULT 0 COMMENT 'Điểm đánh giá trung bình (0-5)',
    `description` TEXT COMMENT 'Mô tả thú cưng',
    `image` VARCHAR(255) NOT NULL COMMENT 'Hình ảnh về thú cưng',
    `is_show` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Trạng thái hiển thị (0: Ẩn, 1: Hiện)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`species_id`) REFERENCES `nv5_vi_petshop_species`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`breed_id`) REFERENCES `nv5_vi_petshop_breeds`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB COMMENT = 'Danh sách thú cưng trong cửa hàng';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_pets` 
(`name`, `species_id`, `breed_id`, `gender`, `age`, `fur_color`, `weight`, `origin`, `is_vaccinated`, `vaccination_details`, `price`, `discount`, `stock`, `tags`, `rating`, `description`, `image`, `is_show`, `created_at`, `updated_at`) 
VALUES
('Bobby', 1, 1, 'male', 6, 'Vàng', 15.2, 'Trại giống', 1, 'Tiêm phòng dại, care', 15000000, 10, 3, 'new,hot', 4.8, 'Golden Retriever thông minh, thân thiện.', 'golden.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Luna', 1, 2, 'female', 4, 'Nâu', 5.5, 'Trại giống', 1, 'Tiêm phòng dại', 7000000, 5, 2, 'hot', 4.7, 'Poodle nhỏ nhắn, dễ huấn luyện.', 'poodle.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Max', 1, 3, 'male', 8, 'Đen trắng', 18.0, 'Nhập khẩu Nga', 1, 'Tiêm phòng đầy đủ', 20000000, 15, 1, 'best-seller', 4.9, 'Husky vui vẻ, năng động.', 'husky.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Rocky', 1, 1, 'male', 7, 'Vàng kem', 16.0, 'Trại giống', 1, 'Tiêm phòng dại', 16000000, 0, 2, 'hot', 4.7, 'Golden Retriever dễ huấn luyện.', 'golden2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Daisy', 1, 2, 'female', 3, 'Trắng', 4.8, 'Trại giống', 1, 'Tiêm phòng dại', 7500000, 5, 4, 'hot', 4.8, 'Poodle dễ thương, phù hợp với gia đình.', 'poodle2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Shadow', 1, 3, 'male', 9, 'Xám đen', 19.0, 'Trại giống', 1, 'Tiêm phòng đầy đủ', 21000000, 10, 1, 'new,best-seller', 4.9, 'Husky mạnh mẽ, thích hợp với người năng động.', 'husky2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mimi', 2, 4, 'female', 5, 'Xám', 4.0, 'Trại giống', 1, 'Tiêm phòng dại', 9000000, 0, 5, 'hot', 4.6, 'Mèo Anh Lông Ngắn dễ nuôi, đáng yêu.', 'aln.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Snow', 2, 5, 'male', 7, 'Trắng', 4.5, 'Nhập khẩu Iran', 1, 'Tiêm phòng đầy đủ', 12000000, 10, 2, 'best-seller', 4.8, 'Mèo Ba Tư lông dài, hiền lành.', 'batu.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tom', 2, 6, 'male', 6, 'Xám', 4.3, 'Trại giống', 1, 'Tiêm phòng cơ bản', 10000000, 5, 4, 'hot', 4.7, 'Mèo Scottish Fold tai cụp đáng yêu.', 'scottish.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bella', 2, 4, 'female', 5, 'Xám xanh', 4.2, 'Trại giống', 1, 'Tiêm phòng dại', 9500000, 0, 3, 'new', 4.5, 'Mèo Anh Lông Ngắn ngoan ngoãn.', 'aln2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Oliver', 2, 5, 'male', 8, 'Trắng vàng', 4.7, 'Nhập khẩu', 1, 'Tiêm phòng đầy đủ', 12500000, 10, 1, 'best-seller', 4.9, 'Mèo Ba Tư đẹp, sang trọng.', 'batu2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Lucy', 2, 6, 'female', 6, 'Xám trắng', 4.0, 'Trại giống', 1, 'Tiêm phòng cơ bản', 10200000, 5, 4, 'hot', 4.7, 'Scottish Fold dễ thương.', 'scottish2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Jerry', 3, 7, 'male', 2, 'Vàng', 0.1, 'Trại giống', 1, NULL, 500000, 0, 10, 'new', 4.5, 'Hamster Bear hiền lành.', 'hamster1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Coco', 3, 8, 'female', 1, 'Trắng', 0.08, 'Nhập khẩu', 1, NULL, 600000, 0, 8, 'new', 4.6, 'Hamster Robo nhanh nhẹn.', 'hamster2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Nutty', 3, 7, 'male', 3, 'Nâu', 0.12, 'Trại giống', 1, NULL, 550000, 0, 5, 'hot', 4.5, 'Hamster Bear lông mềm.', 'hamster3.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bunny', 4, 9, 'male', 3, 'Nâu', 2.5, 'Trại giống', 1, NULL, 1500000, 0, 5, 'hot', 4.4, 'Thỏ Lông Xù dễ thương.', 'tho1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Floppy', 4, 10, 'female', 4, 'Trắng', 3.0, 'Trại giống', 1, NULL, 1700000, 0, 3, 'best-seller', 4.7, 'Thỏ Tai Dài ngoan ngoãn.', 'tho2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Snowball', 4, 9, 'male', 5, 'Trắng kem', 2.8, 'Trại giống', 1, NULL, 1600000, 0, 4, 'hot', 4.6, 'Thỏ Lông Xù dễ nuôi.', 'tho3.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Thumper', 4, 10, 'female', 6, 'Xám', 3.1, 'Trại giống', 1, NULL, 1800000, 0, 2, 'best-seller', 4.8, 'Thỏ Tai Dài lanh lợi.', 'tho4.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: Accessory Types (Các loại phụ kiện)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_accessory_types` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã loại phụ kiện',
    `name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'Tên loại phụ kiện (dây dắt, quần áo, đồ ăn,..)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách các loại phụ kiện';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_accessory_types`
(`name`, `created_at`, `updated_at`)
VALUES
('Dây dắt', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Quần áo', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Đồ ăn', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Đồ chơi', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chuồng, lồng', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Vật dụng khác', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cát vệ sinh', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: Accessories (Danh sách phụ kiện)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_accessories` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã phụ kiện',
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên phụ kiện',
    `type_id` INT NOT NULL COMMENT 'Loại phụ kiện (tham chiếu bảng types)',
    `brand` VARCHAR(100) NOT NULL COMMENT 'Thương hiệu',
    `material` VARCHAR(100) NOT NULL COMMENT 'Chất liệu',
    `origin` VARCHAR(100) NOT NULL COMMENT 'Xuất xứ',
    `expiration_date` DATE DEFAULT NULL COMMENT 'Hạn sử dụng (nếu có)',
    `color` VARCHAR(50) DEFAULT NULL COMMENT 'Màu sắc',
    `size` VARCHAR(50) NOT NULL COMMENT 'Kích cỡ hoặc khối lượng',
    `price` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giá phụ kiện (VND)',
    `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giảm giá (%)',
    `stock` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượng trong kho',
    `tags` SET('new', 'hot', 'best-seller') NOT NULL COMMENT 'Nhãn phụ kiện',
    `rating` FLOAT(3,2) NOT NULL DEFAULT 0 COMMENT 'Điểm đánh giá trung bình (0-5)',
    `description` TEXT COMMENT 'Mô tả phụ kiện',
    `image` VARCHAR(255) NOT NULL COMMENT 'Hình ảnh về phụ kiện',
    `is_show` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Trạng thái hiển thị (0: Ẩn, 1: Hiện)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`type_id`) REFERENCES `nv5_vi_petshop_accessory_types`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB COMMENT = 'Danh sách phụ kiện';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_accessories` 
(`name`, `type_id`, `brand`, `material`, `origin`, `expiration_date`, `color`, `size`, `price`, `discount`, `stock`, `tags`, `rating`, `description`, `image`, `is_show`, `created_at`, `updated_at`)
VALUES
('Dây dắt thú cưng cao cấp', 1, 'PetLeashPro', 'Nylon', 'Việt Nam', NULL, 'Đỏ', 'M', 150000, 10, 50, 'new', 4.8, 'Dây dắt bền, chịu lực tốt.', 'leash1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dây dắt tự động 5m', 1, 'Flexi', 'Nhựa ABS', 'Đức', NULL, 'Đen', 'L', 300000, 15, 30, 'hot', 4.5, 'Dây dắt tự động thu gọn.', 'leash2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Áo hoodie cho chó', 2, 'PetFashion', 'Vải cotton', 'Trung Quốc', NULL, 'Xanh dương', 'XL', 250000, 5, 40, 'best-seller', 4.6, 'Áo hoodie ấm áp cho chó.', 'clothes1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Áo len mùa đông', 2, 'WinterPets', 'Len', 'Việt Nam', NULL, 'Đỏ', 'M', 180000, 10, 35, 'new', 4.7, 'Áo len mềm mại, giữ ấm tốt.', 'clothes2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Thức ăn hạt cho mèo 1kg', 3, 'MeowMix', 'Thịt gà, cá hồi', 'Mỹ', '2025-12-31', NULL, '1kg', 220000, 8, 60, 'best-seller', 4.9, 'Thức ăn giàu dinh dưỡng cho mèo.', 'food1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bánh thưởng cho chó', 3, 'DogJoy', 'Thịt bò sấy', 'Pháp', '2026-06-15', NULL, '500g', 150000, 12, 50, 'hot', 4.8, 'Bánh thưởng giúp răng chắc khỏe.', 'food2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Bóng cao su cho chó', 4, 'DogFun', 'Cao su tự nhiên', 'Việt Nam', NULL, 'Vàng', 'M', 90000, 5, 100, 'new', 4.4, 'Bóng chơi giúp rèn luyện cơ hàm.', 'toy1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chuột bông cho mèo', 4, 'CatPlay', 'Vải + bông', 'Trung Quốc', NULL, 'Xám', 'S', 75000, 0, 80, 'hot', 4.3, 'Chuột bông kích thích bản năng săn mồi.', 'toy2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cát vệ sinh cho mèo 5kg', 7, 'CatCare', 'Bentonite', 'Thái Lan', NULL, 'Trắng', '5kg', 250000, 10, 40, 'hot', 4.6, 'Cát vón cục, khử mùi tốt.', 'litter1.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cát thủy tinh cho mèo 3kg', 7, 'CrystalCat', 'Silica gel', 'Hàn Quốc', NULL, 'Xanh nhạt', '3kg', 300000, 12, 25, 'best-seller', 4.8, 'Cát vệ sinh khử mùi cực mạnh.', 'litter2.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: Services (Danh sách các dịch vụ)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_services` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã dịch vụ',
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên dịch vụ',
    `price` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giá dịch vụ (VND)',
    `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Giảm giá (%)',
    `estimated_time` SMALLINT UNSIGNED DEFAULT NULL COMMENT 'Thời gian thực hiện ước tính (phút)',
    `requires_appointment` BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Có cần đặt lịch hẹn trước không? (1: Có, 0: Không)',
    `rating` FLOAT(3,2) NOT NULL DEFAULT 0 COMMENT 'Điểm đánh giá trung bình (0-5)',
    `description` TEXT COMMENT 'Mô tả dịch vụ',
    `image` VARCHAR(255) NOT NULL COMMENT 'Hình ảnh dịch vụ',
    `is_show` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Trạng thái hiển thị (0: Ẩn, 1: Hiện)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách dịch vụ thú cưng';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_services` 
(`name`, `price`, `discount`, `estimated_time`, `requires_appointment`, `rating`, `description`, `image`, `is_show`, `created_at`, `updated_at`)
VALUES
('Tắm cho chó nhỏ', 150000, 5, 30, 0, 4.7, 'Dịch vụ tắm rửa cho chó dưới 10kg, sử dụng dầu gội chuyên dụng.', 'bath_small_dog.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tắm cho chó lớn', 250000, 10, 45, 0, 4.6, 'Dịch vụ tắm rửa cho chó trên 10kg, chăm sóc da lông.', 'bath_large_dog.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cắt tỉa lông chó', 200000, 5, 40, 1, 4.8, 'Dịch vụ cắt tỉa lông theo yêu cầu, giữ cho thú cưng luôn sạch sẽ.', 'dog_grooming.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cắt tỉa lông mèo', 180000, 5, 35, 1, 4.7, 'Cắt tỉa lông mèo theo phong cách yêu thích.', 'cat_grooming.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Vệ sinh tai và móng', 100000, 0, 20, 0, 4.5, 'Làm sạch tai, cắt tỉa móng cho thú cưng.', 'ear_nail_cleaning.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chải lông rụng', 80000, 0, 15, 0, 4.3, 'Dịch vụ loại bỏ lông rụng giúp giảm rụng lông trong nhà.', 'shedding_brush.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Khám sức khỏe tổng quát', 300000, 10, 60, 1, 4.9, 'Kiểm tra tổng quát tình trạng sức khỏe thú cưng.', 'health_check.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tiêm phòng dại', 250000, 5, 20, 1, 4.9, 'Tiêm phòng dại cho chó mèo, đảm bảo an toàn.', 'rabies_vaccine.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tiêm phòng 7 bệnh', 500000, 10, 30, 1, 4.8, 'Tiêm vaccine phòng 7 bệnh cho chó mèo.', 'vaccine_7diseases.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Chăm sóc sau phẫu thuật', 400000, 10, NULL, 1, 4.9, 'Dịch vụ chăm sóc thú cưng sau phẫu thuật.', 'post_surgery_care.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Trông giữ thú cưng (1 ngày)', 350000, 5, NULL, 1, 4.6, 'Dịch vụ giữ thú cưng 24h, đảm bảo an toàn.', 'pet_daycare.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Huấn luyện cơ bản', 800000, 15, NULL, 1, 4.8, 'Khóa huấn luyện cơ bản cho chó.', 'basic_training.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dịch vụ phối giống', 1500000, 20, NULL, 1, 4.7, 'Dịch vụ phối giống chó mèo có kiểm định sức khỏe.', 'mating_service.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Điều trị ve rận', 220000, 10, 40, 1, 4.7, 'Loại bỏ ve, rận cho chó mèo bằng liệu pháp an toàn.', 'flea_treatment.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tư vấn dinh dưỡng', 50000, 0, 30, 0, 4.5, 'Tư vấn dinh dưỡng cho thú cưng theo từng độ tuổi.', 'nutrition_consulting.jpg', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

// Table: posts (Danh sách bài viết)
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data ."_posts` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Mã bài viết',
    `title` VARCHAR(255) NOT NULL COMMENT 'Tiêu đề',
    `description` TEXT COMMENT 'Mô tả ngắn',
    `image` VARCHAR(255) NOT NULL COMMENT 'Hình ảnh minh hoạ',
    `content` MEDIUMTEXT COMMENT 'Nội dung chi tiết bài viết',
    `views` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượt xem bài viết',
    `likes` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượt thích',
    `tags` SET('health', 'care', 'training', 'food', 'behavior', 'disease') COMMENT 'Nhãn bài viết',
    `status` BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Trạng thái hiển thị (0: ẩn, 1: hiện)',
    `created_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Tạo lúc',
    `updated_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP() COMMENT 'Cập nhật gần nhất',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Danh sách bài viết về thú cưng';";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_posts`
(`title`, `description`, `image`, `content`, `views`, `likes`, `tags`, `status`, `created_at`, `updated_at`)
VALUES
('Cách chăm sóc chó con mới sinh', 'Hướng dẫn cách chăm sóc chó con mới sinh để phát triển khỏe mạnh.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Chó con mới sinh cần được giữ ấm và bú sữa mẹ trong 4 tuần đầu...', 1200, 150, 'care,health', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dinh dưỡng hợp lý cho mèo trưởng thành', 'Chế độ dinh dưỡng giúp mèo luôn khỏe mạnh và cân bằng.', '/nv5-petshop/src/uploads/petshop/posts/ad37c6ce227924b9e85930f98ae282d7_1.jpg', 'Mèo trưởng thành cần một chế độ ăn giàu protein và chất béo...', 850, 95, 'food,health', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Hướng dẫn huấn luyện chó cơ bản tại nhà', 'Những bước đơn giản để dạy chó vâng lời ngay tại nhà.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Huấn luyện chó cần sự kiên nhẫn, bắt đầu từ những lệnh cơ bản...', 2200, 300, 'training,behavior', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dấu hiệu nhận biết bệnh viêm da ở chó', 'Viêm da là bệnh thường gặp ở chó, đây là cách nhận biết.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Nếu thấy chó gãi nhiều, da đỏ và có mùi hôi, có thể bị viêm da...', 1400, 120, 'disease,health', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cách phòng tránh bệnh béo phì ở thú cưng', 'Béo phì là vấn đề phổ biến, đây là cách kiểm soát cân nặng.', '/nv5-petshop/src/uploads/petshop/posts/ad37c6ce227924b9e85930f98ae282d7_1.jpg', 'Thú cưng béo phì có thể mắc nhiều bệnh nghiêm trọng...', 980, 110, 'health,food', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Làm sao để giúp mèo giảm stress?', 'Dấu hiệu nhận biết và cách giảm stress cho mèo.', '/nv5-petshop/src/uploads/petshop/posts/ad37c6ce227924b9e85930f98ae282d7_1.jpg', 'Mèo dễ bị stress do thay đổi môi trường, tiếng ồn lớn...', 780, 90, 'care,behavior', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Thức ăn tốt nhất cho chó nhỏ', 'Chọn thức ăn phù hợp giúp chó nhỏ phát triển toàn diện.', '/nv5-petshop/src/uploads/petshop/posts/ad37c6ce227924b9e85930f98ae282d7_1.jpg', 'Chó nhỏ cần thức ăn dễ tiêu hóa, giàu protein và canxi...', 670, 85, 'food,health', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Vì sao chó sủa nhiều và cách kiểm soát?', 'Giải thích nguyên nhân và cách giảm tình trạng chó sủa nhiều.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Chó sủa có thể do cảnh giác, sợ hãi hoặc muốn thu hút sự chú ý...', 1120, 130, 'behavior,training', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tầm quan trọng của việc tiêm phòng cho thú cưng', 'Các loại vaccine quan trọng mà thú cưng cần được tiêm.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Tiêm phòng giúp thú cưng phòng tránh nhiều bệnh nguy hiểm...', 1900, 250, 'health,disease', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Những món đồ chơi giúp chó mèo luôn vui vẻ', 'Lựa chọn đồ chơi giúp thú cưng không bị nhàm chán.', '/nv5-petshop/src/uploads/petshop/posts/anh-thu-cung-cute-de-thuong_014113010_1.jpg', 'Đồ chơi không chỉ giúp giải trí mà còn cải thiện trí thông minh...', 530, 75, 'care,behavior', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

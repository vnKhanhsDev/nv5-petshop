<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'PetShop',
    'modfuncs' => 'main',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.00',
    'date' => 'Tuesday, March 25, 2025 4:00:00 PM GMT+07:00',
    'author' => 'Group3_TTCN_PKA <namkhanhs.dev@gmail.com>',
    'note' => '',
    'uploads_dir' => [
        $module_upload,
        $module_upload . '/pets',
    ],
    'icon' => 'fa-solid fa-paw'
];
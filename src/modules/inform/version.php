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
    'name' => 'inform',
    'modfuncs' => 'main',
    'is_sysmod' => 1,
    'virtual' => 0,
    'version' => '5.0.00',
    'date' => 'Monday, October 17, 2022 6:00:00 PM GMT+07:00',
    'author' => 'VINADES.,JSC <contact@vinades.vn>',
    'note' => '',
    'uploads_dir' => [
        $module_upload
    ],
    'icon' => 'fa-solid fa-bell'
];

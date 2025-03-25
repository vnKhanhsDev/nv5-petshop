<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

define('NV_IS_FILE_EMAILTEMPLATES', true);

$allow_func = [
    'main',
    'categories',
    'contents',
    'test'
];

$menu_top = [
    'title' => $module_name,
    'module_file' => '',
    'custom_title' => $nv_Lang->getGlobal('mod_emailtemplates')
];

$sql = 'SELECT catid, time_add, time_update, weight, is_system, ' . NV_LANG_DATA . '_title title
FROM ' . NV_EMAILTEMPLATES_GLOBALTABLE . '_categories ORDER BY weight ASC';
$global_array_cat = $nv_Cache->db($sql, 'catid', $module_name);

// Module trên tất cả các ngôn ngữ
$all_modules = [];
foreach ($global_config['setup_langs'] as $lang) {
    $sql = "SELECT title, custom_title FROM " . $db_config['prefix'] . "_" . $lang . "_modules";
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        $all_modules[$lang][$row['title']] = $row['custom_title'];
    }
    $result->closeCursor();
}

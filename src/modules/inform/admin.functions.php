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

$allow_func = ['main'];

if (defined('NV_IS_SPADMIN')) {
    $allow_func[] = 'configs';
}

define('NV_IS_FILE_ADMIN', true);
require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

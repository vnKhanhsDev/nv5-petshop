<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

$submenu['file'] = $nv_Lang->getModule('file_backup');
if (defined('NV_IS_GODADMIN')) {
    $submenu['sampledata'] = $nv_Lang->getModule('sampledata');
    $submenu['setting'] = $nv_Lang->getGlobal('mod_settings');
}

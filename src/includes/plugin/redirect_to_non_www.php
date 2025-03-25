<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

nv_add_hook($module_name, 'check_server', $priority, function (): void {
    global $nv_Server;

    $original_host = $nv_Server->getOriginalHost();
    if (str_starts_with($original_host, 'www.')) {
        nv_redirect_location($nv_Server->getOriginalProtocol() . '://' . substr($original_host, 4) . $nv_Server->getOriginalPort() . $_SERVER['REQUEST_URI']);
    }
});

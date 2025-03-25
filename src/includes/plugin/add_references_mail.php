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

nv_add_hook($module_name, 'sendmail_others_actions', $priority, function ($args): void {
    $global_config = $args[0];
    $mail = $args[1];
    if (!empty($global_config['custom_configs']['custom_mail_references'])) {
        $mail->addCustomHeader('References', '<' . $global_config['custom_configs']['custom_mail_references'] . '>');
    }
});

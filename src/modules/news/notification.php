<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    exit('Stop!!!');
}

if ($data['type'] == 'post_queue') {
    $data['title'] = $nv_Lang->getModule('notification_post_queue', $data['content']['title'], $data['send_from'], nv_clean60($data['content']['hometext'], 120));
    $data['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $data['obid'];
} elseif ($data['type'] == 'report') {
    $data['title'] = $nv_Lang->getModule('notification_report', $data['content']['title'], $data['content']['post_ip'], $data['content']['post_email']);
    $data['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $data['content']['newsid'] . '&amp;rid=' . $data['obid'];
}

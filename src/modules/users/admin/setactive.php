<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

if (!defined('NV_IS_AJAX')) {
    exit('Wrong URL');
}

$userids = $nv_Request->get_title('userid', 'post', '');
$userids = array_filter(array_unique(array_map('intval', array_map('trim', explode(',', $userids)))));
$setactive = $nv_Request->get_int('setactive', 'post', -1);
$is_setactive = (in_array('setactive', $allow_func, true) and !defined('NV_IS_USER_FORUM')) ? true : false;

if ($is_setactive and md5(NV_CHECK_SESSION . '_' . $module_name . '_main') == $nv_Request->get_string('checkss', 'post')) {
    foreach ($userids as $userid) {
        if (!$userid or $admin_info['admin_id'] == $userid) {
            continue;
        }

        $sql = 'SELECT a.lev, b.username, b.active, b.idsite FROM ' . NV_AUTHORS_GLOBALTABLE . ' a, ' . NV_MOD_TABLE . ' b WHERE a.admin_id=' . $userid . ' AND a.admin_id=b.userid';
        $row = $db->query($sql)->fetch(3);
        if (empty($row)) {
            $level = 0;
            $sql = 'SELECT username, active, idsite FROM ' . NV_MOD_TABLE . ' WHERE userid=' . $userid;
            [$username, $active, $idsite] = $db->query($sql)->fetch(3);
        } else {
            [$level, $username, $active, $idsite] = $row;
            $level = (int) $level;
        }

        // Chỉ cho thao tác với thành viên thường hoặc quản trị dưới cấp
        if (empty($level) or $admin_info['level'] < $level) {
            if ($global_config['idsite'] > 0 and $idsite != $global_config['idsite']) {
                continue;
            }
            if ($setactive < 0) {
                $active = $active ? 0 : 1;
            } elseif ($setactive == 0) {
                $active = 0;
            } else {
                $active = 1;
            }

            $sql = 'UPDATE ' . NV_MOD_TABLE . ' SET active=' . $active . ', last_update=' . NV_CURRENTTIME . ' WHERE userid=' . $userid;
            $result = $db->query($sql);

            $note = ($active) ? $nv_Lang->getModule('active_users') : $nv_Lang->getModule('unactive_users');
            nv_insert_logs(NV_LANG_DATA, $module_name, $note, 'userid: ' . $userid . ' - username: ' . $username, $admin_info['userid']);
        }
    }

    $nv_Cache->delMod($module_name);
}

nv_htmlOutput('OK');

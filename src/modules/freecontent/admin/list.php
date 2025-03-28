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

$bid = $nv_Request->get_int('bid', 'get', '');
$block = [];

if ($bid) {
    $block = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_blocks WHERE bid=' . $bid)->fetch();
}

$page_title = $nv_Lang->getModule('content_list') . ': ' . $block['title'];

// Write row
$xtpl = new XTemplate('list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$allow_editor = (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) ? true : false;

if (!defined('CKEDITOR5_CLASSIC') and $allow_editor) {
    define('CKEDITOR5_CLASSIC', true);
    $my_head .= '<script type="text/javascript" src="' . NV_STATIC_URL . NV_EDITORSDIR . '/ckeditor5-classic/ckeditor.js?t=' . $global_config['timestamp'] . '"></script>';
    $my_head .= '<script type="text/javascript" src="' . NV_STATIC_URL . NV_EDITORSDIR . '/ckeditor5-classic/language/' . NV_LANG_INTERFACE . '.js?t=' . $global_config['timestamp'] . '"></script>';
}

$xtpl->assign('EDITOR', $allow_editor ? 'true' : 'false');
$xtpl->assign('UPLOADS_DIR_USER', NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('BID', $bid);

$sql = 'SELECT id, title, description, link, image, start_time, end_time, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE bid=' . $bid . ' ORDER BY bid DESC';
$array = $db->query($sql)->fetchAll();
$num_rows = count($array);

if ($num_rows < 1) {
    $xtpl->parse('main.empty');
} else {
    $xtpl->assign('NUM_ROWS', $num_rows);

    foreach ($array as $row) {
        if (!empty($row['image'])) {
            if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $row['image'])) {
                $row['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $row['image'];
            } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'])) {
                $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
            } else {
                $row['image'] = '';
            }
        }

        $row['status_text'] = $nv_Lang->getModule('content_status_' . $row['status']);

        if ($row['start_time'] > 0) {
            $row['status_text'] .= '. ' . $nv_Lang->getModule('content_status_note0') . ' ' . nv_datetime_format($row['start_time'], 1, 0);

            if ($row['end_time'] > 0) {
                $row['status_text'] .= '. ' . sprintf($row['status'] == 2 ? $nv_Lang->getModule('content_status_note2') : $nv_Lang->getModule('content_status_note1'), nv_datetime_format($row['end_time'], 1, 0));
            }
        }

        $xtpl->assign('ROW', $row);

        if (!empty($row['image'])) {
            $xtpl->parse('main.rows.loop.image');
        }

        $xtpl->parse('main.rows.loop');
    }

    $xtpl->parse('main.rows');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

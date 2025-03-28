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

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' ORDER BY vid ASC';
$result = $db->query($sql);

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$i = 0;
while ($row = $result->fetch()) {
    $sql1 = 'SELECT SUM(hitstotal) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE vid=' . $row['vid'];
    $totalvote = $db->query($sql1)->fetchColumn();
    ++$i;
    $xtpl->assign('ROW', [
        'status' => $row['act'] == 1 ? $nv_Lang->getModule('voting_yes') : $nv_Lang->getModule('voting_no'),
        'vid' => $row['vid'],
        'question' => $row['question'],
        'totalvote' => $totalvote,
        'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;vid=' . $row['vid'],
        'checksess' => md5($row['vid'] . NV_CHECK_SESSION)
    ]);

    $xtpl->parse('main.loop');
}
if (empty($i)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('voting_list');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

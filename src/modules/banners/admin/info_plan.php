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

$id = $nv_Request->get_int('id', 'get', 0);

$sql = 'SELECT * FROM ' . NV_BANNERS_GLOBALTABLE . '_plans WHERE id=' . $id;
$row = $db->query($sql)->fetch();

if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$row['caption'] = $nv_Lang->getModule('info_plan_caption', $row['title']);
$row['blang_format'] = !empty($row['blang']) ? $language_array[$row['blang']]['name'] : $nv_Lang->getModule('blang_all');
$row['form_format'] = $nv_Lang->existsModule('form_' . $row['form']) ? $nv_Lang->getModule('form_' . $row['form']) : $row['form'];
$row['is_act'] = $row['act'] ? $nv_Lang->getGlobal('yes') : $nv_Lang->getGlobal('no');
$row['require_image'] = $nv_Lang->getModule('require_image' . $row['require_image']);
$row['uploadtype'] = str_replace(',', ', ', $row['uploadtype']);
$row['plan_exp_time'] = empty($row['exp_time']) ? $nv_Lang->getModule('plan_exp_time_nolimit') : nv_convertfromSec($row['exp_time']);

$groups_list = nv_groups_list();
$uploadgroup = [];
if (!empty($row['uploadgroup'])) {
    $row['uploadgroup'] = array_map('intval', explode(',', $row['uploadgroup']));
    foreach ($groups_list as $k => $v) {
        if (in_array($k, $row['uploadgroup'], true)) {
            $uploadgroup[] = $v;
        }
    }
}
$row['uploadgroup'] = implode(', ', $uploadgroup);

$xtpl = new XTemplate('info_plan.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('ROW', $row);
$xtpl->assign('LOCATION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=info_plan&amp;id=' . $id);

if (!empty($row['description'])) {
    $xtpl->parse('main.description');
}

$accordion = $nv_Request->get_title('accordion', 'get', '');
if (!empty($accordion) and in_array($accordion, ['list_act', 'list_queue', 'list_timeract', 'list_exp', 'list_deact'], true)) {
    $xtpl->assign('ACCORDION', $accordion);
    $xtpl->parse('main.accordion');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('info_plan');

$set_active_op = 'plans_list';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

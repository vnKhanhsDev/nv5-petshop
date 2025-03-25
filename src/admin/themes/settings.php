<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_THEMES')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('settings');

// Lấy tất cả các giao diện (không phải mobile) đã được thiết lập
$array_site_cat_theme = $array_site_theme = [];
$result = $db->query('SELECT DISTINCT theme FROM ' . NV_PREFIXLANG . '_modthemes WHERE func_id=0 ORDER BY theme ASC');
while ([$theme] = $result->fetch(3)) {
    if (preg_match($global_config['check_theme'], $theme)) {
        $array_site_theme[] = $theme;
    }
}
if ($global_config['idsite']) {
    $sql = 'SELECT t1.theme FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site_cat t1
    INNER JOIN ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site t2 ON t1.cid=t2.cid WHERE t2.idsite=' . $global_config['idsite'];
    $theme = $db->query($sql)->fetchColumn();
    if (!empty($theme)) {
        $array_site_cat_theme = explode(',', $theme);
    }
    $array_site_cat_theme = array_unique(array_merge($array_site_theme, $array_site_cat_theme));
} else {
    $array_site_cat_theme = $array_site_theme;
}

$array_config = [];

// Submit form
if ($nv_Request->get_title('tokend', 'post', '') === NV_CHECK_SESSION) {
    $array_config['user_allowed_theme'] = $nv_Request->get_typed_array('user_allowed_theme', 'post', 'title', []);
    $array_config['user_allowed_theme'] = array_intersect($array_config['user_allowed_theme'], $array_site_cat_theme);
    $array_config['user_allowed_theme'][] = $global_config['site_theme'];
    $array_config['user_allowed_theme'] = array_unique($array_config['user_allowed_theme']);
    asort($array_config['user_allowed_theme']);
    $array_config['user_allowed_theme'] = empty($array_config['user_allowed_theme']) ? '' : json_encode($array_config['user_allowed_theme']);

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value= :config_value WHERE config_name = :config_name AND lang = '" . NV_LANG_DATA . "' AND module='global'");
    foreach ($array_config as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $nv_Cache->delAll();
    nv_jsonOutput([
        'status' => 'success',
        'mess' => $nv_Lang->getGlobal('save_success'),
        'refresh' => 1
    ]);
}

$array_config['user_allowed_theme'] = $global_config['array_user_allowed_theme'];

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('settings.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

$tpl->assign('LANG_MESSAGE', $nv_Lang->getModule('settings_utheme_lnote', $language_array[NV_LANG_DATA]['name']));
$tpl->assign('ARRAY', $array_site_cat_theme);
$tpl->assign('DATA', $array_config);
$tpl->assign('GCONFIG', $global_config);

$contents = $tpl->fetch('settings.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

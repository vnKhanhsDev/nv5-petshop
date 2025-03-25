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

$set_layout_site = false;
$select_options = [];
$theme_array = nv_scandir(NV_ROOTDIR . '/themes', [$global_config['check_theme'], $global_config['check_theme_mobile']]);

if ($global_config['idsite']) {
    $theme = $db->query('SELECT t1.theme FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site_cat t1 INNER JOIN ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site t2 ON t1.cid=t2.cid WHERE t2.idsite=' . $global_config['idsite'])->fetchColumn();
    if (!empty($theme)) {
        $array_site_cat_theme = explode(',', $theme);

        $result = $db->query('SELECT DISTINCT theme FROM ' . NV_PREFIXLANG . '_modthemes WHERE func_id=0');
        while ([$theme] = $result->fetch(3)) {
            $array_site_cat_theme[] = $theme;
        }
        $theme_array = array_intersect($theme_array, $array_site_cat_theme);
    }
}

foreach ($theme_array as $themes_i) {
    if (file_exists(NV_ROOTDIR . '/themes/' . $themes_i . '/config.ini')) {
        $select_options[NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=setuplayout&amp;selectthemes=' . $themes_i] = $themes_i;
    }
}

$selectthemes_old = $nv_Request->get_string('selectthemes', 'cookie', $global_config['site_theme']);
$selectthemes = $nv_Request->get_string('selectthemes', 'get', $selectthemes_old);

if (!in_array($selectthemes, $theme_array, true)) {
    $selectthemes = 'default';
}

if ($selectthemes_old != $selectthemes) {
    $nv_Request->set_Cookie('selectthemes', $selectthemes, NV_LIVE_COOKIE_TIME);
}

$layout_array = nv_scandir(NV_ROOTDIR . '/themes/' . $selectthemes . '/layout', $global_config['check_op_layout']);

if (!empty($layout_array)) {
    $layout_array = preg_replace($global_config['check_op_layout'], '\\1', $layout_array);
}
$array_layout_func_default = [];

$page_title = $nv_Lang->getModule('setup_layout') . ':' . $selectthemes;

if (!file_exists(NV_ROOTDIR . '/themes/' . $selectthemes . '/config.ini')) {
    $contents = nv_theme_alert($nv_Lang->getGlobal('danger_level'), $nv_Lang->getModule('block_error_fileconfig_content'), 'danger');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$xml = simplexml_load_file(NV_ROOTDIR . '/themes/' . $selectthemes . '/config.ini');
$layoutdefault = (string) $xml->layoutdefault;
$layout = $xml->xpath('setlayout/layout');

for ($i = 0, $count = count($layout); $i < $count; ++$i) {
    $layout_name = (string) $layout[$i]->name;

    if (in_array($layout_name, $layout_array, true)) {
        $layout_funcs = $layout[$i]->xpath('funcs');

        for ($j = 0, $sizeof = count($layout_funcs); $j < $sizeof; ++$j) {
            $mo_funcs = (string) $layout_funcs[$j];
            $mo_funcs = explode(':', $mo_funcs);
            $m = $mo_funcs[0];
            $arr_f = explode(',', $mo_funcs[1]);

            foreach ($arr_f as $f) {
                $array_layout_func_default[$m][$f] = $layout_name;
            }
        }
    }
}

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $selectthemes . '_' . $admin_info['userid']);

if ($checkss == $nv_Request->get_string('checkss', 'post')) {
    if ($nv_Request->isset_request('save', 'post') and $nv_Request->isset_request('func', 'post')) {
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('setup_layout') . ' theme: "' . $selectthemes . '"', '', $admin_info['userid']);

        $func_arr_save = $nv_Request->get_array('func', 'post');

        foreach ($func_arr_save as $func_id => $layout_name) {
            if (in_array($layout_name, $layout_array, true)) {
                $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_modthemes SET layout=:layout WHERE func_id = :func_id AND theme= :theme');
                $sth->bindParam(':layout', $layout_name, PDO::PARAM_STR);
                $sth->bindParam(':func_id', $func_id, PDO::PARAM_INT);
                $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
                $sth->execute();
            }
        }

        $nv_Cache->delMod('themes');
        $nv_Cache->delMod('modules');

        nv_jsonOutput([
            'status' => 'success',
            'mess' => $nv_Lang->getModule('setup_updated_layout'),
            'refresh' => 1
        ]);
    }

    // Thiết lập cho tất cả các functions
    if ($nv_Request->isset_request('saveall', 'post') and $nv_Request->isset_request('layout', 'post')) {
        $layout = $nv_Request->get_string('layout', 'post');
        $module = $nv_Request->get_string('block_module', 'post');
        if (!in_array($layout, $layout_array, true)) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('setup_select_layout_error')
            ]);
        }
        if (!empty($module) and !isset($site_mods[$module])) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => 'Module not exists!!!'
            ]);
        }
        if (empty($module)) {
            // Thiết lập layout cho tất cả
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_modthemes SET layout= :layout WHERE func_id IN (SELECT func_id FROM ' . NV_MODFUNCS_TABLE . ' WHERE show_func=1) AND theme= :theme');
            $sth->bindParam(':layout', $layout, PDO::PARAM_STR);
            $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
            $sth->execute();
        } elseif (isset($site_mods[$module])) {
            // Thiết lập layout cho module
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_modthemes SET layout= :layout WHERE func_id IN (SELECT func_id FROM ' . NV_MODFUNCS_TABLE . ' WHERE in_module = :in_module AND show_func=1) AND theme= :theme');
            $sth->bindParam(':layout', $layout, PDO::PARAM_STR);
            $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
            $sth->bindParam(':in_module', $module, PDO::PARAM_STR);
            $sth->execute();
        }

        $nv_Cache->delMod('themes');
        $nv_Cache->delMod('modules');

        nv_jsonOutput([
            'status' => 'success',
            'mess' => $nv_Lang->getModule('setup_updated_layout'),
            'refresh' => 1
        ]);
    }
}

$array_layout_func_data = [];
$sth = $db->prepare('SELECT func_id, layout FROM ' . NV_PREFIXLANG . '_modthemes WHERE theme= :theme');
$sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
$sth->execute();
while ([$func_id, $layout] = $sth->fetch(3)) {
    $array_layout_func_data[$func_id] = $layout;
}

if (!isset($array_layout_func_data[0])) {
    $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_modthemes
        (func_id, layout, theme) VALUES
        (0, :layout, :theme)');
    $sth->bindParam(':layout', $layoutdefault, PDO::PARAM_STR);
    $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
    $sth->execute();

    $set_layout_site = true;
} elseif ($array_layout_func_data[0] != $layoutdefault) {
    $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_modthemes SET layout= :layout WHERE func_id=0 AND theme= :theme');
    $sth->bindParam(':layout', $layoutdefault, PDO::PARAM_STR);
    $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
    $sth->execute();

    $set_layout_site = true;
}

$array_layout_func = [];
$fnresult = $db->query('SELECT func_id, func_name, func_custom_name, in_module FROM ' . NV_MODFUNCS_TABLE . ' WHERE show_func=1 ORDER BY subweight ASC');
while ([$func_id, $func_name, $func_custom_name, $in_module] = $fnresult->fetch(3)) {
    if (isset($array_layout_func_data[$func_id]) and !empty($array_layout_func_data[$func_id])) {
        $layout_name = $array_layout_func_data[$func_id];

        if (!in_array($layout_name, $layout_array, true)) {
            $layout_name = $layoutdefault;

            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_modthemes SET layout= :layout WHERE func_id= :func_id AND theme= :theme');
            $sth->bindParam(':layout', $layout_name, PDO::PARAM_STR);
            $sth->bindParam(':func_id', $func_id, PDO::PARAM_INT);
            $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
            $sth->execute();

            $set_layout_site = true;
        }
    } else {
        $layout_name = (isset($array_layout_func_default[$in_module][$func_name])) ? $array_layout_func_default[$in_module][$func_name] : $layoutdefault;
        $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_modthemes (func_id, layout, theme) VALUES (:func_id, :layout, :theme)');
        $sth->bindParam(':func_id', $func_id, PDO::PARAM_INT);
        $sth->bindParam(':layout', $layout_name, PDO::PARAM_STR);
        $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
        $sth->execute();

        $set_layout_site = true;
    }

    $array_layout_func[$in_module][$func_name] = [$func_id, $func_custom_name, $layout_name];
}

if ($set_layout_site) {
    $nv_Cache->delMod('themes');
    $nv_Cache->delMod('modules');
}

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('setuplayout.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

$tpl->assign('CHECKSS', $checkss);
$tpl->assign('LAYOUT_ARRAY', $layout_array);

$rows = $db->query('SELECT title, custom_title FROM ' . NV_MODULES_TABLE . ' ORDER BY weight ASC')->fetchAll();
$number_func = count($rows);
$array_modules = [];
foreach ($rows as $row) {
    if (isset($array_layout_func[$row['title']])) {
        $array_modules[$row['title']] = [
            'module' => $row,
            'funcs' => $array_layout_func[$row['title']]
        ];
    }
}
$tpl->assign('ARRAY_MODULES', $array_modules);

$contents = $tpl->fetch('setuplayout.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

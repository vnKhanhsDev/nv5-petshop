<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SETTINGS')) {
    exit('Stop!!!');
}

$array_theme_type = ['r', 'd', 'm'];
$theme_array = [];
$theme_array_file = nv_scandir(NV_ROOTDIR . '/themes', $global_config['check_theme']);

$mobile_theme_array = [];
$mobile_theme_array_file = nv_scandir(NV_ROOTDIR . '/themes', $global_config['check_theme_mobile']);

$sql = 'SELECT DISTINCT theme FROM ' . NV_PREFIXLANG . '_modthemes WHERE func_id=0';
$result = $db->query($sql);
while ([$theme] = $result->fetch(3)) {
    if (in_array($theme, $theme_array_file, true)) {
        $theme_array[] = $theme;
    } elseif (in_array($theme, $mobile_theme_array_file, true)) {
        $mobile_theme_array[] = $theme;
    }
}

// Lưu cấu hình
$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_info['userid']);
if ($nv_Request->get_string('checkss', 'post') == $checkss) {
    $array_config = [];
    $array_config['site_name'] = nv_substr($nv_Request->get_title('site_name', 'post', '', 1), 0, 255);
    if (empty($array_config['site_name'])) {
        nv_jsonOutput([
            'status' => 'error',
            'mess' => $nv_Lang->getModule('sitename_error')
        ]);
    }

    $array_config['site_description'] = nv_substr($nv_Request->get_title('site_description', 'post', '', 1), 0, 255);
    if (empty($array_config['site_description'])) {
        nv_jsonOutput([
            'status' => 'error',
            'mess' => $nv_Lang->getModule('description_error')
        ]);
    }

    $site_domain = $nv_Request->get_title('site_domain', 'post', '');
    $array_config['site_domain'] = (!empty($global_config['my_domains']) and in_array($site_domain, $global_config['my_domains'], true)) ? $site_domain : '';
    $array_config['site_theme'] = nv_substr($nv_Request->get_title('site_theme', 'post', '', 1), 0, 255);
    !in_array($array_config['site_theme'], $theme_array, true) && $array_config['site_theme'] = $global_config['site_theme'];
    $array_config['mobile_theme'] = nv_substr($nv_Request->get_title('mobile_theme', 'post', '', 1), 0, 255);
    (!empty($array_config['mobile_theme']) and !in_array($array_config['mobile_theme'], $mobile_theme_array, true)) && $array_config['mobile_theme'] = $global_config['mobile_theme'];
    $array_config['switch_mobi_des'] = $nv_Request->get_int('switch_mobi_des', 'post', 0);
    $_array_theme_type = $nv_Request->get_typed_array('theme_type', 'post', 'title');
    $_array_theme_type = array_intersect($_array_theme_type, $array_theme_type);
    if (!in_array('m', $_array_theme_type, true)) {
        $array_config['mobile_theme'] = '';
    }
    if (empty($array_config['mobile_theme'])) {
        $array_config['switch_mobi_des'] = 0;
    }
    if (!in_array('r', $_array_theme_type, true) and !in_array('d', $_array_theme_type, true)) {
        $_array_theme_type[] = 'r';
    }
    $array_config['theme_type'] = implode(',', $_array_theme_type);

    $array_config['site_keywords'] = nv_substr($nv_Request->get_title('site_keywords', 'post', '', 1), 0, 255);
    if (!empty($array_config['site_keywords'])) {
        $array_config['site_keywords'] = array_map('trim', explode(',', nv_strtolower($array_config['site_keywords'])));
        $array_config['site_keywords'] = array_unique($array_config['site_keywords']);
        $array_config['site_keywords'] = array_filter($array_config['site_keywords'], function ($key) {
            return !empty($key) and !is_numeric($key);
        });
        $array_config['site_keywords'] = implode(', ', $array_config['site_keywords']);
    }

    $site_logo = $nv_Request->get_title('site_logo', 'post', '');
    if (empty($site_logo) or $site_logo == NV_ASSETS_DIR . '/images/logo.png') {
        $array_config['site_logo'] = '';
    } elseif (!nv_is_url($site_logo)) {
        if (nv_is_file($site_logo) === true) {
            $array_config['site_logo'] = substr($site_logo, strlen(NV_BASE_SITEURL));
        } else {
            $array_config['site_logo'] = '';
        }
    }

    $site_banner = $nv_Request->get_title('site_banner', 'post');
    if (empty($site_banner)) {
        $array_config['site_banner'] = '';
    } elseif (!nv_is_url($site_banner)) {
        if (nv_is_file($site_banner) === true) {
            $lu = strlen(NV_BASE_SITEURL);
            $array_config['site_banner'] = substr($site_banner, $lu);
        } else {
            $array_config['site_banner'] = '';
        }
    }

    $site_favicon = $nv_Request->get_title('site_favicon', 'post');
    if (empty($site_favicon) or $site_favicon == NV_ASSETS_DIR . '/favicon.ico') {
        $array_config['site_favicon'] = '';
    } elseif (!nv_is_url($site_favicon)) {
        if (nv_is_file($site_favicon) === true) {
            $lu = strlen(NV_BASE_SITEURL);
            $array_config['site_favicon'] = substr($site_favicon, $lu);
        } else {
            $array_config['site_favicon'] = '';
        }
    }

    $array_config['site_home_module'] = nv_substr($nv_Request->get_title('site_home_module', 'post', '', 1), 0, 255);
    if (!isset($site_mods[$array_config['site_home_module']])) {
        $array_config['site_home_module'] = $global_config['site_home_module'];
    }

    $array_config['disable_site_content'] = $nv_Request->get_editor('disable_site_content', '', NV_ALLOWED_HTML_TAGS);

    if (empty($array_config['disable_site_content'])) {
        $array_config['disable_site_content'] = $nv_Lang->getGlobal('disable_site_content');
    }

    $array_config['data_warning'] = (int) $nv_Request->get_bool('data_warning', 'post', false);
    $array_config['antispam_warning'] = (int) $nv_Request->get_bool('antispam_warning', 'post', false);
    $array_config['data_warning_content'] = $nv_Request->get_textarea('data_warning_content', 'post', '');
    $array_config['antispam_warning_content'] = $nv_Request->get_textarea('antispam_warning_content', 'post', '');
    if (!empty($array_config['data_warning_content'])) {
        $array_config['data_warning_content'] = strip_tags($array_config['data_warning_content']);
        $array_config['data_warning_content'] = trim($array_config['data_warning_content']);
        $array_config['data_warning_content'] = nv_nl2br($array_config['data_warning_content']);
    }
    if (!empty($array_config['antispam_warning_content'])) {
        $array_config['antispam_warning_content'] = strip_tags($array_config['antispam_warning_content']);
        $array_config['antispam_warning_content'] = trim($array_config['antispam_warning_content']);
        $array_config['antispam_warning_content'] = nv_nl2br($array_config['antispam_warning_content']);
    }

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value= :config_value WHERE config_name = :config_name AND lang = '" . NV_LANG_DATA . "' AND module='global'");
    foreach ($array_config as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    file_put_contents(NV_ROOTDIR . '/' . NV_DATADIR . '/disable_site_content.' . NV_LANG_DATA . '.txt', $array_config['disable_site_content'], LOCK_EX);

    $nv_Cache->delAll();

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success'),
        'refresh' => 1
    ]);
}

$site_logo = '';
if (!empty($global_config['site_logo']) and $global_config['site_logo'] != NV_ASSETS_DIR . '/images/logo.png' and !nv_is_url($global_config['site_logo']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_logo'])) {
    $site_logo = NV_BASE_SITEURL . $global_config['site_logo'];
}

$site_banner = '';
if (!empty($global_config['site_banner']) and !nv_is_url($global_config['site_banner']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_banner'])) {
    $site_banner = NV_BASE_SITEURL . $global_config['site_banner'];
}

$site_favicon = '';
if (!empty($global_config['site_favicon']) and $global_config['site_favicon'] != NV_ASSETS_DIR . '/favicon.ico' and !nv_is_url($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
    $site_favicon = NV_BASE_SITEURL . $global_config['site_favicon'];
}

$value_setting = [
    'checkss' => $checkss,
    'sitename' => $global_config['site_name'],
    'site_logo' => $site_logo,
    'site_banner' => $site_banner,
    'site_favicon' => $site_favicon,
    'site_keywords' => $global_config['site_keywords'],
    'description' => $global_config['site_description'],
    'switch_mobi_des' => $global_config['switch_mobi_des'],
    'data_warning_content' => !empty($global_config['data_warning_content']) ? nv_br2nl($global_config['data_warning_content']) : '',
    'antispam_warning_content' => !empty($global_config['antispam_warning_content']) ? nv_br2nl($global_config['antispam_warning_content']) : ''
];

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$page_title = $nv_Lang->getModule('lang_site_config', $language_array[NV_LANG_DATA]['name']);

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('main.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

$tpl->assign('GCONFIG', $global_config);
$tpl->assign('DATA', $value_setting);
$tpl->assign('THEME_TYPES', $array_theme_type);
$tpl->assign('THEME_ARRAY', $theme_array);
$tpl->assign('MOBILE_THEME_ARRAY', $mobile_theme_array);

$sql = 'SELECT title, custom_title FROM ' . NV_MODULES_TABLE . " WHERE act=1 AND title NOT IN ('menu', 'comment') ORDER BY weight ASC";
$mods = $db->query($sql)->fetchAll();
$tpl->assign('MODS', $mods);

$global_config['disable_site_content'] = htmlspecialchars(nv_editor_br2nl($global_config['disable_site_content']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $disable_site_content = nv_aleditor('disable_site_content', '100%', '100px', $global_config['disable_site_content'], 'Basic');
} else {
    $disable_site_content = '<textarea style="width:100%;height:100px" name="disable_site_content" id="disable_site_content">' . $global_config['disable_site_content'] . '</textarea>';
}
$tpl->assign('DISABLE_SITE_CONTENT', $disable_site_content);

$contents = $tpl->fetch('main.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

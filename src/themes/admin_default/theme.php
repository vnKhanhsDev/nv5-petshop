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

use NukeViet\Client\Browser;

/**
 * nv_get_submenu()
 *
 * @param string $mod
 * @return array
 */
function nv_get_submenu($mod)
{
    global $module_name, $global_config, $admin_mods, $nv_Lang;

    $submenu = [];

    if (file_exists(NV_ROOTDIR . '/' . NV_ADMINDIR . '/' . $mod . '/admin.menu.php')) {
        $nv_Lang->loadModule($mod, true, true);
        include NV_ROOTDIR . '/' . NV_ADMINDIR . '/' . $mod . '/admin.menu.php';
        $nv_Lang->changeLang();
    }

    return $submenu;
}

/**
 * nv_get_submenu_mod()
 *
 * @param string $module_name
 * @return array
 */
function nv_get_submenu_mod($module_name)
{
    global $global_config, $db, $site_mods, $admin_info, $db_config, $admin_mods, $nv_Lang;

    $submenu = [];
    if (isset($site_mods[$module_name])) {
        $module_info = $site_mods[$module_name];
        $module_file = $module_info['module_file'];
        $module_data = $module_info['module_data'];
        if (file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/admin.menu.php')) {
            $nv_Lang->loadModule($module_file, false, true);
            include NV_ROOTDIR . '/modules/' . $module_file . '/admin.menu.php';
            $nv_Lang->changeLang();
        }
    }

    return $submenu;
}

/**
 * nv_admin_theme()
 *
 * @param string $contents
 * @param int    $head_site
 * @return string
 */
function nv_admin_theme($contents, $head_site = 1)
{
    global $global_config, $nv_Lang, $admin_mods, $site_mods, $admin_menu_mods, $module_name, $module_file, $module_info, $admin_info, $page_title, $submenu, $select_options, $op, $set_active_op, $array_lang_admin, $my_head, $my_footer, $array_mod_title, $array_url_instruction, $op, $client_info, $browser;

    $file_name_tpl = $head_site == 1 ? 'main.tpl' : 'content.tpl';
    $admin_info['admin_theme'] = get_tpl_dir($admin_info['admin_theme'], NV_DEFAULT_ADMIN_THEME, '/system/' . $file_name_tpl);

    $global_config['site_name'] = empty($global_config['site_name']) ? NV_SERVER_NAME : $global_config['site_name'];
    !isset($global_config['admin_XSSsanitize']) && $global_config['admin_XSSsanitize'] = 1;

    $site_favicon = NV_BASE_SITEURL . 'favicon.ico';
    if (!empty($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
        $site_favicon = NV_BASE_SITEURL . $global_config['site_favicon'];
    }

    $admin_info['hello_admin1'] = !empty($admin_info['last_login']) ? $nv_Lang->getGlobal('hello_admin1', date('H:i d/m/Y', $admin_info['last_login']), $admin_info['last_ip']) : '';
    $admin_info['hello_admin2'] = $nv_Lang->getGlobal('hello_admin2', date('H:i d/m/Y', $admin_info['current_login']), $admin_info['current_ip']);

    $whitelisted_attr = ['target'];
    if (!empty($global_config['allowed_html_tags']) and in_array('iframe', $global_config['allowed_html_tags'])) {
        $whitelisted_attr[] = 'frameborder';
        $whitelisted_attr[] = 'allowfullscreen';
    }
    $xtpl = new XTemplate($file_name_tpl, NV_ROOTDIR . '/themes/' . $admin_info['admin_theme'] . '/system');
    $xtpl->assign('NV_SITE_COPYRIGHT', $global_config['site_name'] . ' [' . $global_config['site_email'] . '] ');
    $xtpl->assign('NV_SITE_NAME', $global_config['site_name']);
    $xtpl->assign('NV_SITE_TITLE', $global_config['site_name'] . NV_TITLEBAR_DEFIS . $nv_Lang->getGlobal('admin_page') . NV_TITLEBAR_DEFIS . $module_info['custom_title']);
    $xtpl->assign('SITE_DESCRIPTION', empty($global_config['site_description']) ? $page_title : $global_config['site_description']);
    $xtpl->assign('NV_CHECK_PASS_MSTIME', ((int) ($global_config['admin_check_pass_time']) - 62) * 1000);
    $xtpl->assign('NV_XSS_SANITIZE', ($global_config['admin_XSSsanitize'] ? 1 : 0));
    $xtpl->assign('NV_WHITELISTED_TAGS', !empty($global_config['allowed_html_tags']) ? "['" . implode("', '", $global_config['allowed_html_tags']) . "']" : '');
    $xtpl->assign('NV_WHITELISTED_ATTR', "['" . implode("', '", $whitelisted_attr). "']");
    $xtpl->assign('JSDATE_GET', nv_region_config('jsdate_get'));
    $xtpl->assign('JSDATE_POST', nv_region_config('jsdate_post'));
    $xtpl->assign('JS_AM', nv_region_config('am_char'));
    $xtpl->assign('JS_PM', nv_region_config('pm_char'));
    $xtpl->assign('TIMESTAMP', $global_config['timestamp']);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('NV_ADMIN_THEME', $admin_info['admin_theme']);
    $xtpl->assign('NV_SAFEMODE', $admin_info['safemode']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('SITE_FAVICON', $site_favicon);
    $xtpl->assign('ADMIN', $admin_info);

    if (!empty($global_config['passshow_button'])) {
        $xtpl->parse('main.passshow_button');
    }

    $theme_tpl = get_tpl_dir([$admin_info['admin_theme'], NV_DEFAULT_ADMIN_THEME], '', '/css/' . $module_file . '.css');
    if (!empty($theme_tpl)) {
        $xtpl->assign('NV_CSS_MODULE_THEME', NV_STATIC_URL . 'themes/' . $theme_tpl . '/css/' . $module_file . '.css');
        $xtpl->parse('main.css_module');
    }

    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('NV_SITE_TIMEZONE_OFFSET', round(NV_SITE_TIMEZONE_OFFSET / 3600));
    $xtpl->assign('NV_CURRENTTIME', nv_date('T', NV_CURRENTTIME));
    $xtpl->assign('NV_COOKIE_PREFIX', $global_config['cookie_prefix']);

    if ($global_config['admin_XSSsanitize']) {
        $xtpl->assign('PURIFY_VERSION', $browser->isBrowser(Browser::BROWSER_IE) ? '2' : '3');
        $xtpl->parse('main.XSSsanitize');
    }

    $theme_tpl = get_tpl_dir([$admin_info['admin_theme'], NV_DEFAULT_ADMIN_THEME], '', '/js/' . $module_file . '.js');
    if (!empty($theme_tpl)) {
        $xtpl->assign('NV_JS_MODULE', NV_STATIC_URL . 'themes/' . $theme_tpl . '/js/' . $module_file . '.js');
        $xtpl->parse('main.module_js');
    }

    if ($head_site == 1) {
        $xtpl->assign('NV_GO_CLIENTSECTOR', $nv_Lang->getGlobal('go_clientsector'));
        $lang_site = (!empty($site_mods)) ? NV_LANG_DATA : $global_config['site_lang'];
        $xtpl->assign('NV_GO_CLIENTSECTOR_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . $lang_site);
        $xtpl->assign('NV_LOGOUT', $nv_Lang->getGlobal('admin_logout_title'));
        $xtpl->assign('NV_GO_ALL_NOTIFICATION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=siteinfo&amp;' . NV_OP_VARIABLE . '=notification');

        if (!empty($array_lang_admin)) {
            $xtpl->assign('NV_LANGDATA_CURRENT', $array_lang_admin[NV_LANG_DATA]);
            $xtpl->assign('NV_LANGINTERFACE_CURRENT', $array_lang_admin[NV_LANG_INTERFACE]);
            foreach ($array_lang_admin as $lang_i => $lang_name) {
                $xtpl->assign('LANGVALUE', $lang_name);
                $xtpl->assign('DATA_DISABLED', ($lang_i == NV_LANG_DATA) ? ' class="disabled"' : '');
                $xtpl->assign('DATA_LANGOP', NV_BASE_ADMINURL . 'index.php?langinterface=' . NV_LANG_INTERFACE . '&' . NV_LANG_VARIABLE . '=' . $lang_i);
                $xtpl->parse('main.lang.data');

                $xtpl->assign('INTERFACE_DISABLED', ($lang_i == NV_LANG_INTERFACE) ? ' class="disabled"' : '');
                $xtpl->assign('INTERFACE_LANGOP', NV_BASE_ADMINURL . 'index.php?langinterface=' . $lang_i . '&' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA);
                $xtpl->parse('main.lang.interface');
            }
            $xtpl->parse('main.lang');
            $xtpl->parse('main.lang1');
        }

        // Top_menu
        $top_menu = $admin_mods;
        if (count($top_menu) > 8) {
            if ($module_name != 'authors') {
                unset($top_menu['authors']);
            }
            if ($module_name != 'language') {
                unset($top_menu['language']);
            }
        }
        foreach ($top_menu as $m => $v) {
            if (!empty($v['custom_title'])) {
                $array_submenu = nv_get_submenu($m);

                $xtpl->assign('TOP_MENU_CLASS', $array_submenu ? ' class="dropdown"' : '');
                $xtpl->assign('TOP_MENU_HREF', $m);
                $xtpl->assign('TOP_MENU_NAME', $v['custom_title']);

                if (!empty($array_submenu)) {
                    $xtpl->parse('main.top_menu_loop.has_sub');

                    foreach ($array_submenu as $mop => $submenu_i) {
                        $xtpl->assign('SUBMENULINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m . '&amp;' . NV_OP_VARIABLE . '=' . $mop);
                        $xtpl->assign('SUBMENUTITLE', $submenu_i);
                        $xtpl->parse('main.top_menu_loop.submenu.submenu_loop');
                    }

                    $xtpl->parse('main.top_menu_loop.submenu');
                }

                $xtpl->parse('main.top_menu_loop');
            }
        }

        $xtpl->parse('main.top_menu');

        // Admin photo
        $xtpl->assign('ADMIN_USERNAME', $admin_info['username']);
        if (isset($admin_info['avata']) and !empty($admin_info['avata'])) {
            $xtpl->assign('ADMIN_PHOTO', $admin_info['avata']);
        } elseif (!empty($admin_info['photo']) and file_exists(NV_ROOTDIR . '/' . $admin_info['photo'])) {
            $xtpl->assign('ADMIN_PHOTO', NV_BASE_SITEURL . $admin_info['photo']);
        } else {
            $xtpl->assign('ADMIN_PHOTO', NV_STATIC_URL . 'themes/default/images/users/no_avatar.png');
        }

        // Vertical menu
        foreach ($admin_menu_mods as $m => $v) {
            $xtpl->assign('MENU_CLASS', (($module_name == $m) ? ' class="active"' : ''));
            $xtpl->assign('MENU_HREF', $m);
            $xtpl->assign('MENU_NAME', $v);

            if ($m != $module_name) {
                $submenu = nv_get_submenu_mod($m);

                $xtpl->assign('MENU_CLASS', $submenu ? ' class="dropdown"' : '');

                if (!empty($submenu)) {
                    foreach ($submenu as $n => $l) {
                        $xtpl->assign('MENU_SUB_HREF', $m);
                        $xtpl->assign('MENU_SUB_OP', $n);
                        $xtpl->assign('MENU_SUB_NAME', (is_array($l) and isset($l['title'])) ? $l['title'] : $l);
                        $xtpl->parse('main.menu_loop.submenu.loop');
                    }
                    $xtpl->parse('main.menu_loop.submenu');
                }
            } elseif (!empty($submenu)) {
                foreach ($submenu as $n => $l) {
                    if (is_array($l) and isset($l['submenu'])) {
                        $_subtitle = $l['title'];
                        $_submenu_i = $l['submenu'];
                    } else {
                        $_subtitle = $l;
                        $_submenu_i = '';
                    }
                    $xtpl->assign('MENU_SUB_CURRENT', (((!empty($op) and $op == $n) or (!empty($set_active_op) and $set_active_op == $n)) ? 'subactive' : 'subcurrent'));
                    $xtpl->assign('MENU_SUB_HREF', $m);
                    $xtpl->assign('MENU_SUB_OP', $n);
                    $xtpl->assign('MENU_SUB_NAME', $_subtitle);
                    $xtpl->assign('MENU_CLASS', '');
                    if (!empty($_submenu_i)) {
                        $xtpl->assign('MENU_CLASS', ' class="dropdown"');
                        foreach ($_submenu_i as $sn => $sl) {
                            $xtpl->assign('CUR_SUB_OP', $sn);
                            $xtpl->assign('CUR_SUB_NAME', $sl);
                            $xtpl->parse('main.menu_loop.current.submenu.loop');
                        }
                        $xtpl->parse('main.menu_loop.current.submenu');
                    }
                    $xtpl->parse('main.menu_loop.current');
                }
            }
            $xtpl->parse('main.menu_loop');
        }

        // Notification icon
        if ($global_config['notification_active']) {
            $xtpl->parse('main.notification');
            $xtpl->parse('main.notification_js');
        }

        // login_session_expire
        if (!empty($global_config['admin_login_duration'])) {
            $xtpl->assign('DURATION', ($admin_info['current_login'] + $global_config['admin_login_duration'] - NV_CURRENTTIME) * 1000);
            $xtpl->parse('main.admin_login_duration');
        }

        // Last login info
        if (!empty($admin_info['hello_admin1'])) {
            $xtpl->parse('main.hello_admin1');
        }
    }

    if (!empty($select_options)) {
        $xtpl->assign('PLEASE_SELECT', $nv_Lang->getGlobal('please_select'));

        foreach ($select_options as $value => $link) {
            $xtpl->assign('SELECT_NAME', $link);
            $xtpl->assign('SELECT_VALUE', $value);
            $xtpl->parse('main.select_option.select_option_loop');
        }

        $xtpl->parse('main.select_option');
    }
    if (isset($site_mods[$module_name]['main_file']) and $site_mods[$module_name]['main_file']) {
        $xtpl->assign('NV_GO_CLIENTMOD', $nv_Lang->getGlobal('go_clientmod'));
        $xtpl->parse('main.site_mods');
    }

    if (isset($array_url_instruction[$op])) {
        $xtpl->assign('NV_INSTRUCTION', $nv_Lang->getGlobal('go_instrucion'));
        $xtpl->assign('NV_URL_INSTRUCTION', $array_url_instruction[$op]);
        $xtpl->parse('main.url_instruction');
    }

    /**
     * Breadcrumbs
     * Note: If active is true, the link will be dismiss
     * If empty $array_mod_title and $page_title, breadcrumbs do not display
     * By default, breadcrumbs is $page_title
     */
    if (empty($array_mod_title) and !empty($page_title)) {
        $array_mod_title = [
            0 => [
                'title' => $page_title,
                'link' => '',
                'active' => true
            ]
        ];
    }

    if (!empty($array_mod_title)) {
        foreach ($array_mod_title as $breadcrumbs) {
            $xtpl->assign('BREADCRUMBS', $breadcrumbs);

            if (!empty($breadcrumbs['active'])) {
                $xtpl->parse('main.breadcrumbs.loop.active');
            }

            if (!empty($breadcrumbs['link']) and empty($breadcrumbs['active'])) {
                $xtpl->parse('main.breadcrumbs.loop.linked');
            } else {
                $xtpl->parse('main.breadcrumbs.loop.text');
            }
            $xtpl->parse('main.breadcrumbs.loop');
        }
        $xtpl->parse('main.breadcrumbs');
    }

    $xtpl->assign('THEME_ERROR_INFO', nv_error_info());
    $xtpl->assign('MODULE_CONTENT', $contents);
    $xtpl->assign('NV_COPYRIGHT', $nv_Lang->getGlobal('copyright', $global_config['site_name']));

    if (defined('CKEDITOR')) {
        $xtpl->parse('main.ckeditor');
    }

    if (defined('NV_IS_SPADMIN') and $admin_info['level'] == 1) {
        $xtpl->parse('main.memory_time_usage');
    }

    if ($client_info['browser']['key'] == 'explorer' and $client_info['browser']['version'] < 9) {
        $xtpl->parse('main.lt_ie9');
    }

    $xtpl->parse('main');
    $sitecontent = $xtpl->text('main');

    if (!empty($my_head)) {
        $sitecontent = preg_replace('/(<\/head>)/i', $my_head . '\\1', $sitecontent, 1);
    }
    if (!empty($my_footer)) {
        $sitecontent = preg_replace('/(<\/body>)/i', $my_footer . '\\1', $sitecontent, 1);
    }

    return $sitecontent;
}

<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$page_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$page_title = $nv_Lang->getModule('security');

$proxy_blocker_list = [
    0 => $nv_Lang->getModule('proxy_blocker_0'),
    1 => $nv_Lang->getModule('proxy_blocker_1'),
    2 => $nv_Lang->getModule('proxy_blocker_2'),
    3 => $nv_Lang->getModule('proxy_blocker_3')
];
$captcha_opts = ['', 'captcha', 'recaptcha', 'turnstile'];
$captcha_area_list = ['a', 'l', 'r', 'm', 'p'];
$recaptcha_vers = [2, 3];
$captcha_comm_list = [
    0 => $nv_Lang->getModule('captcha_comm_0'),
    1 => $nv_Lang->getModule('captcha_comm_1'),
    2 => $nv_Lang->getModule('captcha_comm_2'),
    3 => $nv_Lang->getModule('captcha_comm_3')
];

$recaptcha_type_list = ['image' => $nv_Lang->getModule('recaptcha_type_image'), 'audio' => $nv_Lang->getModule('recaptcha_type_audio')];
$admin_2step_providers = ['key', 'code', 'facebook', 'google', 'zalo'];
$iptypes = [
    4 => 'IPv4',
    6 => 'IPv6'
];
$ipv4_mask_list = [
    0 => '255.255.255.255',
    3 => '255.255.255.xxx',
    2 => '255.255.xxx.xxx',
    1 => '255.xxx.xxx.xxx'
];
$banip_area_list = [$nv_Lang->getModule('area_select'), $nv_Lang->getModule('area_front'), $nv_Lang->getModule('area_admin'), $nv_Lang->getModule('area_both')];
$csp_directives = [
    'default-src' => ['none' => 0, 'all' => 0, 'self' => 0, 'data' => 0, 'unsafe-inline' => 0, 'unsafe-eval' => 0, 'hosts' => []],
    'script-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'data' => 0, 'unsafe-inline' => 1, 'unsafe-eval' => 1, 'hosts' => ['*.google.com', '*.google-analytics.com', '*.googletagmanager.com', '*.gstatic.com', '*.facebook.com', '*.facebook.net', '*.twitter.com', '*.zalo.me', '*.zaloapp.com', '*.tawk.to', '*.cloudflareinsights.com', '*.cloudflare.com']],
    'style-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'data' => 1, 'unsafe-inline' => 1, 'hosts' => ['*.google.com', '*.googleapis.com', '*.tawk.to']],
    'img-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'data' => 1, 'hosts' => ['*.twitter.com', '*.google.com', '*.googleapis.com', '*.gstatic.com', '*.facebook.com', 'tawk.link', '*.tawk.to', 'static.nukeviet.vn']],
    'font-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'data' => 1, 'hosts' => ['*.googleapis.com', '*.gstatic.com', '*.tawk.to']],
    'connect-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => ['*.zalo.me', '*.tawk.to', 'wss://*.tawk.to']],
    'media-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => ['*.tawk.to']],
    'object-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => []],
    'prefetch-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => []],
    'frame-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => ['*.google.com', '*.youtube.com', '*.facebook.com', '*.facebook.net', '*.twitter.com', '*.zalo.me']],
    'frame-ancestors' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => []],
    'form-action' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => ['*.google.com']],
    'base-uri' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => []],
    'manifest-src' => ['none' => 0, 'all' => 0, 'self' => 1, 'hosts' => []]
];
$rp_directives = [
    'no-referrer' => $nv_Lang->getModule('rp_no_referrer'),
    'no-referrer-when-downgrade' => $nv_Lang->getModule('rp_no_referrer_when_downgrade'),
    'origin' => $nv_Lang->getModule('rp_origin'),
    'origin-when-cross-origin' => $nv_Lang->getModule('rp_origin_when_cross_origin'),
    'same-origin' => $nv_Lang->getModule('rp_same_origin'),
    'strict-origin' => $nv_Lang->getModule('rp_strict_origin'),
    'strict-origin-when-cross-origin' => $nv_Lang->getModule('rp_strict_origin_when_cross_origin'),
    'unsafe-url' => $nv_Lang->getModule('rp_unsafe_url')
];
$pp_default = [
    'ignore' => 1,
    'none' => 0,
    'all' => 0,
    'self' => 0,
    'hosts' => []
];
$pp_directives = [
    'accelerometer' => $pp_default,
    'ambient-light-sensor' => $pp_default,
    'autoplay' => $pp_default,
    'battery' => $pp_default,
    'browsing-topics' => $pp_default, // Thay thế cho interest-cohort
    'camera' => $pp_default,
    'display-capture' => $pp_default,
    'document-domain' => $pp_default,
    'encrypted-media' => $pp_default,
    'execution-while-not-rendered' => $pp_default,
    'execution-while-out-of-viewport' => $pp_default,
    'fullscreen' => $pp_default,
    'gamepad' => $pp_default,
    'geolocation' => $pp_default,
    'gyroscope' => $pp_default,
    'hid' => $pp_default,
    'identity-credentials-get' => $pp_default,
    'idle-detection' => $pp_default,
    'local-fonts' => $pp_default,
    'magnetometer' => $pp_default,
    'microphone' => $pp_default,
    'midi' => $pp_default,
    'otp-credentials' => $pp_default,
    'payment' => $pp_default,
    'picture-in-picture' => $pp_default,
    'publickey-credentials-create' => $pp_default,
    'publickey-credentials-get' => $pp_default,
    'screen-wake-lock' => $pp_default,
    'serial' => $pp_default,
    'speaker-selection' => $pp_default,
    'storage-access' => $pp_default,
    'usb' => $pp_default,
    'web-share' => $pp_default,
    'window-management' => $pp_default,
    'xr-spatial-tracking' => $pp_default,
];

$max_tab = 7;
$selectedtab = $nv_Request->get_int('selectedtab', 'get,post', 0);
if (!defined('NV_IS_GODADMIN')) {
    if ($selectedtab < 5 or $selectedtab > $max_tab) {
        $selectedtab = 5;
    }
} elseif ($selectedtab < 0 or $selectedtab > $max_tab) {
    $selectedtab = 0;
}

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_info['userid']);

// Xử lý các thiết lập cơ bản
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('basicsave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [
        'str_referer_blocker' => (int) $nv_Request->get_bool('str_referer_blocker', 'post'),
        'is_login_blocker' => (int) $nv_Request->get_bool('is_login_blocker', 'post', false),
        'login_number_tracking' => $nv_Request->get_int('login_number_tracking', 'post', 0),
        'login_time_tracking' => $nv_Request->get_int('login_time_tracking', 'post', 0),
        'login_time_ban' => $nv_Request->get_int('login_time_ban', 'post', 0),
        'two_step_verification' => $nv_Request->get_int('two_step_verification', 'post', 0),
        'admin_2step_opt' => $nv_Request->get_typed_array('admin_2step_opt', 'post', 'title', []),
        'admin_2step_default' => $nv_Request->get_title('admin_2step_default', 'post', ''),
        'domains_restrict' => (int) $nv_Request->get_bool('domains_restrict', 'post', false),
        'XSSsanitize' => (int) $nv_Request->get_bool('XSSsanitize', 'post', false),
        'admin_XSSsanitize' => (int) $nv_Request->get_bool('admin_XSSsanitize', 'post', false),
        'passshow_button' => $nv_Request->get_int('passshow_button', 'post', 0),
        'request_uri_check' => $nv_Request->get_title('request_uri_check', 'post', 'page')
    ];
    $proxy_blocker = $nv_Request->get_int('proxy_blocker', 'post');
    if (isset($proxy_blocker_list[$proxy_blocker])) {
        $post['proxy_blocker'] = $proxy_blocker;
    }

    $domains = $nv_Request->get_textarea('domains_whitelist', '', NV_ALLOWED_HTML_TAGS, true);
    $domains = explode('<br />', strip_tags($domains, '<br>'));

    $post['domains_whitelist'] = [];
    foreach ($domains as $domain) {
        if (!empty($domain)) {
            $domain = parse_url($domain);
            if (is_array($domain)) {
                if (count($domain) == 1 and !empty($domain['path'])) {
                    $domain['host'] = $domain['path'];
                }
                if (!isset($domain['scheme'])) {
                    $domain['scheme'] = 'http';
                }
                $domain_name = nv_check_domain($domain['host']);
                if (!empty($domain_name)) {
                    $post['domains_whitelist'][] = $domain_name;
                }
            }
        }
    }
    $post['domains_whitelist'] = empty($post['domains_whitelist']) ? '' : json_encode(array_unique($post['domains_whitelist']));

    $post['login_number_tracking'] < 1 && $post['login_number_tracking'] = 5;
    $post['login_time_tracking'] <= 0 && $post['login_time_tracking'] = 5;
    if ($post['two_step_verification'] < 0 or $post['two_step_verification'] > 3) {
        $post['two_step_verification'] = 0;
    }
    $post['admin_2step_opt'] = array_intersect($post['admin_2step_opt'], $admin_2step_providers);
    if (!in_array($post['admin_2step_default'], $admin_2step_providers, true)) {
        $post['admin_2step_default'] = '';
    }
    if (!in_array($post['admin_2step_default'], $post['admin_2step_opt'], true)) {
        $post['admin_2step_default'] = current($post['admin_2step_opt']);
    }
    if ($post['admin_2step_default'] == 'key') {
        $post['admin_2step_default'] = 'code';
    }
    $post['admin_2step_opt'] = empty($post['admin_2step_opt']) ? '' : implode(',', $post['admin_2step_opt']);

    $end_url_variables = $nv_Request->get_typed_array('end_url_variables', 'post', 'title', []);
    $parameters = $nv_Request->get_typed_array('parameters', 'post', 'title', []);

    $_end_url_variables = [];
    if (!empty($end_url_variables)) {
        foreach ($end_url_variables as $key => $variable) {
            if (preg_match('/^[a-zA-Z0-9\_]+$/', $variable)) {
                $vals = !empty($parameters[$key]) ? array_filter(array_map(function ($parameter) {
                    $parameter = trim($parameter);
                    if (!in_array($parameter, ['lower', 'upper', 'number', 'dash', 'under', 'dot', 'at'], true)) {
                        $parameter = '';
                    }

                    return $parameter;
                }, explode(',', $parameters[$key]))) : [];

                if (!empty($vals)) {
                    $_end_url_variables[$variable] = $vals;
                }
            }
        }
    }
    $post['end_url_variables'] = !empty($_end_url_variables) ? json_encode($_end_url_variables) : '';

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'global' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $post = [
        'nv_anti_agent' => (int) $nv_Request->get_bool('nv_anti_agent', 'post'),
        'nv_anti_iframe' => (int) $nv_Request->get_bool('nv_anti_iframe', 'post')
    ];

    $variable = $nv_Request->get_string('nv_allowed_html_tags', 'post');
    $variable = str_replace(';', ',', strtolower($variable));
    $variable = explode(',', $variable);
    $nv_allowed_html_tags = [];
    foreach ($variable as $value) {
        $value = trim($value);
        if (preg_match('/^[a-z0-9]+$/', $value) and !in_array($value, $nv_allowed_html_tags, true)) {
            $nv_allowed_html_tags[] = $value;
        }
    }
    $post['nv_allowed_html_tags'] = implode(', ', $nv_allowed_html_tags);

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'define' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_save_file_config_global();

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Chống Flood
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('floodsave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [
        'is_flood_blocker' => (int) $nv_Request->get_bool('is_flood_blocker', 'post'),
        'max_requests_60' => $nv_Request->get_int('max_requests_60', 'post'),
        'max_requests_300' => $nv_Request->get_int('max_requests_300', 'post')
    ];

    if ($post['max_requests_60'] <= 0 or $post['max_requests_300'] <= 0) {
        nv_jsonOutput([
            'status' => 'error',
            'mess' => $nv_Lang->getModule('max_requests_error')
        ]);
    }

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'global' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_save_file_config_global();

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->registerPlugin('modifier', 'str_contains', 'str_contains');
$tpl->registerPlugin('modifier', 'str_pad', 'str_pad');
$tpl->setTemplateDir(get_module_tpl_dir('security.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

// Thêm/sửa IP
$action = $nv_Request->get_title('action', 'get', '');
if (defined('NV_IS_GODADMIN') and ($action == 'fip' or $action == 'bip')) {
    $page_url .= '&amp;action=' . $action;

    $id = $nv_Request->get_int('id', 'get', 0);
    $type = $action == 'fip' ? 1 : 0;
    if (!empty($id)) {
        $ipdetails = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_ips WHERE id=' . $id . ' AND type=' . $type)->fetch();
        if (empty($ipdetails)) {
            exit('IP not found in database');
        }

        $page_url .= '&amp;id=' . $id;
        $version = $ips->isIp4($ipdetails['ip']) ? 4 : 6;
    } else {
        $ipdetails = [
            'id' => 0,
            'type' => $type,
            'mask' => 0,
            'area' => 0,
            'begintime' => 0,
            'endtime' => 0,
            'notice' => '',
            'ip' => '',
        ];
        $version = 4;
    }

    if ($nv_Request->isset_request('save', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
        $post = [
            'version' => $nv_Request->get_int('version', 'post', 4),
            'ip' => $nv_Request->get_title('ip', 'post', ''),
            'mask' => $nv_Request->get_int('mask', 'post', 0),
            'area' => $nv_Request->get_int('area', 'post', 0)
        ];
        $post['version'] != 6 && $post['version'] = 4;

        if (empty($post['ip'])) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('ip_not_entered')
            ]);
        }

        if (($post['version'] == 4 and !$ips->isIp4($post['ip'])) or ($post['version'] == 6 and !$ips->isIp6($post['ip']))) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('ip_incorrect')
            ]);
        }

        if (!$type and empty($post['area'])) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('area_not_selected')
            ]);
        }

        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('begintime', 'post'), $m)) {
            $post['begintime'] = mktime($nv_Request->get_int('beginhour', 'post'), $nv_Request->get_int('beginmin', 'post'), 0, $m[2], $m[1], $m[3]);
        } else {
            $post['begintime'] = NV_CURRENTTIME;
        }

        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('endtime', 'post'), $m)) {
            $post['endtime'] = mktime($nv_Request->get_int('endhour', 'post'), $nv_Request->get_int('endmin', 'post'), 0, $m[2], $m[1], $m[3]);
        } else {
            $post['endtime'] = 0;
        }

        if (!empty($post['endtime']) and $post['endtime'] < $post['begintime']) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('end_time_error')
            ]);
        }

        $type && $post['area'] = 1;

        if ($post['version'] == 4) {
            ($post['mask'] < 0 or $post['mask'] > 3) && $post['mask'] = 0;
        } else {
            ($post['mask'] < 1 or $post['mask'] > 128) && $post['mask'] = 128;
        }

        $post['notice'] = $nv_Request->get_title('notice', 'post', '', 1);

        if ($id) {
            $db->query('DELETE FROM ' . $db_config['prefix'] . '_ips WHERE type = ' . $type . ' AND ip = ' . $db->quote($post['ip']) . ' AND id != ' . $id);
            $sth = $db->prepare('UPDATE ' . $db_config['prefix'] . '_ips
                SET ip = :ip, mask = ' . $post['mask'] . ', area = ' . $post['area'] . ', begintime = ' . $post['begintime'] . ', endtime = ' . $post['endtime'] . ', notice = :notice
                WHERE id=' . $id);
        } else {
            $db->query('DELETE FROM ' . $db_config['prefix'] . '_ips WHERE type = ' . $type . ' AND ip = ' . $db->quote($post['ip']));
            $sth = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_ips (type, ip, mask, area, begintime, endtime, notice) VALUES
            (' . $type . ', :ip, ' . $post['mask'] . ', ' . $post['area'] . ', ' . $post['begintime'] . ', ' . $post['endtime'] . ', :notice )');
        }
        $sth->bindParam(':ip', $post['ip'], PDO::PARAM_STR);
        $sth->bindParam(':notice', $post['notice'], PDO::PARAM_STR);
        $sth->execute();

        $save = nv_save_file_ips($type);

        if ($save !== true) {
            $mess = $type ? $nv_Lang->getModule('ip_write_error', NV_DATADIR, 'efloodip.php') : $nv_Lang->getModule('ip_write_error', NV_DATADIR, 'banip.php');
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $mess . "\n\n" . $save
            ]);
        }

        nv_jsonOutput([
            'status' => 'OK',
            'type' => $type,
            'url' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&action=' . ($type ? 'fiplist' : 'biplist')
        ]);
    }

    if (!empty($ipdetails['begintime'])) {
        [$ipdetails['begintime'], $beginhour, $beginmin] = explode('|', date('d/m/Y|H|i', $ipdetails['begintime']));
    } else {
        $ipdetails['begintime'] = '';
        $beginhour = $beginmin = 0;
    }
    if (!empty($ipdetails['endtime'])) {
        [$ipdetails['endtime'], $endhour, $endmin] = explode('|', date('d/m/Y|H|i', $ipdetails['endtime']));
    } else {
        $ipdetails['endtime'] = '';
        $endhour = 23;
        $endmin = 59;
    }

    $tpl->assign('CHECKSS', $checkss);
    $tpl->assign('IPTYPES', $iptypes);
    $tpl->assign('VERSION', $version);
    $tpl->assign('DATA', $ipdetails);
    $tpl->assign('MASK_LIST', $ipv4_mask_list);
    $tpl->assign('BEGINHOUR', $beginhour);
    $tpl->assign('BEGINMIN', $beginmin);
    $tpl->assign('ENDHOUR', $endhour);
    $tpl->assign('ENDMIN', $endmin);
    $tpl->assign('FORM_TYPE', $type);
    $tpl->assign('AREA_LIST', $banip_area_list);
    $tpl->assign('FORM_ACTION', $page_url);

    $contents = $tpl->fetch('security-ip-form.tpl');

    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Xóa IP
if (defined('NV_IS_GODADMIN') and ($action == 'delfip' or $action == 'delbip') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $type = $action == 'delfip' ? 1 : 0;
    if (!empty($id)) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_ips WHERE type = ' . $type . ' AND id = ' . $id);
    }

    $save = nv_save_file_ips($type);

    if ($save !== true) {
        $mess = $type ? $nv_Lang->getModule('ip_write_error', NV_DATADIR, 'efloodip.php') : $nv_Lang->getModule('ip_write_error', NV_DATADIR, 'banip.php');
        nv_jsonOutput([
            'status' => 'error',
            'mess' => $mess . "\n\n" . $save
        ]);
    }

    nv_jsonOutput([
        'status' => 'OK',
        'type' => $type,
        'url' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&action=' . ($type ? 'fiplist' : 'biplist')
    ]);
}

// Lấy danh sách IP
if (defined('NV_IS_GODADMIN') and ($action == 'fiplist' or $action == 'biplist')) {
    $type = $action == 'fiplist' ? 1 : 0;
    $iplist = get_list_ips($type);

    $tpl->assign('IPS', $iplist);

    $contents = $tpl->fetch('security-ips.tpl');

    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Cấu hình captcha chung
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('captchasave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [
        'recaptcha_ver' => $nv_Request->get_int('recaptcha_ver', 'post', 2),
        'recaptcha_sitekey' => $nv_Request->get_title('recaptcha_sitekey', 'post', ''),
        'recaptcha_secretkey' => $nv_Request->get_title('recaptcha_secretkey', 'post', ''),
        'recaptcha_type' => $nv_Request->get_title('recaptcha_type', 'post', '')
    ];

    if (!isset($recaptcha_type_list[$post['recaptcha_type']])) {
        $post['recaptcha_type'] = array_key_first($recaptcha_type_list);
    }
    if (!empty($post['recaptcha_secretkey'])) {
        $post['recaptcha_secretkey'] = $crypt->encrypt($post['recaptcha_secretkey']);
    }

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'global' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $post = [
        'nv_gfx_num' => $nv_Request->get_int('nv_gfx_num', 'post'),
        'nv_gfx_width' => $nv_Request->get_int('nv_gfx_width', 'post'),
        'nv_gfx_height' => $nv_Request->get_int('nv_gfx_height', 'post')
    ];

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'define' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $post = [
        'turnstile_sitekey' => $nv_Request->get_title('turnstile_sitekey', 'post'),
        'turnstile_secretkey' => $nv_Request->get_title('turnstile_secretkey', 'post'),
    ];

    if (!empty($post['turnstile_secretkey'])) {
        $post['turnstile_secretkey'] = $crypt->encrypt($post['turnstile_secretkey']);
    }

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'global' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_save_file_config_global();

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Cấu hình hiển thị captcha cho từng module
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('modcapt', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $mod_capts = $nv_Request->get_typed_array('captcha_type', 'post', 'title', '');
    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = :lang AND module = :module AND config_name = 'captcha_type'");
    foreach ($mod_capts as $mod => $type) {
        unset($lg, $modl);
        if (empty($type) or in_array($type, $captcha_opts, true)) {
            if ($mod == 'users' and $type != $global_config['captcha_type']) {
                $lg = 'sys';
                $modl = 'site';
            } elseif ($mod == 'banners' and $type != $module_config['banners']['captcha_type']) {
                $lg = 'sys';
                $modl = 'banners';
            } elseif (isset($module_config[$mod]['captcha_type']) and $type != $module_config[$mod]['captcha_type']) {
                $lg = NV_LANG_DATA;
                $modl = $mod;
            }
        }
        if (isset($lg, $modl)) {
            $sth->bindParam(':config_value', $type, PDO::PARAM_STR);
            $sth->bindParam(':lang', $lg, PDO::PARAM_STR);
            $sth->bindParam(':module', $modl, PDO::PARAM_STR);
            $sth->execute();
        }
    }

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Khu vực sử dụng captcha của module Thành viên
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('captarea', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $captcha_areas = $nv_Request->get_typed_array('captcha_area', 'post', 'string');
    $captcha_areas = !empty($captcha_areas) ? implode(',', $captcha_areas) : '';
    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'site' AND config_name = 'captcha_area'");
    $sth->bindParam(':config_value', $captcha_areas, PDO::PARAM_STR);
    $sth->execute();

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Đối tượng áp dụng captcha khi tham gia Bình luận
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('captcommarea', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $captcha_areas_comm = $nv_Request->get_typed_array('captcha_area_comm', 'post', 'int', 0);
    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module AND config_name = 'captcha_area_comm'");
    foreach ($captcha_areas_comm as $mod => $area) {
        if (isset($module_config[$mod]['captcha_area_comm'], $module_config[$mod]['activecomm'], $captcha_comm_list[$area])) {
            $sth->bindParam(':config_value', $area, PDO::PARAM_STR);
            $sth->bindParam(':module', $mod, PDO::PARAM_STR);
            $sth->execute();
        }
    }

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Xử lý thiết lập CORS, Anti CSRF
if (defined('NV_IS_GODADMIN') and $nv_Request->isset_request('corssave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [
        'crosssite_restrict' => (int) $nv_Request->get_bool('crosssite_restrict', 'post', false),
        'crossadmin_restrict' => (int) $nv_Request->get_bool('crossadmin_restrict', 'post', false)
    ];

    // Lấy các request domain
    $cfg_keys = ['crosssite_valid_domains', 'crossadmin_valid_domains'];
    foreach ($cfg_keys as $cfg_key) {
        $domains = $nv_Request->get_textarea($cfg_key, '', NV_ALLOWED_HTML_TAGS, true);
        $domains = explode('<br />', strip_tags($domains, '<br>'));

        $post[$cfg_key] = [];
        foreach ($domains as $domain) {
            $domain = trim($domain);
            if (!empty($domain)) {
                $domain = parse_url($domain);
                if (is_array($domain)) {
                    if (count($domain) == 1 and !empty($domain['path'])) {
                        $domain['host'] = $domain['path'];
                    }
                    !isset($domain['scheme']) && $domain['scheme'] = 'http';
                    if (($domain_name = nv_check_domain($domain['host'])) != '') {
                        $post[$cfg_key][] = $domain['scheme'] . '://' . $domain_name . ((isset($domain['port']) and $domain['port'] != '80') ? (':' . $domain['port']) : '');
                    }
                }
            }
        }
        $post[$cfg_key] = empty($post[$cfg_key]) ? '' : json_encode(array_unique($post[$cfg_key]));
    }

    // Lấy các request IPs
    $cfg_keys = ['crosssite_valid_ips', 'crossadmin_valid_ips', 'ip_allow_null_origin'];
    foreach ($cfg_keys as $cfg_key) {
        $str_ips = $nv_Request->get_textarea($cfg_key, '', NV_ALLOWED_HTML_TAGS, true);
        $str_ips = explode('<br />', strip_tags($str_ips, '<br>'));

        $post[$cfg_key] = [];
        foreach ($str_ips as $str_ip) {
            $str_ip = trim($str_ip);
            if ($ips->isIp4($str_ip) or $ips->isIp6($str_ip)) {
                $post[$cfg_key][] = $str_ip;
            }
        }
        $post[$cfg_key] = empty($post[$cfg_key]) ? '' : json_encode(array_unique($post[$cfg_key]));
    }

    // Lấy các request có biến được chấp nhận
    $crosssite_allowed_variables = $nv_Request->get_textarea('crosssite_allowed_variables', '', NV_ALLOWED_HTML_TAGS, true);
    $crosssite_allowed_variables = explode('<br />', strip_tags($crosssite_allowed_variables, '<br>'));
    $res = [];
    if (!empty($crosssite_allowed_variables)) {
        foreach ($crosssite_allowed_variables as $variable) {
            if (!empty($variable)) {
                parse_str($variable, $result);
                $_res = [];
                foreach ($result as $k => $v) {
                    if (preg_match('/^[a-zA-Z0-9\_]+$/', $k) and (empty($v) or preg_match('/^[a-zA-Z0-9\-\_\.\@]+$/', $v))) {
                        $_res[$k] = $v;
                    }
                }

                if (!empty($_res)) {
                    $res[] = $_res;
                }
            }
        }
    }

    $post['crosssite_allowed_variables'] = empty($res) ? '' : json_encode($res);
    $post['allow_null_origin'] = (int) $nv_Request->get_bool('allow_null_origin', 'post', false);
    $post['auto_acao'] = (int) $nv_Request->get_bool('auto_acao', 'post', false);
    $post['load_files_seccode'] = $nv_Request->get_string('load_files_seccode', 'post', '');
    !empty($post['load_files_seccode']) && $post['load_files_seccode'] = $crypt->encrypt($post['load_files_seccode']);

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value=:config_value WHERE lang='sys' AND module='global' AND config_name=:config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_CHANGE_CORS_SETTING', json_encode($post), $admin_info['userid']);
    nv_save_file_config_global();

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Thiết lập CSP
if ($nv_Request->isset_request('cspsave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $_directives = $_POST['directives'];
    $directives = [];
    foreach ($_directives as $directive => $sources) {
        $rs = [];
        foreach ($sources as $source => $val) {
            if (!empty($val)) {
                if ($source == 'hosts') {
                    $val = strip_tags($val);
                    $val = array_map('trim', explode("\n", $val));
                    $val = array_unique($val);
                } else {
                    $val = 1;
                }
                $rs[$source] = $val;
            }
        }
        if (!empty($rs)) {
            $directives[$directive] = $rs;
        }
    }

    $post = [
        'nv_csp' => json_encode($directives),
        'nv_csp_act' => (int) $nv_Request->get_bool('nv_csp_act', 'post', false),
        'nv_csp_script_nonce' => (int) $nv_Request->get_bool('nv_csp_script_nonce', 'post', false)
    ];

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'site' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->execute();
    }

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Thiết lập RP
if ($nv_Request->isset_request('rpsave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [];
    $post['nv_rp'] = [];
    $nv_rp = $nv_Request->get_title('nv_rp', 'post', '');
    if (!empty($nv_rp)) {
        $nv_rp = preg_replace("/[^a-zA-Z\-]/", ' ', $nv_rp);
        $nv_rp = preg_replace("/[\s]+/", ' ', $nv_rp);
    }
    $nv_rp = !empty($nv_rp) ? array_map('trim', explode(' ', $nv_rp)) : [];
    foreach ($nv_rp as $rp) {
        if (!empty($rp) and isset($rp_directives[$rp]) and $rp != 'no-referrer') {
            $post['nv_rp'][] = $rp;
        }
    }
    $post['nv_rp'] = !empty($post['nv_rp']) ? implode(', ', $post['nv_rp']) : '';
    $post['nv_rp_act'] = (int) $nv_Request->get_bool('nv_rp_act', 'post', false);

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'site' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->execute();
    }

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

// Thiết lập PP
if ($nv_Request->isset_request('ppsave', 'post') and $checkss == $nv_Request->get_string('checkss', 'post')) {
    $post = [];
    $post['nv_pp'] = [];
    $post['nv_fp'] = [];
    $post['nv_pp_act'] = (int) $nv_Request->get_bool('nv_pp_act', 'post', false);
    $post['nv_fp_act'] = (int) $nv_Request->get_bool('nv_fp_act', 'post', false);

    $postvs = $nv_Request->get_array('directives', 'post', []);
    foreach ($pp_directives as $directive => $sources) {
        if (!isset($postvs[$directive]) or !is_array($postvs[$directive]) or !empty($postvs[$directive]['ignore'])) {
            continue;
        }
        $rs = $rs_fp = [];
        if (!empty($postvs[$directive]['all'])) {
            $rs = '*';
            $rs_fp = '*';
        } elseif (!empty($postvs[$directive]['none'])) {
            $rs = '()';
            $rs_fp = "'none'";
        } else {
            if (!empty($postvs[$directive]['self'])) {
                $rs[] = 'self';
                $rs_fp[] = "'self'";
            }
            $hosts = empty($postvs[$directive]['hosts']) ? [] : array_filter(array_unique(array_map('trim', explode('<nv>', nv_nl2br(nv_strtolower(strip_tags($postvs[$directive]['hosts'])), '<nv>')))));
            foreach ($hosts as $host) {
                if (!preg_match('/^[a-z]+\:\/\/[\w\.\-\*]+$/u', $host)) {
                    continue;
                }
                $rs[] = '"' . $host . '"';

                // FP không hỗ trợ wildcard do đó loại bỏ các dòng wildcard
                if (strpos($host, '*') === false) {
                    $rs_fp[] = $host;
                }
            }
        }

        if (!empty($rs) and is_array($rs)) {
            $rs = '(' . implode(' ', $rs) . ')';
        }
        if (!empty($rs_fp) and is_array($rs_fp)) {
            $rs_fp = implode(' ', $rs_fp);
        }

        if (!empty($rs)) {
            $post['nv_pp'][] = $directive . '=' . $rs;
        }
        if (!empty($rs_fp)) {
            $post['nv_fp'][] = $directive . ' ' . $rs_fp;
        }
    }

    $post['nv_pp'] = empty($post['nv_pp']) ? '' : implode(', ', $post['nv_pp']);
    $post['nv_fp'] = empty($post['nv_fp']) ? '' : implode('; ', $post['nv_fp']);

    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = 'sys' AND module = 'site' AND config_name = :config_name");
    foreach ($post as $config_name => $config_value) {
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->execute();
    }

    $nv_Cache->delMod('settings');

    nv_jsonOutput([
        'status' => 'OK',
        'mess' => $nv_Lang->getGlobal('save_success')
    ]);
}

$global_config_list = $global_config;
$global_config_list['admin_2step_opt'] = empty($global_config['admin_2step_opt']) ? [] : explode(',', $global_config['admin_2step_opt']);
$global_config_list['domains_whitelist'] = empty($global_config['domains_whitelist']) ? '' : implode("\n", $global_config['domains_whitelist']);

$define_config_list = [
    'nv_anti_agent' => NV_ANTI_AGENT,
    'nv_anti_iframe' => NV_ANTI_IFRAME,
    'nv_allowed_html_tags' => NV_ALLOWED_HTML_TAGS
];

$flood_config_list = [
    'is_flood_blocker' => $global_config['is_flood_blocker'],
    'max_requests_60' => $global_config['max_requests_60'],
    'max_requests_300' => $global_config['max_requests_300']
];

$captcha_config_list = $global_config;
$array_define_captcha = [
    'nv_gfx_num' => NV_GFX_NUM,
    'nv_gfx_width' => NV_GFX_WIDTH,
    'nv_gfx_height' => NV_GFX_HEIGHT
];

$cross_config_list = [
    'crosssite_restrict' => $global_config['crosssite_restrict'],
    'crosssite_valid_domains' => empty($global_config['crosssite_valid_domains']) ? '' : implode("\n", $global_config['crosssite_valid_domains']),
    'crosssite_valid_ips' => empty($global_config['crosssite_valid_ips']) ? '' : implode("\n", $global_config['crosssite_valid_ips']),
    'crossadmin_restrict' => $global_config['crossadmin_restrict'],
    'crossadmin_valid_domains' => empty($global_config['crossadmin_valid_domains']) ? '' : implode("\n", $global_config['crossadmin_valid_domains']),
    'crossadmin_valid_ips' => empty($global_config['crossadmin_valid_ips']) ? '' : implode("\n", $global_config['crossadmin_valid_ips']),
    'allow_null_origin' => $global_config['allow_null_origin'],
    'ip_allow_null_origin' => empty($global_config['ip_allow_null_origin']) ? '' : implode("\n", $global_config['ip_allow_null_origin']),
    'load_files_seccode' => !empty($global_config['load_files_seccode']) ? $crypt->decrypt($global_config['load_files_seccode']) : '',
    'auto_acao' => !empty($global_config['auto_acao']) ? $global_config['auto_acao'] : 0
];
if (!empty($global_config['crosssite_allowed_variables'])) {
    $res = [];
    foreach ($global_config['crosssite_allowed_variables'] as $variable) {
        $res[] = http_build_query($variable);
    }
    $cross_config_list['crosssite_allowed_variables'] = implode("\n", $res);
} else {
    $cross_config_list['crosssite_allowed_variables'] = '';
}

$nv_Lang->setModule('two_step_verification_note', $nv_Lang->getModule('two_step_verification_note', $nv_Lang->getModule('two_step_verification0'), NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=groups'));

if (!empty($global_config['nv_csp'])) {
    $directives = json_decode($global_config['nv_csp'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $directives = $csp_directives;
    }
} else {
    $directives = [];
}

/*
 * Xử lý ngược pp trong DB thành biến.
 * Trong DB lưu giá trị thân thiện mục đích để dùng ngay vào header không phải qua xử lý tốn tài nguyên nữa
 */
$ppval_directives = [];
$_directives = !empty($global_config['nv_pp']) ? array_map('trim', explode(',', $global_config['nv_pp'])) : [];
foreach ($_directives as $_dvs) {
    if (preg_match('/^([a-z0-9\-]+)[\s]*\=[\s]*(.*?)$/i', $_dvs, $m)) {
        if (!isset($pp_directives[$m[1]])) {
            continue;
        }
        $name = $m[1];
        $ppval_directives[$name] = [
            'ignore' => 0,
            'none' => 0,
            'all' => 0,
            'self' => 0,
            'hosts' => []
        ];
        $_dv = trim($m[2]);
        if ($_dv == '*') {
            // Cho phép tất cả
            $ppval_directives[$name]['all'] = 1;
        } elseif ($_dv == '()') {
            // Cấm tất cả
            $ppval_directives[$name]['none'] = 1;
        } elseif (!empty($_dv)) {
            // Trường hợp còn lại có thể là self + các domain
            $_dv = explode('<nv>', preg_replace('/[\s]+/', '<nv>', trim(str_replace(['(', ')', '"'], '', $_dv))));
            foreach ($_dv as $_dvi) {
                if (empty($_dvi)) {
                    continue;
                }
                if ($_dvi == 'self') {
                    $ppval_directives[$name]['self'] = 1;
                } else {
                    $ppval_directives[$name]['hosts'][] = $_dvi;
                }
            }
        }
    }
}
unset($_directives);

empty($global_config_list['end_url_variables']) && $global_config_list['end_url_variables'][] = [];

$tpl->assign('SELECTEDTAB', $selectedtab);
$tpl->assign('CHECKSS', $checkss);
$tpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$tpl->assign('GDATA', $global_config_list);
$tpl->assign('DDATA', $define_config_list);
$tpl->assign('FDATA', $flood_config_list);
$tpl->assign('DATA', $global_config);

$passshow_button_opts = [$nv_Lang->getModule('passshow_button_0'), $nv_Lang->getModule('passshow_button_1'), $nv_Lang->getModule('passshow_button_2'), $nv_Lang->getModule('passshow_button_3')];
$tpl->assign('PASSSHOW_BUTTON_OPTS', $passshow_button_opts);
$tpl->assign('ADMIN_2STEP_PROVIDERS', $admin_2step_providers);
$tpl->assign('PROXY_BLOCKER_LIST', $proxy_blocker_list);

$uri_check_values = [
    'page' => $nv_Lang->getModule('request_uri_check_page'),
    'not' => $nv_Lang->getModule('request_uri_check_not'),
    'path' => $nv_Lang->getModule('request_uri_check_path'),
    'query' => $nv_Lang->getModule('request_uri_check_query'),
    'abs' => $nv_Lang->getModule('request_uri_check_abs')
];
$tpl->assign('URI_CHECK_VALUES', $uri_check_values);
$tpl->assign('RECAPTCHA_VERS', $recaptcha_vers);
$tpl->assign('RECAPTCHA_TYPE_LIST', $recaptcha_type_list);
$tpl->assign('SITE_MODS', $site_mods);
$tpl->assign('MODULE_CONFIG', $module_config);
$tpl->assign('CAPTCHA_OPTS', $captcha_opts);
$tpl->assign('CAPTCHA_AREA_LIST', $captcha_area_list);
$tpl->assign('CAPTCHA_COMM_LIST', $captcha_comm_list);

if (defined('NV_IS_GODADMIN')) {
    $tpl->assign('RECAPTCHA_SITEKEY', $captcha_config_list['recaptcha_sitekey']);
    $tpl->assign('RECAPTCHA_SECRETKEY', $captcha_config_list['recaptcha_secretkey'] ? $crypt->decrypt($captcha_config_list['recaptcha_secretkey']) : '');
    $tpl->assign('TURNSTILE_SITEKEY', $captcha_config_list['turnstile_sitekey']);
    $tpl->assign('TURNSTILE_SECRETKEY', $captcha_config_list['turnstile_secretkey'] ? $crypt->decrypt($captcha_config_list['turnstile_secretkey']) : '');
}

$tpl->assign('CORS', $cross_config_list);
$tpl->assign('RP_DIRECTIVES', $rp_directives);

// Xử lý sơ bộ CSP bằng PHP
$csp_dirs = [];

foreach ($csp_directives as $name => $sources) {
    $csp_dirs[$name] = [
        'name' => $name,
        'desc' => $nv_Lang->getModule('csp_' . $name),
        'sources' => []
    ];

    $is_none = !empty($directives[$name]['none']);
    foreach ($sources as $key => $default) {
        $val = '';
        if ($key == 'hosts' and !empty($directives[$name][$key])) {
            $val = is_array($directives[$name][$key]) ? implode(chr(13) . chr(10), $directives[$name][$key]) : preg_replace('/[\s]+/', chr(13) . chr(10), $directives[$name][$key]);
        }
        $csp_dirs[$name]['sources'][$key] = [
            'key' => $key,
            'val' => $val,
            'checked' => !empty($directives[$name][$key]) ? 1 : 0,
            'disabled' => ($key != 'none' and $is_none) ? 1 : 0,
            'name' => $nv_Lang->existsModule('csp_source_' . $name . '_' . $key) ? $nv_Lang->getModule('csp_source_' . $name . '_' . $key) : $nv_Lang->getModule('csp_source_' . $key)
        ];
    }
}
$tpl->assign('CSP_DIRS', $csp_dirs);

// Xử lý sơ bộ PP bằng PHP
$pp_dirs = [];
foreach ($pp_directives as $name => $sources) {
    $pp_dirs[$name] = [
        'name' => $name,
        'desc' => $nv_Lang->getModule('pp_' . str_replace('-', '_', $name)),
        'sources' => []
    ];

    $value = isset($ppval_directives[$name]) ? $ppval_directives[$name] : $sources;
    foreach ($sources as $key => $default) {
        $val = '';
        if ($key == 'hosts' and !empty($value[$key])) {
            $val = implode("\n", $value[$key]);
        }
        $pp_dirs[$name]['sources'][$key] = [
            'key' => $key,
            'val' => $val,
            'rows' => empty($val) ? 2 : 4,
            'checked' => !empty($value[$key]) ? 1 : 0,
            'disabled' => (!in_array($key, ['all', 'none', 'ignore']) and (!empty($value['all']) or !empty($value['none']) or !empty($value['ignore']))) ? 1 : 0,
            'name' => $nv_Lang->existsModule('pp_source_' . $name . '_' . $key) ? $nv_Lang->getModule('pp_source_' . $name . '_' . $key) : $nv_Lang->getModule('pp_source_' . $key)
        ];
    }
}
$tpl->assign('PP_DIRS', $pp_dirs);

$contents = $tpl->fetch('security.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

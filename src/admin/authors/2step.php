<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_AUTHORS')) {
    exit('Stop!!!');
}

$admin_id = $nv_Request->get_absint('admin_id', 'get,post', $admin_info['admin_id']);

$sql = 'SELECT * FROM ' . NV_AUTHORS_GLOBALTABLE . ' WHERE admin_id=' . $admin_id;
$row = $db->query($sql)->fetch();

if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$allowed = false;
if (defined('NV_IS_SPADMIN') and $admin_info['level'] == 1) {
    $allowed = true;
} elseif (defined('NV_IS_SPADMIN')) {
    if ($row['admin_id'] == $admin_info['admin_id']) {
        $allowed = true;
    } elseif ($row['lev'] == 3 and $global_config['spadmin_add_admin'] == 1) {
        $allowed = true;
    }
} else {
    if ($row['admin_id'] == $admin_info['admin_id']) {
        $allowed = true;
    }
}

if (empty($allowed)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $admin_id;
$row_user = $db->query($sql)->fetch();
if (empty($row_user)) {
    trigger_error('Data error: No user for admin account!', 256);
}
$error = '';

// Xác định quyền sửa tài khoản thành viên
$sql = 'SELECT content FROM ' . NV_USERS_GLOBALTABLE . "_config WHERE config='access_admin'";
$config_user = $db->query($sql)->fetchColumn();
$config_user = empty($config_user) ? [] : unserialize($config_user);
$manager_user_2step = false;
if (
    isset($site_mods['users']) and isset($config_user['access_editus']) and !empty($config_user['access_editus'][$admin_info['level']])
    and ($admin_info['admin_id'] == $row['admin_id'] or $admin_info['level'] < $row['lev'])
    and (empty($global_config['idsite']) or $global_config['idsite'] == $row_user['idsite'])
) {
    $manager_user_2step = true;
}

$page_title = $nv_Lang->getModule('2step_manager') . ': ' . $row_user['username'];

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('2step.tpl'));
$tpl->registerPlugin('modifier', 'datetime_format', 'nv_datetime_format');
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('OP', $op);
$tpl->assign('MODULE_NAME', $module_name);

$tpl->assign('USER', $row_user);
$tpl->assign('ADMIN', $row);
$tpl->assign('ADMIN_INFO', $admin_info);
$tpl->assign('MANAGER_USER_2STEP', $manager_user_2step);

if ($row['admin_id'] == $admin_info['admin_id']) {
    // Xác định các cổng Oauth hỗ trợ
    $server_allowed = [];
    if (!empty($global_config['facebook_client_id']) and !empty($global_config['facebook_client_secret'])) {
        $server_allowed['facebook'] = 1;
    }
    if (!empty($global_config['google_client_id']) and !empty($global_config['google_client_secret'])) {
        $server_allowed['google'] = 1;
    }
    if (!empty($global_config['zaloOfficialAccountID']) and !empty($global_config['zaloAppID']) and !empty($global_config['zaloAppSecretKey'])) {
        $server_allowed['zalo'] = 1;
    }

    // Thêm mới tài khoản Oauth
    if (isset($server_allowed[($opt = $nv_Request->get_title('auth', 'get', ''))])) {
        define('NV_ADMIN_2STEP_OAUTH', true);
        require NV_ROOTDIR . '/' . NV_ADMINDIR . '/' . $module_file . '/2step_' . $opt . '.php';

        if (!empty($_GET['code']) and empty($error)) {
            if (empty($attribs)) {
                $error = $nv_Lang->getGlobal('admin_oauth_error_getdata');
            } else {
                // Kiểm tra trùng
                $sql = 'SELECT * FROM ' . NV_AUTHORS_GLOBALTABLE . '_oauth WHERE oauth_uid=' . $db->quote($attribs['full_identity']) . '
                AND admin_id=' . $row['admin_id'] . ' AND oauth_server=' . $db->quote($opt);
                if ($db->query($sql)->fetch()) {
                    $error = $nv_Lang->getModule('2step_error_oauth_exists');
                }
            }

            if (empty($error)) {
                // Thêm mới vào CSDL
                $sql = 'INSERT INTO ' . NV_AUTHORS_GLOBALTABLE . '_oauth (
                    admin_id, oauth_server, oauth_uid, oauth_email, oauth_id, addtime
                ) VALUES (
                    ' . $row['admin_id'] . ', ' . $db->quote($opt) . ', ' . $db->quote($attribs['full_identity']) . ',
                    ' . $db->quote($attribs['email']) . ', ' . $db->quote($attribs['identity']) . ', ' . NV_CURRENTTIME . '
                )';
                if (!$db->insert_id($sql, 'id')) {
                    $error = $nv_Lang->getGlobal('admin_oauth_error_savenew');
                } else {
                    $oauthid = !empty($attribs['email']) ? $attribs['email'] : $attribs['identity'];

                    $maillang = NV_LANG_INTERFACE;
                    if (!empty($row_user['language']) and in_array($row_user['language'], $global_config['setup_langs'], true)) {
                        if ($row_user['language'] != NV_LANG_INTERFACE) {
                            $maillang = $row_user['language'];
                        }
                    } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
                        $maillang = NV_LANG_DATA;
                    }

                    $send_data = [[
                        'to' => $row_user['email'],
                        'data' => [
                            'first_name' => $row_user['first_name'],
                            'last_name' => $row_user['last_name'],
                            'username' => $row_user['username'],
                            'email' => $row_user['email'],
                            'gender' => $row_user['gender'],
                            'lang' => $maillang,
                            'oauth_id' => $oauthid,
                            'oauth_name' => ucfirst($opt)
                        ]
                    ]];
                    nv_sendmail_template_async(NukeViet\Template\Email\Tpl::E_AUTHOR_2STEP_ADD, $send_data, $maillang);

                    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_ADD_OAUTH', $opt . ': ' . $oauthid, $admin_info['userid']);
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&amp;admin_id=' . $admin_id);
                }
            }
        }
    }

    $tpl->assign('SERVER_ALLOWED', $server_allowed);
}

// Danh sách các cổng xác thực
$array_oauth = [];
$list_for_mail = [];
$sql = 'SELECT * FROM ' . NV_AUTHORS_GLOBALTABLE . '_oauth WHERE admin_id=' . $row['admin_id'] . ' ORDER BY addtime DESC';
$result = $db->query($sql);
while ($_row = $result->fetch()) {
    $array_oauth[$_row['id']] = $_row;
    $oauthid = !empty($_row['oauth_email']) ? $_row['oauth_email'] : $_row['oauth_id'];
    $list_for_mail[] = $oauthid . '(' . ucfirst($_row['oauth_server']) . ')';
}

// Xóa tất cả
if ($nv_Request->get_title('delall', 'post', '') === NV_CHECK_SESSION) {
    if (!defined('NV_IS_AJAX')) {
        exit('Wrong URL');
    }

    $sql = 'DELETE FROM ' . NV_AUTHORS_GLOBALTABLE . '_oauth WHERE admin_id=' . $row['admin_id'];
    $db->query($sql);

    $list_for_mail = implode(', ', $list_for_mail);

    $maillang = NV_LANG_INTERFACE;
    if (!empty($row_user['language']) and in_array($row_user['language'], $global_config['setup_langs'], true)) {
        if ($row_user['language'] != NV_LANG_INTERFACE) {
            $maillang = $row_user['language'];
        }
    } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
        $maillang = NV_LANG_DATA;
    }

    $send_data = [[
        'to' => $row_user['email'],
        'data' => [
            'first_name' => $row_user['first_name'],
            'last_name' => $row_user['last_name'],
            'username' => $row_user['username'],
            'email' => $row_user['email'],
            'gender' => $row_user['gender'],
            'lang' => $maillang,
            'oauth_id' => $list_for_mail
        ]
    ]];
    nv_sendmail_template_async(NukeViet\Template\Email\Tpl::E_AUTHOR_2STEP_TRUNCATE, $send_data, $maillang);

    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_TRUNCATE_OAUTH', 'AID ' . $row['admin_id'], $admin_info['userid']);
    nv_jsonOutput([
        'error' => 0,
        'message' => ''
    ]);
}

// Xóa một tài khoản
if ($nv_Request->get_title('del', 'post', '') === NV_CHECK_SESSION) {
    if (!defined('NV_IS_AJAX')) {
        exit('Wrong URL');
    }

    $respon = [
        'error' => 1,
        'message' => 'Error!!!'
    ];

    $id = $nv_Request->get_absint('id', 'post', 0);
    if (!isset($array_oauth[$id])) {
        $respon['message'] = 'No Oauth ID';
        nv_jsonOutput($respon);
    }

    $sql = 'DELETE FROM ' . NV_AUTHORS_GLOBALTABLE . '_oauth WHERE admin_id=' . $row['admin_id'] . ' AND id=' . $id;
    $db->query($sql);

    $oauthid = !empty($array_oauth[$id]['oauth_email']) ? $array_oauth[$id]['oauth_email'] : $array_oauth[$id]['oauth_id'];

    $maillang = NV_LANG_INTERFACE;
    if (!empty($row_user['language']) and in_array($row_user['language'], $global_config['setup_langs'], true)) {
        if ($row_user['language'] != NV_LANG_INTERFACE) {
            $maillang = $row_user['language'];
        }
    } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
        $maillang = NV_LANG_DATA;
    }

    $send_data = [[
        'to' => $row_user['email'],
        'data' => [
            'first_name' => $row_user['first_name'],
            'last_name' => $row_user['last_name'],
            'username' => $row_user['username'],
            'email' => $row_user['email'],
            'gender' => $row_user['gender'],
            'lang' => $maillang,
            'oauth_id' => $oauthid,
            'oauth_name' => ucfirst($array_oauth[$id]['oauth_server'])
        ]
    ]];
    nv_sendmail_template_async(NukeViet\Template\Email\Tpl::E_AUTHOR_2STEP_DEL, $send_data, $maillang);

    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_DELETE_OAUTH', 'AID ' . $row['admin_id'] . ': ' . $array_oauth[$id]['oauth_server'] . '|' . $array_oauth[$id]['oauth_email'], $admin_info['userid']);
    $respon['error'] = 0;
    nv_jsonOutput($respon);
}

$tpl->assign('OAUTHS', $array_oauth);
$tpl->assign('ERROR', $error);

$contents = $tpl->fetch('2step.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

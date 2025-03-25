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

use NukeViet\Module\users\Shared\Emails;

if ($nv_Request->isset_request('nv_genpass', 'post')) {
    $_len = round(($global_config['nv_upassmin'] + $global_config['nv_upassmax']) / 2);
    echo nv_genpass($_len, $global_config['nv_upass_type']);
    exit();
}

$showheader = $nv_Request->get_int('showheader', 'post,get', 1);
$page_title = $nv_Lang->getModule('user_add');

if ($global_config['max_user_number'] > 0) {
    $sql = 'SELECT count(*) FROM ' . NV_MOD_TABLE;
    if ($global_config['idsite'] > 0) {
        $sql .= ' WHERE idsite=' . $global_config['idsite'];
    }
    $user_number = $db->query($sql)->fetchColumn();
    if ($user_number >= $global_config['max_user_number']) {
        $contents = $nv_Lang->getGlobal('limit_user_number', $global_config['max_user_number']);
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents, $showheader);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$groups_list = nv_groups_list($module_data);
$array_field_config = nv_get_users_field_config();

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$_user = $custom_fields = [];
$userid = 0;
$nv_redirect = '';
if ($nv_Request->isset_request('nv_redirect', 'post,get')) {
    $nv_redirect = nv_get_redirect();
}

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $userid);
if ($nv_Request->isset_request('confirm', 'post')) {
    if ($checkss != $nv_Request->get_string('checkss', 'post')) {
        nv_jsonOutput([
            'status' => 'error',
            'mess' => 'Error Session, Please close the browser and try again'
        ]);
    }
    $_user['username'] = $nv_Request->get_title('username', 'post', '', 1);
    $_user['email'] = nv_strtolower($nv_Request->get_title('email', 'post', '', 1));
    $_user['password1'] = $nv_Request->get_title('password1', 'post', '', 0);
    $_user['password2'] = $nv_Request->get_title('password2', 'post', '', 0);
    $_user['pass_reset_request'] = $nv_Request->get_int('pass_reset_request', 'post', 0);
    $_user['email_reset_request'] = $nv_Request->get_int('email_reset_request', 'post', 0);
    $_user['question'] = nv_substr($nv_Request->get_title('question', 'post', '', 1), 0, 255);
    $_user['answer'] = nv_substr($nv_Request->get_title('answer', 'post', '', 1), 0, 255);
    $_user['first_name'] = nv_substr($nv_Request->get_title('first_name', 'post', '', 1), 0, 255);
    $_user['last_name'] = nv_substr($nv_Request->get_title('last_name', 'post', '', 1), 0, 255);
    $_user['gender'] = nv_substr($nv_Request->get_title('gender', 'post', '', 1), 0, 1);
    $_user['view_mail'] = $nv_Request->get_int('view_mail', 'post', 0);
    $_user['sig'] = $nv_Request->get_textarea('sig', '', NV_ALLOWED_HTML_TAGS);
    $_user['birthday'] = $nv_Request->get_title('birthday', 'post');
    $_user['in_groups'] = $nv_Request->get_typed_array('group', 'post', 'int');
    $_user['in_groups_default'] = $nv_Request->get_int('group_default', 'post', 0);
    $_user['photo'] = nv_substr($nv_Request->get_title('photo', 'post', '', 1), 0, 255);
    $_user['is_official'] = $nv_Request->get_int('is_official', 'post', 0);
    $_user['adduser_email'] = $nv_Request->get_int('adduser_email', 'post', 0);
    $_user['is_email_verified'] = (int) $nv_Request->get_bool('is_email_verified', 'post', false);

    $custom_fields = $nv_Request->get_array('custom_fields', 'post');
    $custom_fields['first_name'] = $_user['first_name'];
    $custom_fields['last_name'] = $_user['last_name'];
    $custom_fields['gender'] = $_user['gender'];
    $custom_fields['birthday'] = $_user['birthday'];
    $custom_fields['sig'] = $_user['sig'];
    $custom_fields['question'] = $_user['question'];
    $custom_fields['answer'] = $_user['answer'];

    $md5username = nv_md5safe($_user['username']);

    if (($error_username = nv_check_valid_login($_user['username'], $global_config['nv_unickmax'], $global_config['nv_unickmin'])) != '') {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'username',
            'mess' => $error_username
        ]);
    }

    if ("'" . $_user['username'] . "'" != $db->quote($_user['username'])) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'username',
            'mess' => $nv_Lang->getModule('account_deny_name', $_user['username'])
        ]);
    }

    // Thực hiện câu truy vấn để kiểm tra username đã tồn tại chưa.
    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . ' WHERE username LIKE :username OR md5username= :md5username');
    $stmt->bindParam(':username', $_user['username'], PDO::PARAM_STR);
    $stmt->bindParam(':md5username', $md5username, PDO::PARAM_STR);
    $stmt->execute();
    $query_error_username = $stmt->fetchColumn();
    if ($query_error_username) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'username',
            'mess' => $nv_Lang->getModule('edit_error_username_exist')
        ]);
    }

    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . '_reg WHERE username LIKE :username OR md5username= :md5username');
    $stmt->bindParam(':username', $_user['username'], PDO::PARAM_STR);
    $stmt->bindParam(':md5username', $md5username, PDO::PARAM_STR);
    $stmt->execute();
    $query_error_username = $stmt->fetchColumn();
    if ($query_error_username) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'username',
            'mess' => $nv_Lang->getModule('edit_error_username_exist')
        ]);
    }

    $error_xemail = nv_check_valid_email($_user['email'], true);
    if ($error_xemail[0] != '') {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'email',
            'mess' => $error_xemail[0]
        ]);
    }
    $_user['email'] = $error_xemail[1];

    // Thực hiện câu truy vấn để kiểm tra email đã tồn tại chưa.
    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . ' WHERE email= :email');
    $stmt->bindParam(':email', $_user['email'], PDO::PARAM_STR);
    $stmt->execute();
    $query_error_email = $stmt->fetchColumn();
    if ($query_error_email) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'email',
            'mess' => $nv_Lang->getModule('edit_error_email_exist')
        ]);
    }

    // Thực hiện câu truy vấn để kiểm tra email đã tồn tại trong nv4_users_reg  chưa.
    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . '_reg WHERE email= :email');
    $stmt->bindParam(':email', $_user['email'], PDO::PARAM_STR);
    $stmt->execute();
    $query_error_email_reg = $stmt->fetchColumn();
    if ($query_error_email_reg) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'email',
            'mess' => $nv_Lang->getModule('edit_error_email_exist')
        ]);
    }

    // Thực hiện câu truy vấn để kiểm tra email đã tồn tại trong nv3_users_openid chưa.
    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . '_openid WHERE email= :email');
    $stmt->bindParam(':email', $_user['email'], PDO::PARAM_STR);
    $stmt->execute();
    $query_error_email_openid = $stmt->fetchColumn();
    if ($query_error_email_openid) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'email',
            'mess' => $nv_Lang->getModule('edit_error_email_exist')
        ]);
    }

    if (($check_pass = nv_check_valid_pass($_user['password1'], $global_config['nv_upassmax'], $global_config['nv_upassmin'])) != '') {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'password1',
            'mess' => $check_pass
        ]);
    }

    if ($_user['password1'] != $_user['password2']) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => 'password1',
            'mess' => $nv_Lang->getModule('edit_error_password')
        ]);
    }

    // Kiểm tra các trường dữ liệu tùy biến + Hệ thống
    $query_field = [];
    $valid_field = [];
    if (!empty($array_field_config)) {
        $check = fieldsCheck($custom_fields, $_user, $query_field, $valid_field);
        if ($check['status'] == 'error') {
            nv_jsonOutput($check);
        }
    }

    if (empty($_user['is_official'])) {
        // Khi là thành viên mới thì chỉ có nhóm = 7, không có các nhóm khác
        $_user['in_groups'] = [7];
        $_user['in_groups_default'] = 7;
    } else {
        // Khi là thành viên chính thức thì cho phép chọn nhóm + nhóm = 4
        $in_groups = [];
        foreach ($_user['in_groups'] as $_group_id) {
            if ($_group_id > 9) {
                $in_groups[] = $_group_id;
            }
        }
        $_user['in_groups'] = array_intersect($in_groups, array_keys($groups_list));
        $_user['in_groups'] = array_map('intval', $_user['in_groups']);

        // Kiểm tra nhóm thành viên mặc định phải thuộc các nhóm đã chọn
        if (!empty($_user['in_groups_default']) and !in_array($_user['in_groups_default'], $_user['in_groups'], true)) {
            $_user['in_groups_default'] = 0;
        }

        // Khi không chọn nhóm mặc định thì là thành viên chính thức
        if (empty($_user['in_groups_default'])) {
            $_user['in_groups_default'] = 4;
        }

        $_user['in_groups'][] = 4;
    }

    if ($_user['pass_reset_request'] > 2 or $_user['pass_reset_request'] < 0) {
        $_user['pass_reset_request'] = 0;
    }
    if ($_user['email_reset_request'] > 2 or $_user['email_reset_request'] < 0) {
        $_user['email_reset_request'] = 0;
    }

    $sql = 'INSERT INTO ' . NV_MOD_TABLE . ' (
        group_id, username, md5username, password, email, first_name, last_name, gender, birthday, sig, regdate,
        question, answer, passlostkey, view_mail, remember, in_groups, active, checknum, last_login, last_ip,
        last_agent, last_openid, idsite, pass_creation_time, pass_reset_request, email_creation_time, email_reset_request,
        email_verification_time, active_obj
    ) VALUES (
        ' . $_user['in_groups_default'] . ',
        :username,
        :md5_username,
        :password,
        :email,
        :first_name,
        :last_name,
        :gender,
        ' . (int) ($_user['birthday']) . ',
        :sig,
        ' . NV_CURRENTTIME . ",
        :question,
        :answer,
        '',
        " . $_user['view_mail'] . ",
        1,
        '" . implode(',', $_user['in_groups']) . "', 1, '', 0, '', '', '', " . $global_config['idsite'] . ',
        ' . NV_CURRENTTIME . ',
        ' . $_user['pass_reset_request'] . ',
        ' . NV_CURRENTTIME . ',
        ' . $_user['email_reset_request'] . ',
        ' . ($_user['is_email_verified'] ? '-1' : '0') . ",
        'SYSTEM'
    )";

    $data_insert = [];
    $data_insert['username'] = $_user['username'];
    $data_insert['md5_username'] = $md5username;
    $data_insert['password'] = $crypt->hash_password($_user['password1'], $global_config['hashprefix']);
    $data_insert['email'] = $_user['email'];
    $data_insert['first_name'] = $_user['first_name'];
    $data_insert['last_name'] = $_user['last_name'];
    $data_insert['gender'] = $_user['gender'];
    $data_insert['sig'] = $_user['sig'];
    $data_insert['question'] = $_user['question'];
    $data_insert['answer'] = $_user['answer'];

    $userid = $db->insert_id($sql, 'userid', $data_insert);

    if (!$userid) {
        nv_jsonOutput([
            'status' => 'error',
            'input' => '',
            'mess' => $nv_Lang->getModule('edit_add_error')
        ]);
    }

    $query_field['userid'] = $userid;
    userInfoTabDb($query_field);
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_user', 'userid ' . $userid, $admin_info['userid']);

    // Check photo
    if (!empty($_user['photo'])) {
        $tmp_photo = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $_user['photo'];

        if (!nv_is_file($tmp_photo, NV_TEMP_DIR)) {
            $_user['photo'] = '';
        } else {
            $new_photo_name = $_user['photo'];
            $new_photo_path = NV_ROOTDIR . '/' . SYSTEM_UPLOADS_DIR . '/' . $module_upload . '/';

            $new_photo_name2 = $new_photo_name;
            $i = 1;
            while (file_exists($new_photo_path . $new_photo_name2)) {
                $new_photo_name2 = preg_replace('/(.*)(\.[a-zA-Z0-9]+)$/', '\1_' . $i . '\2', $new_photo_name);
                ++$i;
            }
            $new_photo = $new_photo_path . $new_photo_name2;

            if (nv_copyfile(NV_DOCUMENT_ROOT . $tmp_photo, $new_photo)) {
                $_user['photo'] = substr($new_photo, strlen(NV_ROOTDIR . '/'));
            } else {
                $_user['photo'] = '';
            }

            nv_deletefile(NV_DOCUMENT_ROOT . $tmp_photo);
        }

        if (!empty($_user['photo'])) {
            $stmt = $db->prepare('UPDATE ' . NV_MOD_TABLE . ' SET photo= :photo WHERE userid=' . $userid);
            $stmt->bindParam(':photo', $_user['photo'], PDO::PARAM_STR, strlen($_user['photo']));
            $stmt->execute();
        }
    }

    if (!empty($_user['in_groups'])) {
        foreach ($_user['in_groups'] as $group_id) {
            if ($group_id != 7 and $group_id != 4) {
                nv_groups_add_user($group_id, $userid, 1, $module_data);
            }
        }
    }

    $db->query('UPDATE ' . NV_MOD_TABLE . '_groups SET numbers = numbers+1 WHERE group_id=' . ($_user['is_official'] ? 4 : 7));
    $nv_Cache->delMod($module_name);

    // Gửi mail thông báo
    if (!empty($_user['adduser_email'])) {
        $maillang = NV_LANG_INTERFACE;
        if (NV_LANG_DATA != NV_LANG_INTERFACE) {
            $maillang = NV_LANG_DATA;
        }

        $send_data = [[
            'to' => $_user['email'],
            'data' => [
                'first_name' => $_user['first_name'],
                'last_name' => $_user['last_name'],
                'username' => $_user['username'],
                'email' => $_user['email'],
                'gender' => $_user['gender'],
                'password' => $_user['password1'],
                'pass_reset' => $_user['pass_reset_request'],
                'email_reset' => $_user['email_reset_request'],
                'link' => urlRewriteWithDomain(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, NV_MY_DOMAIN),
                'lang' => $maillang
            ]
        ]];
        nv_sendmail_template_async([$module_name, Emails::ADDED_BY_ADMIN], $send_data, $maillang);
    }

    $redirect = $nv_redirect != '' ? nv_redirect_decrypt($nv_redirect) . '&userid=' . $userid : '';
    if (isset($admin_mods['authors']) and defined('NV_IS_GODADMIN') or (defined('NV_IS_SPADMIN') and ($global_config['spadmin_add_admin'] == 1 or $global_config['idsite'] > 0))) {
        $is_admin_add = $nv_Request->get_bool('admin_add', 'post', false);
        if ($is_admin_add) {
            $redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=authors&' . NV_OP_VARIABLE . '=add&userid=' . $_user['username'];
        }
    }
    nv_jsonOutput([
        'status' => 'ok',
        'input' => '',
        'nv_redirect' => $redirect
    ]);
}

$initdata = [];
if ($nv_Request->isset_request('initdata', 'post')) {
    $_initdata = $nv_Request->get_title('initdata', 'post');
    $_initdata = json_decode($crypt->decrypt($_initdata, NV_CHECK_SESSION), true);
    $initdata = is_array($_initdata) ? $_initdata : [];
}
$_user['email'] = $initdata['email'] ?? '';
$_user['first_name'] = $initdata['first_name'] ?? '';
$_user['last_name'] = $initdata['last_name'] ?? '';
$_user['username'] = $initdata['username'] ?? '';
$_user['question'] = $initdata['question'] ?? '';
$_user['answer'] = $initdata['answer'] ?? '';
$_user['gender'] = $initdata['gender'] ?? '';
$_user['sig'] = $initdata['sig'] ?? '';
$_user['birthday'] = $initdata['birthday'] ?? '';
$_user['password1'] = $initdata['password1'] ?? '';
$_user['password2'] = $initdata['password2'] ?? '';
$_user['pass_reset_request'] = isset($initdata['pass_reset_request']) ? (int) $initdata['pass_reset_request'] : 1;
$_user['email_reset_request'] = isset($initdata['email_reset_request']) ? (int) $initdata['email_reset_request'] : 0;

$_user['view_mail'] = 0;
$_user['in_groups'] = [];
$_user['is_official'] = ' checked="checked"';
$_user['adduser_email'] = '';
$_user['view_mail'] = '';
$_user['is_email_verified'] = ' checked="checked"';
$_user['checkss'] = $checkss;

$groups = [];
if (!empty($groups_list)) {
    foreach ($groups_list as $group_id => $grtl) {
        $groups[] = [
            'id' => $group_id,
            'title' => $grtl,
            'checked' => ''
        ];
    }
}

$xtpl = new XTemplate('user_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('DATA', $_user);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=user_add');

$xtpl->assign('NV_UNICKMIN', $global_config['nv_unickmin']);
$xtpl->assign('NV_UNICKMAX', $global_config['nv_unickmax']);
$xtpl->assign('NV_UPASSMAX', $global_config['nv_upassmax']);
$xtpl->assign('NV_UPASSMIN', $global_config['nv_upassmin']);

$xtpl->assign('NV_REDIRECT', $nv_redirect);

if (defined('NV_IS_USER_FORUM')) {
    $xtpl->parse('main.is_forum');
} else {
    for ($i = 0; $i <= 2; ++$i) {
        $xtpl->assign('PASSRESET', [
            'num' => $i,
            'sel' => $i == $_user['pass_reset_request'] ? ' selected="selected"' : '',
            'title' => $nv_Lang->getModule('pass_reset_request' . $i)
        ]);
        $xtpl->parse('main.edit_user.pass_reset_request');
    }

    for ($i = 0; $i <= 2; ++$i) {
        $xtpl->assign('EMAILRESET', [
            'num' => $i,
            'sel' => $i == $_user['email_reset_request'] ? ' selected="selected"' : '',
            'title' => $nv_Lang->getModule('email_reset_request' . $i)
        ]);
        $xtpl->parse('main.edit_user.email_reset_request');
    }

    $a = 0;
    foreach ($groups as $group) {
        if ($group['id'] > 9) {
            $xtpl->assign('GROUP', $group);
            $xtpl->parse('main.edit_user.group.list');
            ++$a;
        }
    }
    if ($a > 0) {
        $xtpl->parse('main.edit_user.group');
    }

    $have_custom_fields = false;
    $have_name_field = false;
    foreach ($array_field_config as $row) {
        // Value luôn là giá trị mặc định
        if (!empty($row['field_choices'])) {
            if ($row['field_type'] == 'date') {
                $row['value'] = $initdata[$row['field']] ?? (($row['field_choices']['current_date']) ? NV_CURRENTTIME : $row['default_value']);
            } elseif ($row['field_type'] == 'number') {
                $row['value'] = $initdata[$row['field']] ?? $row['default_value'];
            } else {
                $temp = array_keys($row['field_choices']);
                $tempkey = $initdata[$row['field']] ?? (int) ($row['default_value']) - 1;
                $row['value'] = (isset($temp[$tempkey])) ? $temp[$tempkey] : '';
            }
        } else {
            $row['value'] = $initdata[$row['field']] ?? get_value_by_lang($row['default_value']);
        }

        $row['required'] = ($row['required']) ? 'required' : '';
        $xtpl->assign('FIELD', $row);

        // Các trường hệ thống xuất độc lập
        if (!empty($row['system'])) {
            if ($row['field'] == 'birthday') {
                $row['value'] = nv_u2d_post($row['value']);
            } elseif ($row['field'] == 'sig') {
                $row['value'] = nv_htmlspecialchars(nv_br2nl($row['value']));
            }
            $xtpl->assign('FIELD', $row);
            if ($row['field'] == 'first_name' or $row['field'] == 'last_name') {
                $show_key = 'name_show_' . $global_config['name_show'] . '.show_' . $row['field'];
                $have_name_field = true;
            } else {
                $show_key = 'show_' . $row['field'];
            }
            if ($row['required']) {
                $xtpl->parse('main.edit_user.' . $show_key . '.required');
            }
            if ($row['field'] == 'gender') {
                foreach ($global_array_genders as $gender) {
                    $gender['selected'] = $row['value'] == $gender['key'] ? ' selected="selected"' : '';
                    $xtpl->assign('GENDER', $gender);
                    $xtpl->parse('main.edit_user.' . $show_key . '.gender');
                }
            }
            if ($row['for_admin']) {
                $xtpl->parse('main.edit_user.' . $show_key . '.for_admin');
            }
            if ($row['description']) {
                $xtpl->parse('main.edit_user.' . $show_key . '.description');
            }
            $xtpl->parse('main.edit_user.' . $show_key);
        } else {
            if ($row['required']) {
                $xtpl->parse('main.edit_user.field.loop.required');
            }
            if ($row['for_admin']) {
                $xtpl->parse('main.edit_user.field.loop.for_admin');
            }
            if ($row['description']) {
                $xtpl->parse('main.edit_user.field.loop.description');
            }
            if ($row['field_type'] == 'textbox' or $row['field_type'] == 'number') {
                $xtpl->parse('main.edit_user.field.loop.textbox');
            } elseif ($row['field_type'] == 'date') {
                $row['value'] = nv_u2d_post($row['value']);
                $xtpl->assign('FIELD', $row);
                $xtpl->parse('main.edit_user.field.loop.date');
            } elseif ($row['field_type'] == 'textarea') {
                $row['value'] = nv_htmlspecialchars(nv_br2nl($row['value']));
                $xtpl->assign('FIELD', $row);
                $xtpl->parse('main.edit_user.field.loop.textarea');
            } elseif ($row['field_type'] == 'editor') {
                $row['value'] = htmlspecialchars(nv_editor_br2nl($row['value']));
                if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                    $array_tmp = explode('@', $row['class']);
                    $edits = nv_aleditor('custom_fields[' . $row['field'] . ']', $array_tmp[0], $array_tmp[1], $row['value']);
                    $xtpl->assign('EDITOR', $edits);
                    $xtpl->parse('main.edit_user.field.loop.editor');
                } else {
                    $row['class'] = '';
                    $xtpl->assign('FIELD', $row);
                    $xtpl->parse('main.edit_user.field.loop.textarea');
                }
            } elseif ($row['field_type'] == 'select') {
                foreach ($row['field_choices'] as $key => $value) {
                    $xtpl->assign('FIELD_CHOICES', [
                        'key' => $key,
                        'selected' => ($key == $row['value']) ? ' selected="selected"' : '',
                        'value' => get_value_by_lang2($key, $value)
                    ]);
                    $xtpl->parse('main.edit_user.field.loop.select.loop');
                }
                $xtpl->parse('main.edit_user.field.loop.select');
            } elseif ($row['field_type'] == 'radio') {
                $number = 0;
                foreach ($row['field_choices'] as $key => $value) {
                    $xtpl->assign('FIELD_CHOICES', [
                        'id' => $row['fid'] . '_' . $number++,
                        'key' => $key,
                        'checked' => ($key == $row['value']) ? ' checked="checked"' : '',
                        'value' => get_value_by_lang2($key, $value)
                    ]);
                    $xtpl->parse('main.edit_user.field.loop.radio');
                }
            } elseif ($row['field_type'] == 'checkbox') {
                $number = 0;
                $valuecheckbox = (!empty($row['value'])) ? explode(',', $row['value']) : [];
                foreach ($row['field_choices'] as $key => $value) {
                    $xtpl->assign('FIELD_CHOICES', [
                        'id' => $row['fid'] . '_' . $number++,
                        'key' => $key,
                        'checked' => (in_array((string) $key, $valuecheckbox, true)) ? ' checked="checked"' : '',
                        'value' => get_value_by_lang2($key, $value)
                    ]);
                    $xtpl->parse('main.edit_user.field.loop.checkbox');
                }
            } elseif ($row['field_type'] == 'multiselect') {
                foreach ($row['field_choices'] as $key => $value) {
                    $xtpl->assign('FIELD_CHOICES', [
                        'key' => $key,
                        'selected' => ($key == $row['value']) ? ' selected="selected"' : '',
                        'value' => get_value_by_lang2($key, $value)
                    ]);
                    $xtpl->parse('main.edit_user.field.loop.multiselect.loop');
                }
                $xtpl->parse('main.edit_user.field.loop.multiselect');
            } elseif ($row['field_type'] == 'file') {
                $row['limited_values'] = !empty($row['limited_values']) ? json_decode($row['limited_values'], true) : [];
                $xtpl->assign('FILEACCEPT', !empty($row['limited_values']['mime']) ? '.' . implode(',.', $row['limited_values']['mime']) : '');
                $xtpl->assign('FILEMAXSIZE', $row['limited_values']['file_max_size']);
                $xtpl->assign('FILEMAXSIZE_FORMAT', nv_convertfromBytes($row['limited_values']['file_max_size']));
                $xtpl->assign('FILEMAXNUM', $row['limited_values']['maxnum']);
                $xtpl->assign('CSRF', md5(NV_CHECK_SESSION . '_' . $module_name . $row['field']));
                $xtpl->assign('URL_MODULE', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);
                $widthlimit = image_size_info($row['limited_values']['widthlimit'], 'width');
                $heightlimit = image_size_info($row['limited_values']['heightlimit'], 'height');
                if (!empty($widthlimit)) {
                    $xtpl->assign('WIDTHLIMIT', $widthlimit);
                    $xtpl->parse('main.edit_user.field.loop.file.widthlimit');
                }
                if (!empty($heightlimit)) {
                    $xtpl->assign('HEIGHTLIMIT', $heightlimit);
                    $xtpl->parse('main.edit_user.field.loop.file.heightlimit');
                }

                $xtpl->parse('main.edit_user.field.loop.file');
            }
            $xtpl->parse('main.edit_user.field.loop');
            $have_custom_fields = true;
        }
    }
    if ($have_name_field) {
        $xtpl->parse('main.edit_user.name_show_' . $global_config['name_show']);
    }
    if ($have_custom_fields) {
        $xtpl->parse('main.edit_user.field');
    }
    if (isset($admin_mods['authors']) and defined('NV_IS_GODADMIN') or (defined('NV_IS_SPADMIN') and ($global_config['spadmin_add_admin'] == 1 or $global_config['idsite'] > 0))) {
        $xtpl->parse('main.edit_user.admin_add');
    }

    $xtpl->parse('main.edit_user');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents, $showheader);
include NV_ROOTDIR . '/includes/footer.php';

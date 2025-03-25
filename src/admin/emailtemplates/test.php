<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_EMAILTEMPLATES')) {
    exit('Stop!!!');
}

use NukeViet\Template\Email\Emf;

$emailid = $nv_Request->get_absint('emailid', 'post,get', 0);

$sql = 'SELECT * FROM ' . NV_EMAILTEMPLATES_GLOBALTABLE . ' WHERE emailid = ' . $emailid;
$result = $db->query($sql);
$array = $result->fetch();
if (empty($array)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$array['title'] = $array[NV_LANG_DATA . '_title'];
$array['lang_subject'] = $array[NV_LANG_DATA . '_subject'];
$array['lang_content'] = $array[NV_LANG_DATA . '_content'];
$array['pids'] = array_values(array_filter(array_unique(array_merge_recursive(explode(',', $array['sys_pids']), explode(',', $array['pids'])))));
$array['test_tomail'] = [$admin_info['email']];

// Hook xử lý biến $array khi lấy từ CSDL ra
$array = nv_apply_hook('', 'emailtemplates_content_from_db', [$array], $array);

$error = $merge_fields = $field_data = [];
$email_data = nv_get_email_template($emailid);
if ($email_data === false) {
    $error[] = $nv_Lang->getModule('test_error_template');
}

if (count($array['pids']) == 1 and $array['pids'][0] == Emf::P_ALL and !empty($email_data)) {
    /*
     * Các mẫu email chỉ sử dụng plugin all field thì lấy các biến trong nội dung email để làm $merge_fields
     * Chỉ hỗ trợ các biến đơn dạng string, number. Muốn soạn thảo một mẫu email phức tạp hãy dùng plugin riêng để xử lý.
     */
    $pattern = '/\{[\s]*\$([a-zA-Z0-9\_]+)[\s]*\}/s';
    unset($matches);
    preg_match_all($pattern, $email_data['subject'] . ' ' . $email_data['content'], $matches);
    if (!empty($matches[1])) {
        foreach ($matches[1] as $value) {
            $merge_fields[$value] = [
                'name' => $nv_Lang->getGlobal($value),
                'data' => '',
                'type' => Emf::T_STRING
            ];
        }
    }

    // Dạng mảng key value
    $pattern = '/\{[\s]*\$([a-zA-Z0-9\_]+)[\s]*\.[\s]*([a-zA-Z0-9\_]+)\}/s';
    unset($matches);
    preg_match_all($pattern, $email_data['subject'] . ' ' . $email_data['content'], $matches);
    if (!empty($matches[1])) {
        foreach ($matches[1] as $key => $value) {
            if (!isset($merge_fields[$value])) {
                $merge_fields[$value] = [
                    'name' => $nv_Lang->getGlobal($value),
                    'data' => '',
                    'type' => Emf::T_ARRAY,
                    'keys' => []
                ];
            }
            $merge_fields[$value]['keys'][$matches[2][$key]] = $matches[2][$key];
        }
    }
} elseif (!empty($array['pids'])) {
    $args = [
        'mode' => 'PRE',
        'setpids' => $array['pids']
    ];
    $merge_fields = nv_apply_hook('', 'get_email_merge_fields', $args, [], 1);
}

$page_title = $nv_Lang->getModule('test');
$success = false;

if ($nv_Request->get_title('tokend', 'post', '') === NV_CHECK_SESSION) {
    // Lấy các email nhận
    $test_tomail = nv_nl2br($nv_Request->get_string('test_tomail', 'post', ''), '|');
    $test_tomail = array_unique(array_filter(array_map('trim', explode('|', $test_tomail))));
    $array['test_tomail'] = [];
    foreach ($test_tomail as $email) {
        $email_check = nv_check_valid_email($email, true);
        if (!empty($email_check[0])) {
            $error[] = $email_check[0] . ': ' . nv_htmlspecialchars($email);
        } else {
            $array['test_tomail'][] = $email_check[1];
        }
    }
    if (empty($array['test_tomail'])) {
        $error[] = $nv_Lang->getModule('test_error_tomail');
    }

    foreach ($merge_fields as $fieldname => $field) {
        if (isset($field['type']) and in_array($field['type'], [Emf::T_LIST, Emf::T_ARRAY])) {
            $field_data[$fieldname] = $nv_Request->get_typed_array('f_' . $fieldname, 'post', 'title', []);
        } else {
            $field_data[$fieldname] = $nv_Request->get_title('f_' . $fieldname, 'post', '');
        }
    }

    if (empty($error)) {
        if (empty($email_data['from'][0])) {
            $email_data['from'][0] = $global_config['site_name'];
        }
        if (empty($email_data['from'][1])) {
            $email_data['from'][1] = $global_config['site_email'];
        }

        // Ghi nhận ký
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Send test email', 'ID: ' . $emailid . '. To mail: ' . implode(', ', $array['test_tomail']), $admin_info['userid']);

        // Hook xử lý biến $email_data trước khi build ra HTML
        $email_data = nv_apply_hook('', 'get_email_data_before_fetch_test', [$emailid, $email_data, $merge_fields, $field_data], $email_data);

        try {
            $tpl_string = new \NukeViet\Template\NVSmarty();
            foreach ($merge_fields as $field_key => $field_value) {
                $tpl_string->assign($field_key, $field_data[$field_key]);
            }

            $email_content = $tpl_string->fetch('string:' . $email_data['content']);
            $email_subject = $tpl_string->fetch('string:' . $email_data['subject']);
            if ($email_data['is_plaintext']) {
                $email_content = nv_nl2br(strip_tags($email_content));
            } else {
                $email_content = preg_replace('/(["|\'])[\s]*' . nv_preg_quote(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/') . '/isu', '\\1' . NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/', $email_content);
            }

            // Gọi 1 hook trước khi gửi email test
            nv_apply_hook('', 'event_before_sending_test_mail', [$emailid, $email_data, $merge_fields, $field_data]);

            $check_send = nv_sendmail($email_data['from'], $array['test_tomail'], $email_subject, $email_content, implode(',', $email_data['attachments']), false, true, $email_data['cc'], $email_data['bcc'], !$email_data['is_selftemplate'], [], NV_LANG_INTERFACE, $email_data['mailtpl']);
            if (!empty($check_send)) {
                $error[] = $check_send;
            } else {
                $success = true;
            }

            unset($tpl_string);
        } catch (Throwable $e) {
            trigger_error(print_r($e, true));
            $error[] = nv_htmlspecialchars($e->getMessage());
        }
    }
}

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->registerPlugin('modifier', 'implode', 'implode');
$tpl->registerPlugin('modifier', 'sizeof', 'sizeof');
$tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$tpl->assign('LANG', $nv_Lang);

$tpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$tpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;emailid=' . $emailid);
$tpl->assign('DATA', $array);
$tpl->assign('ERROR', $error);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('CATS', $global_array_cat);
$tpl->assign('TOKEND', NV_CHECK_SESSION);
$tpl->assign('MERGE_FIELDS', $merge_fields);
$tpl->assign('FIELD_DATA', $field_data);
$tpl->assign('SUCCESS', $success);

$contents = $tpl->fetch('test.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

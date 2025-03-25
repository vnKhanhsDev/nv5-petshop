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

$page_title = $module_info['site_title'];
$contact_allowed = nv_getAllowed();

if (!empty($contact_allowed['reply'])) {
    $db_deps = 'cid IN (' . implode(',', array_keys($contact_allowed['reply'])) . ')';

    // Gửi phản hồi/Chuyển tiếp thư
    if ($nv_Request->isset_request('reply', 'post') or $nv_Request->isset_request('forward', 'post')) {
        $is_reply = $nv_Request->isset_request('reply', 'post');
        $id = $is_reply ? $nv_Request->get_int('reply', 'post', 0) : $nv_Request->get_int('forward', 'post', 0);
        if (empty($id)) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => 'Error'
            ]);
        }

        $row = $db->query('SELECT * FROM ' . NV_MOD_TABLE . '_send WHERE id = ' . $id . ' AND ' . $db_deps)->fetch();
        if (empty($row)) {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => 'Error'
            ]);
        }

        $mess_content = $is_reply ? $nv_Request->get_editor('mess_content', '', NV_ALLOWED_HTML_TAGS) : $nv_Request->get_editor('forward_content', '', NV_ALLOWED_HTML_TAGS);
        if (trim(strip_tags($mess_content)) == '') {
            nv_jsonOutput([
                'status' => 'error',
                'mess' => $nv_Lang->getModule('admin_error_content')
            ]);
        }

        $custom_header = [
            'References' => md5('contact' . $id . $global_config['sitekey'])
        ];

        $maillang = '';
        if (NV_LANG_DATA != NV_LANG_INTERFACE) {
            $maillang = NV_LANG_DATA;
        }
        if ($is_reply) {
            $emaillist = [];
            $from = [];
            $departments = get_department_list();
            if (!empty($departments[$row['cid']]['email'])) {
                $emails = array_map('trim', explode(',', $departments[$row['cid']]['email']));
                foreach ($emails as $email) {
                    if (nv_check_valid_email($email) == '') {
                        !isset($from['reply_address']) && $from['reply_address'] = [];
                        !isset($from['reply_name']) && $from['reply_name'] = [];
                        $from['reply_address'][] = $email;
                        $from['reply_name'][] = $departments[$row['cid']]['full_name'];
                        $emaillist[] = $email;
                    }
                }
            }
            if (empty($from)) {
                $from = [$admin_info['full_name'], $admin_info['email']];
                $emaillist[] = $admin_info['email'];
            }

            $cc = [];
            $acc = [];
            if (empty($module_config[$module_name]['silent_mode'])) {
                if (!empty($departments[$row['cid']]['admins'])) {
                    $admins = parse_admins($departments[$row['cid']]['admins']);
                    if (!empty($admins['obt_level'])) {
                        $in = implode(',', $admins['obt_level']);
                        $sql = 'SELECT userid, username, email, first_name, last_name FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid IN (SELECT admin_id FROM ' . NV_AUTHORS_GLOBALTABLE . ' WHERE admin_id IN (' . $in . ') AND is_suspend=0) AND active=1';
                        $_result = $db->query($sql);
                        while ($_row = $_result->fetch()) {
                            if (!in_array($_row['email'], $emaillist, true)) {
                                $_row['full_name'] = nv_show_name_user($_row['first_name'], $_row['last_name'], $_row['username']);
                                $cc[$_row['email']] = $_row['full_name'];
                                $acc[] = $_row['userid'];
                                $emaillist[] = $_row['email'];
                            }
                        }
                    }
                }

                if (!in_array($admin_info['email'], $emaillist, true)) {
                    $cc[$admin_info['email']] = $admin_info['full_name'];
                    $acc[] = $admin_info['admin_id'];
                }
            }

            nv_sendmail_async($from, $row['sender_email'], 'Re:' . $row['title'], $mess_content, '', false, false, $cc, [], true, $custom_header, $maillang);
            $mode = 1;
            $recipient = $row['sender_email'];
            $acc = implode(',', $acc);
            $mess = $nv_Lang->getModule('send_suc_send_title');
        } else {
            $forward_to = $nv_Request->get_string('email', 'post', '');
            if (empty($forward_to)) {
                nv_jsonOutput([
                    'status' => 'error',
                    'mess' => $nv_Lang->getModule('error_mail_empty')
                ]);
            }

            $_arr_mail = explode(',', $forward_to);
            $_arr_mail = array_filter($_arr_mail, function ($_email) {
                $_email = nv_unhtmlspecialchars($_email);

                return nv_check_valid_email($_email) == '';
            });

            $gconfigs = [
                'site_name' => $global_config['site_name'],
                'site_email' => $global_config['site_email']
            ];
            if (!empty($maillang)) {
                $in = "'" . implode("', '", array_keys($gconfigs)) . "'";
                $result = $db->query('SELECT config_name, config_value FROM ' . NV_CONFIG_GLOBALTABLE . " WHERE lang='" . $maillang . "' AND module='global' AND config_name IN (" . $in . ')');
                while ($row = $result->fetch()) {
                    $gconfigs[$row['config_name']] = $row['config_value'];
                }
            }

            nv_sendmail_async([$gconfigs['site_name'], $gconfigs['site_email']], $_arr_mail, 'Fwd:' . $row['title'], $mess_content, '', false, false, [], [], true, $custom_header, $maillang);
            $mode = 2;
            $recipient = $forward_to;
            $acc = '';
            $mess = $nv_Lang->getModule('forwarded');
        }

        $sth = $db->prepare('INSERT INTO ' . NV_MOD_TABLE . '_reply (id, reply_recipient, reply_cc, reply_content, reply_time, reply_aid) VALUES (' . $id . ', :reply_recipient, :reply_cc, :reply_content, ' . NV_CURRENTTIME . ', ' . $admin_info['admin_id'] . ')');
        $sth->bindParam(':reply_recipient', $recipient, PDO::PARAM_STR);
        $sth->bindParam(':reply_cc', $acc, PDO::PARAM_STR);
        $sth->bindParam(':reply_content', $mess_content, PDO::PARAM_STR, strlen($mess_content));
        $sth->execute();
        $db->query('UPDATE ' . NV_MOD_TABLE . '_send SET is_reply=' . $mode . ' WHERE id=' . $id);

        nv_jsonOutput([
            'status' => 'OK',
            'mess' => $mess
        ]);
    }
}

if (!empty($contact_allowed['exec'])) {
    $db_deps = 'cid IN (' . implode(',', array_keys($contact_allowed['exec'])) . ')';

    // Đánh dấu phản hồi đã đọc/chưa đọc, đã xử lý/chưa xử lý
    if ($nv_Request->isset_request('mark', 'post')) {
        $mark = $nv_Request->get_title('mark', 'post', '');
        if (in_array($mark, ['read', 'unread', 'processed', 'unprocess'], true)) {
            $sends = $nv_Request->get_typed_array('sends', 'post', 'int', []);
            if (empty($sends)) {
                $send = $nv_Request->get_int('send', 'post', 0);
                if (empty($send)) {
                    nv_jsonOutput([
                        'status' => 'error',
                        'mess' => $nv_Lang->getModule('please_choose')
                    ]);
                }
                $sends = [$send];
            }

            $mk = ($mark == 'read' or $mark == 'processed') ? 1 : 0;
            foreach ($sends as $id) {
                nv_status_notification(NV_LANG_DATA, $module_name, 'contact_new', $id, $mk);
            }

            $sends = implode(',', $sends);
            if (($mark == 'read' or $mark == 'unread')) {
                $set = $mk ? 'is_read=1' : 'is_read=0, is_processed=0, processed_by=0, processed_time=0';
            } else {
                $set = $mk ? 'is_read= 1, is_processed=1, processed_by=' . $admin_info['userid'] . ', processed_time=' . NV_CURRENTTIME : 'is_processed=0, processed_by= 0, processed_time=0';
                nv_insert_logs(NV_LANG_DATA, $module_name, ($mk ? $nv_Lang->getModule('mark_as_processed') : $nv_Lang->getModule('mark_as_unprocess')), 'ID: ' . $sends, $admin_info['userid']);
            }
            $db->query('UPDATE ' . NV_MOD_TABLE . '_send SET ' . $set . ' WHERE id IN (' . $sends . ') AND ' . $db_deps);
            nv_jsonOutput([
                'status' => 'ok',
                'mess' => ''
            ]);
        }
    }

    // Xóa phản hồi
    if ($nv_Request->isset_request('delete', 'post')) {
        $type = $nv_Request->get_int('delete', 'post', 0);
        // Xóa toàn bộ các thư thuộc bộ phận được phép xem
        if ($type == 3) {
            if (defined('NV_IS_SPADMIN')) {
                $ids = $db->query("SELECT GROUP_CONCAT(DISTINCT id SEPARATOR ',') AS ids FROM " . NV_MOD_TABLE . '_send')->fetchColumn();
                if (!empty($ids)) {
                    nv_delete_notification(NV_LANG_DATA, $module_name, 'contact_new', $ids);
                    $db->query('TRUNCATE TABLE ' . NV_MOD_TABLE . '_send');
                    $db->query('TRUNCATE TABLE ' . NV_MOD_TABLE . '_reply');
                }
            }
            /*else {
                $ids = $db->query("SELECT GROUP_CONCAT(DISTINCT id SEPARATOR ',') AS ids FROM " . NV_MOD_TABLE . '_send WHERE ' . $db_deps)->fetchColumn();
                if (!empty($ids)) {
                    nv_delete_notification(NV_LANG_DATA, $module_name, 'contact_new', $ids);
                    $db->query('DELETE FROM ' . NV_MOD_TABLE . '_send WHERE id IN (' . $ids . ')');
                    $db->query('DELETE FROM ' . NV_MOD_TABLE . '_reply WHERE id IN (' . $ids . ')');
                }
            }*/
        }
        // Xóa một số
        elseif ($type == 2) {
            $sends = $nv_Request->get_typed_array('sends', 'post', 'int', []);
            if (!empty($sends)) {
                $sends = implode(',', $sends);
                $ids = $db->query("SELECT GROUP_CONCAT(DISTINCT id SEPARATOR ',') AS ids FROM " . NV_MOD_TABLE . '_send WHERE id IN (' . $sends . ') AND ' . $db_deps)->fetchColumn();
                nv_delete_notification(NV_LANG_DATA, $module_name, 'contact_new', $ids);
                if (!empty($ids)) {
                    $db->query('DELETE FROM ' . NV_MOD_TABLE . '_send WHERE id IN (' . $ids . ')');
                    $db->query('DELETE FROM ' . NV_MOD_TABLE . '_reply WHERE id IN (' . $ids . ')');
                }
            }
        }
        // Xóa đơn lẻ
        else {
            $id = $nv_Request->get_int('id', 'post', 0);
            $exist = $db->query('SELECT COUNT(*) FROM ' . NV_MOD_TABLE . '_send WHERE id = ' . $id . ' AND ' . $db_deps)->fetchColumn();

            if ($exist) {
                nv_delete_notification(NV_LANG_DATA, $module_name, 'contact_new', $id);
                $db->query('DELETE FROM ' . NV_MOD_TABLE . '_send WHERE id = ' . $id);
                $db->query('DELETE FROM ' . NV_MOD_TABLE . '_reply WHERE id = ' . $id);
            }
        }

        $nv_Cache->delMod($module_name);
        nv_jsonOutput([
            'status' => 'ok'
        ]);
    }
}

if (!empty($contact_allowed['view'])) {
    $db_deps = 'cid IN (' . implode(',', array_keys($contact_allowed['view'])) . ')';

    // Xem feedback
    if ($nv_Request->isset_request('id', 'get')) {
        $id = $nv_Request->get_int('id', 'get', 0);
        if (!$id) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        }
        $sql = 'SELECT * FROM ' . NV_MOD_TABLE . '_send WHERE id=' . $id . ' AND ' . $db_deps;
        $row = $db->query($sql)->fetch();
        if (empty($row)) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        }

        if (empty($row['is_read'])) {
            nv_status_notification(NV_LANG_DATA, $module_name, 'contact_new', $row['id']);
            $db->query('UPDATE ' . NV_MOD_TABLE . '_send SET is_read=1 WHERE id=' . $id);
            $row['is_read'] = 1;
        }

        $row['read_admins'] = !empty($row['read_admins']) ? json_decode($row['read_admins'], true) : [];
        if (empty($row['read_admins']) or !isset($row['read_admins'][$admin_info['admin_id']])) {
            $row['read_admins'][$admin_info['admin_id']] = NV_CURRENTTIME;
            $read_admins = json_encode($row['read_admins']);
            $db->query('UPDATE ' . NV_MOD_TABLE . '_send SET read_admins=' . $db->quote($read_admins) . ' WHERE id=' . $id);
        }

        $send_time = date('r', $row['send_time']);
        $row['send_time'] = nv_datetime_format($row['send_time'], 1);

        $departments = get_department_list();
        if (isset($departments[$row['cid']])) {
            $row['department'] = $departments[$row['cid']]['full_name'];
            $row['department_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=department&id=' . $row['cid'];
        } else {
            $row['department'] = $nv_Lang->getModule('department_empty');
        }

        if ($row['is_processed']) {
            $row['mark_process'] = 'unprocess';
            $row['mark_process_title'] = $nv_Lang->getModule('mark_as_unprocess');
        } else {
            $row['mark_process'] = 'processed';
            $row['mark_process_title'] = $nv_Lang->getModule('mark_as_processed');
        }

        $row['auto_forward'] = !empty($row['auto_forward']) ? array_map('trim', explode(',', $row['auto_forward'])) : [];
        $auto_forward = [];
        if (!empty($row['auto_forward'][0]) and !is_numeric($row['auto_forward'][0])) {
            $auto_forward[] = array_shift($row['auto_forward']);
        }
        if (defined('NV_IS_SPADMIN') or !empty($row['auto_forward']) or !empty($row['processed_by'])) {
            $admins = $row['auto_forward'];
            if (!empty($row['processed_by'])) {
                $admins[] = $row['processed_by'];
            }
            if (defined('NV_IS_SPADMIN')) {
                $admins = array_merge($admins, array_keys($row['read_admins']));
            }
            $admins = array_unique($admins);
            $admins = implode(',', $admins);
            $result2 = $db->query('SELECT t1.admin_id, t2.username as admin_login, t2.first_name, t2.last_name FROM ' . NV_AUTHORS_GLOBALTABLE . ' t1 INNER JOIN ' . NV_USERS_GLOBALTABLE . ' t2 ON t1.admin_id = t2.userid WHERE t1.admin_id IN (' . $admins . ')');
            $admins = [];
            while ($admin = $result2->fetch()) {
                $admins[$admin['admin_id']] = nv_show_name_user($admin['first_name'], $admin['last_name'], $admin['admin_login']);
            }
        }

        if (!empty($row['auto_forward'])) {
            foreach ($row['auto_forward'] as $aid) {
                $auto_forward[] = '<a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;id=' . $aid . '">' . $admins[$aid] . '</a>';
            }
        }
        $row['auto_forward'] = !empty($auto_forward) ? implode(', ', $auto_forward) : '';

        if (defined('NV_IS_SPADMIN')) {
            $read_admins = [];
            foreach ($row['read_admins'] as $aid => $time) {
                $read_admins[] = '<a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;id=' . $aid . '">' . $admins[$aid] . '</a> (' . date('H:i d/m/Y', $time) . ')';
            }
            $row['read_admins'] = implode(', ', $read_admins);
        } else {
            $row['read_admins'] = '';
        }

        $xtpl = new XTemplate('view.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
        $xtpl->assign('PAGE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        $xtpl->assign('DATA', $row);

        if (!empty($row['auto_forward'])) {
            $xtpl->parse('main.auto_forward');
        }

        if (defined('NV_IS_SPADMIN')) {
            $xtpl->parse('main.read_admins');
        }

        if ($row['is_processed']) {
            $processed_by_name = $admins[$row['processed_by']] ?? '';
            $xtpl->assign('PROCESSED', [
                'name' => $processed_by_name,
                'url' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;id=' . $row['processed_by'],
                'time' => nv_datetime_format($row['processed_time'], 1)
            ]);
            if (!empty($processed_by_name)) {
                $xtpl->parse('main.is_processed.processed_person');
            }

            $xtpl->parse('main.processed');
            $xtpl->parse('main.is_processed');
        } else {
            $xtpl->parse('main.process');
        }

        if (!empty($row['sender_id'])) {
            $userinfo = $db->query('SELECT * FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['sender_id'])->fetch();
            $userinfo['full_name'] = nv_show_name_user($userinfo['first_name'], $userinfo['last_name'], $userinfo['username']);
            $userinfo['gender'] = $nv_Lang->getModule('user_gender_' . $userinfo['gender']);
            $userinfo['birthday'] = !empty($userinfo['birthday']) ? date('d/m/Y', $userinfo['birthday']) : '';
            $userinfo['regdate'] = date('H:i d/m/Y', $userinfo['regdate']);
            $userinfo['last_login'] = date('H:i d/m/Y', $userinfo['last_login']);
            if (!empty($userinfo['photo'])) {
                $userinfo['photo'] = NV_STATIC_URL . $userinfo['photo'];
            } else {
                $userinfo['photo'] = NV_STATIC_URL . 'themes/default/images/users/no_avatar.png';
            }
            $xtpl->assign('USER', $userinfo);
            $xtpl->parse('main.is_user');
            $xtpl->parse('main.is_user_modal');
        } else {
            $xtpl->parse('main.is_guest');
        }

        if (!empty($row['sender_phone'])) {
            $xtpl->parse('main.sender_phone');
        }

        if (!empty($row['sender_address'])) {
            $xtpl->parse('main.sender_address');
        }

        if (!empty($row['department_url'])) {
            $xtpl->parse('main.department_url');
        } else {
            $xtpl->parse('main.department');
        }

        if (isset($contact_allowed['reply'][$row['cid']])) {
            if (defined('NV_EDITOR')) {
                require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
            }

            $mess_content = '<br />';
            $mess_content .= '--------------------------------------------------------------------------------<br />';
            $forward_content = '<br />';
            $forward_content .= '-----------------------' . $nv_Lang->getModule('forwarded') . '-------------------------<br />';
            $_content = '<strong>From:</strong> ' . $row['sender_name'] . ' [mailto:' . $row['sender_email'] . ']<br />';
            $_content .= '<strong>Sent:</strong> ' . $send_time . '<br />';
            $_content .= '<strong>To:</strong> ' . $contact_allowed['view'][$row['cid']] . '<br />';
            $_content .= '<strong>Subject:</strong> ' . $row['title'] . '<br /><br />';
            $_content .= $row['content'];
            require_once NV_ROOTDIR . '/modules/contact/sign.php';
            $_content .= $sign_content;
            $mess_content .= $_content;
            $mess_content = htmlspecialchars(nv_editor_br2nl($mess_content));
            $forward_content .= $_content;
            $forward_content = htmlspecialchars(nv_editor_br2nl($forward_content));
            if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                $mess_content = nv_aleditor('mess_content', '100%', '200px', $mess_content, 'Basic');
                $forward_content = nv_aleditor('forward_content', '100%', '200px', $forward_content, 'Basic');
            } else {
                $mess_content = '<textarea style="width:99%" name="mess_content" id="mess_content" cols="20" rows="8">' . $mess_content . '</textarea>';
                $forward_content = '<textarea style="width:99%" name="forward_content" id="mess_content" cols="20" rows="8">' . $forward_content . '</textarea>';
            }
            $xtpl->assign('POST', [
                'title' => 'Re:' . $row['title'],
                'sender_email' => $row['sender_email'],
                'content' => $mess_content
            ]);

            $xtpl->parse('main.reply');
            $xtpl->parse('main.reply_form');

            $xtpl->assign('FORWARD', [
                'title' => 'Fwd:' . $row['title'],
                'content' => $forward_content
            ]);
            $xtpl->parse('main.forward');
            $xtpl->parse('main.forward_form');
        }

        if (isset($contact_allowed['exec'][$row['cid']])) {
            $xtpl->parse('main.exec');
        }

        if (!empty($row['is_reply'])) {
            $result = $db->query('SELECT * FROM ' . NV_MOD_TABLE . '_reply WHERE id=' . $row['id'] . ' ORDER BY reply_time DESC');
            $is_collapsed = false;
            $admins = [];
            $replylist = [];
            while ($reply = $result->fetch()) {
                $reply['type'] = $reply['reply_recipient'] != $row['sender_email'] ? $nv_Lang->getModule('forwarding_mail') : $nv_Lang->getModule('reply_mail');
                $reply['time'] = date('H:i d/m/Y', $reply['reply_time']);
                $reply['sender_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;id=' . $reply['reply_aid'];
                $reply['icon'] = $reply['reply_recipient'] != $row['sender_email'] ? 'fa-share' : 'fa-reply';
                $reply['reply_cc'] = !empty($reply['reply_cc']) ? array_map('trim', explode(',', $reply['reply_cc'])) : [];
                $admins[] = $reply['reply_aid'];
                if (!empty($reply['reply_cc'])) {
                    $admins += $reply['reply_cc'];
                }
                $replylist[] = $reply;
                $is_collapsed = true;
            }

            if (!empty($admins)) {
                $admins = array_unique($admins);
                $admins = implode(',', $admins);
                $result2 = $db->query('SELECT t1.admin_id, t2.username as admin_login, t2.first_name, t2.last_name FROM ' . NV_AUTHORS_GLOBALTABLE . ' t1 INNER JOIN ' . NV_USERS_GLOBALTABLE . ' t2 ON t1.admin_id = t2.userid WHERE t1.admin_id IN (' . $admins . ')');
                $admins = [];
                while ($admin = $result2->fetch()) {
                    $admins[$admin['admin_id']] = nv_show_name_user($admin['first_name'], $admin['last_name'], $admin['admin_login']);
                }
            }

            if (!empty($replylist)) {
                foreach ($replylist as $reply) {
                    $reply['sender'] = $admins[$reply['reply_aid']];
                    $reply['reply_cc'] = array_map(function ($aid) {
                        global $admins;

                        return '<a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;id=' . $aid . '">' . $admins[$aid] . '</a>';
                    }, $reply['reply_cc']);
                    $reply['reply_cc'] = implode(', ', $reply['reply_cc']);
                    $xtpl->assign('REPLY', $reply);
                    if (!empty($reply['reply_cc'])) {
                        $xtpl->parse('main.reply_loop.reply_cc');
                    }
                    $xtpl->parse('main.reply_loop');
                }
            }
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');

        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);

if (!empty($contact_allowed['view'])) {
    $in = implode(',', array_keys($contact_allowed['view']));

    $page = $nv_Request->get_page('page', 'get', 1);
    $per_page = 30;
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_MOD_TABLE . '_send')
        ->where('cid IN (' . $in . ')');

    $num_items = $db->query($db->sql())
        ->fetchColumn();

    if ($num_items) {
        $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);

        if (defined('NV_IS_SPADMIN')) {
            $xtpl->parse('main.data.for_spadmin');
        }

        $a = 0;
        $currday = mktime(0, 0, 0, date('n'), date('j'), date('Y'));

        $db->select('*')
            ->order('id DESC')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);

        $result = $db->query($db->sql());

        while ($row = $result->fetch()) {
            if ($row['is_processed']) {
                $status = $nv_Lang->getModule('tt3_row_title');
            } else {
                if ($row['is_read'] != 1) {
                    $status = $nv_Lang->getModule('row_new');
                } else {
                    if ($row['is_reply']) {
                        $status = $nv_Lang->getModule('tt2_row_title');
                    } else {
                        $status = $nv_Lang->getModule('tt1_row_title');
                    }
                }
            }

            $image = [
                NV_STATIC_URL . NV_ASSETS_DIR . '/images/mail_new.gif',
                12,
                9
            ];

            if ($row['is_read'] == 1) {
                if ($row['is_reply'] == 1) {
                    $image = [
                        NV_STATIC_URL . NV_ASSETS_DIR . '/images/mail_reply.gif',
                        13,
                        14
                    ];
                } elseif ($row['is_reply'] == 2) {
                    $image = [
                        NV_STATIC_URL . NV_ASSETS_DIR . '/images/mail_forward.gif',
                        13,
                        14
                    ];
                } else {
                    $image = [
                        NV_STATIC_URL . NV_ASSETS_DIR . '/images/mail_old.gif',
                        12,
                        11
                    ];
                }
            }

            $xtpl->assign('ROW', [
                'id' => $row['id'],
                'sender_name' => $row['sender_name'],
                'path' => $contact_allowed['view'][$row['cid']],
                'cat' => $row['cat'],
                'title' => nv_clean60($row['title'], 60),
                'time' => $row['send_time'] >= $currday ? nv_datetime_format($row['send_time'], 1) : nv_date_format(1, $row['send_time']),
                'style' => !$row['is_read'] ? 'font-weight:bold;' : '',
                'onclick' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;id=' . $row['id'],
                'status' => $status,
                'image' => $image,
                'disabled' => isset($contact_allowed['exec'][$row['cid']]) ? '' : ' disabled="disabled"'
            ]);

            if ($row['is_processed']) {
                $xtpl->parse('main.data.row.is_processed');
                $xtpl->parse('main.data.row.processed');
            } else {
                $xtpl->parse('main.data.row.process');
            }

            $xtpl->parse('main.data.row');
        }

        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.data.generate_page');
        }
    }
}

if (empty($num_items)) {
    $xtpl->parse('main.empty');
} else {
    $xtpl->parse('main.data');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

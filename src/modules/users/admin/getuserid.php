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

$area = $nv_Request->get_title('area', 'get', '');
$return = $nv_Request->get_title('return', 'get,post', '');
if (empty($area)) {
    nv_error404();
}

$access_viewlist = empty($access_admin['access_viewlist'][$admin_info['level']]) ? false : true;

$page_title = $nv_Lang->getModule('pagetitle');
$filtersql = $nv_Request->get_string('filtersql', 'get', '');

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

$nv_Lang->setModule('fullname', $global_config['name_show'] == 0 ? $nv_Lang->getModule('lastname_firstname') : $nv_Lang->getModule('firstname_lastname'));
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('GLOBAL_CONFIG', $global_config);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('AREA', $area);
$xtpl->assign('RETURN', $return);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&area=' . $area . '&filtersql=' . $filtersql);

$array = [];

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&amp;area=' . $area . '&amp;return=' . $return . '&amp;save=1';

if ($nv_Request->isset_request('save', 'get')) {
    $array_user = [];
    $generate_page = '';

    $orderid = $nv_Request->get_title('orderid', 'get', '');
    $orderusername = $nv_Request->get_title('orderusername', 'get', '');
    $orderemail = $nv_Request->get_title('orderemail', 'get', '');
    $orderregdate = $nv_Request->get_title('orderregdate', 'get', '');

    if ($orderid != 'DESC' and $orderid != '') {
        $orderid = 'ASC';
    }
    if ($orderusername != 'DESC' and $orderusername != '') {
        $orderusername = 'ASC';
    }
    if ($orderemail != 'DESC' and $orderemail != '') {
        $orderemail = 'ASC';
    }
    if ($orderregdate != 'DESC' and $orderregdate != '') {
        $orderregdate = 'ASC';
    }

    $array['username'] = $nv_Request->get_title('username', 'get', '');
    $array['full_name'] = $nv_Request->get_title('full_name', 'get', '');
    $array['email'] = $nv_Request->get_title('email', 'get', '');
    $array['sig'] = $nv_Request->get_title('sig', 'get', '');
    $array['regdatefrom'] = nv_d2u_get($nv_Request->get_title('regdatefrom', 'get', ''));
    $array['regdateto'] = nv_d2u_get($nv_Request->get_title('regdateto', 'get', ''), 23, 59, 59);
    $array['last_loginfrom'] = nv_d2u_get($nv_Request->get_title('last_loginfrom', 'get', ''));
    $array['last_loginto'] = nv_d2u_get($nv_Request->get_title('last_loginto', 'get', ''), 23, 59, 59);
    $array['last_ip'] = $nv_Request->get_title('last_ip', 'get', '');
    $array['gender'] = $nv_Request->get_title('gender', 'get', '');

    $is_null = true;
    foreach ($array as $check) {
        if (!empty($check)) {
            $is_null = false;
            break;
        }
    }

    $array_where = [];
    if ($global_config['idsite'] > 0) {
        $array_where[] = '(idsite=' . $global_config['idsite'] . ' OR userid=' . $admin_info['admin_id'] . ')';
    }

    if (!empty($array['username'])) {
        $base_url .= '&amp;username=' . rawurlencode($array['username']);
        $array_where[] = "( username LIKE '%" . $db->dblikeescape($array['username']) . "%' )";
    }

    if (!empty($array['full_name'])) {
        $base_url .= '&amp;full_name=' . rawurlencode($array['full_name']);

        $where_fullname = $global_config['name_show'] == 0 ? "concat(last_name,' ',first_name)" : "concat(first_name,' ',last_name)";
        $array_where[] = '(' . $where_fullname . " LIKE '%" . $db->dblikeescape($array['full_name']) . "%' )";
    }

    if (!empty($array['email'])) {
        $base_url .= '&amp;email=' . rawurlencode($array['email']);
        $array_where[] = "( email LIKE '%" . $db->dblikeescape($array['email']) . "%' )";
    }

    if (!empty($array['sig'])) {
        $base_url .= '&amp;sig=' . rawurlencode($array['sig']);
        $array_where[] = "( sig LIKE '%" . $db->dblikeescape($array['sig']) . "%' )";
    }

    if (!empty($array['last_ip'])) {
        $base_url .= '&amp;last_ip=' . rawurlencode($array['last_ip']);
        $array_where[] = "( last_ip LIKE '%" . $db->dblikeescape($array['last_ip']) . "%' )";
    }

    if (!empty($array['gender'])) {
        $base_url .= '&amp;gender=' . rawurlencode($array['gender']);
        $array_where[] = '( gender =' . $db->quote($array['gender']) . ' )';
    }

    if (!empty($array['regdatefrom'])) {
        $base_url .= '&amp;regdatefrom=' . rawurlencode(nv_u2d_get($array['regdatefrom']));
        $array_where[] = '( regdate >= ' . $array['regdatefrom'] . ' )';
    }

    if (!empty($array['regdateto'])) {
        $base_url .= '&amp;regdateto=' . rawurlencode(nv_u2d_get($array['regdateto']));
        $array_where[] = '( regdate <= ' . $array['regdateto'] . ' )';
    }

    if (!empty($array['last_loginfrom'])) {
        $base_url .= '&amp;last_loginfrom=' . rawurlencode(nv_u2d_get($array['last_loginfrom']));
        $array_where[] = '( last_login >= ' . $array['last_loginfrom'] . ' )';
    }

    if (!empty($array['last_loginto'])) {
        $base_url .= '&amp;last_loginto=' . rawurlencode(nv_u2d_get($array['last_loginto']));
        $array_where[] = '( last_login <= ' . $array['last_loginto'] . ' )';
    }
    if (!empty($filtersql)) {
        $data_str = $crypt->decrypt($filtersql, NV_CHECK_SESSION);
        if (!empty($data_str)) {
            $array_where[] = $data_str;
        }
    }

    // Order data
    $orderida = [
        'url' => ($orderid == 'ASC') ? $base_url . '&amp;orderid=DESC' : $base_url . '&amp;orderid=ASC',
        'class' => ($orderid == '') ? 'nooder' : strtolower($orderid)
    ];

    $orderusernamea = [
        'url' => ($orderusername == 'ASC') ? $base_url . '&amp;orderusername=DESC' : $base_url . '&amp;orderusername=ASC',
        'class' => ($orderusername == '') ? 'nooder' : strtolower($orderusername)
    ];

    $orderemaila = [
        'url' => ($orderemail == 'ASC') ? $base_url . '&amp;orderemail=DESC' : $base_url . '&amp;orderemail=ASC',
        'class' => ($orderemail == '') ? 'nooder' : strtolower($orderemail)
    ];

    $orderregdatea = [
        'url' => ($orderregdate == 'ASC') ? $base_url . '&amp;orderregdate=DESC' : $base_url . '&amp;orderregdate=ASC',
        'class' => ($orderregdate == '') ? 'nooder' : strtolower($orderregdate)
    ];

    // SQL data
    $order_by = '';
    if (!empty($orderid)) {
        $base_url .= '&amp;orderid=' . $orderid;
        $order_by = 'userid ' . $orderid;
    } elseif (!empty($orderusername)) {
        $base_url .= '&amp;orderusername=' . $orderusername;
        $order_by = 'username ' . $orderusername;
    } elseif (!empty($orderemail)) {
        $base_url .= '&amp;orderemail=' . $orderemail;
        $order_by = 'email ' . $orderemail;
    } elseif (!empty($orderregdate)) {
        $base_url .= '&amp;orderregdate=' . $orderregdate;
        $order_by = 'regdate ' . $orderregdate;
    }

    $page = $nv_Request->get_page('page', 'get', 1);
    $per_page = 10;

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_MOD_TABLE);
    if (!empty($array_where)) {
        $db->where(implode(' AND ', $array_where));
    }

    $num_items = $db->query($db->sql())
        ->fetchColumn();

    $select_return = 'userid, username, email, regdate';
    $_array_f_return = explode(',', $select_return);
    $_array_f_return = array_map('trim', $_array_f_return);
    $return = (in_array($return, $_array_f_return, true)) ? $return : 'userid';

    if ($access_viewlist) {
        $db->select($select_return)
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
    } else {
        $db->select($select_return)->limit(5);
    }
    if (!empty($order_by)) {
        $db->order($order_by);
    }
    $result2 = $db->query($db->sql());
    while ($row = $result2->fetch()) {
        $array_user[$row['userid']] = $row;
    }

    if (!empty($array_user)) {
        if ($access_viewlist) {
            $xtpl->assign('ODER_ID', $orderida);
            $xtpl->assign('ODER_USERNAME', $orderusernamea);
            $xtpl->assign('ODER_EMAIL', $orderemaila);
            $xtpl->assign('ODER_REGDATE', $orderregdatea);
            $xtpl->parse('resultdata.data.order');
        } else {
            $xtpl->parse('resultdata.data.no_order');
        }

        foreach ($array_user as $row) {
            $row['regdate'] = nv_datetime_format($row['regdate']);
            $row['return'] = $row[$return];
            $xtpl->assign('ROW', $row);
            $xtpl->parse('resultdata.data.row');
        }

        if ($access_viewlist) {
            $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
            if (!empty($generate_page)) {
                $xtpl->assign('GENERATE_PAGE', $generate_page);
                $xtpl->parse('resultdata.data.generate_page');
            }
        }

        $xtpl->parse('resultdata.data');
    } elseif ($nv_Request->isset_request('save', 'get')) {
        $xtpl->parse('resultdata.nodata');
    }

    $xtpl->parse('resultdata');
    $contents = $xtpl->text('resultdata');

    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
} else {
    $gender = $array['gender'] ?? '';
    $array['gender'] = [];
    $array['gender'][] = [
        'key' => '',
        'title' => $nv_Lang->getModule('select_gender'),
        'selected' => ('' == $gender) ? ' selected="selected"' : ''
    ];
    $array['gender'][] = [
        'key' => 'M',
        'title' => $nv_Lang->getModule('select_gender_male'),
        'selected' => ('M' == $gender) ? ' selected="selected"' : ''
    ];
    $array['gender'][] = [
        'key' => 'F',
        'title' => $nv_Lang->getModule('select_gender_female'),
        'selected' => ('F' == $gender) ? ' selected="selected"' : ''
    ];

    foreach ($array['gender'] as $gender) {
        $xtpl->assign('GENDER', $gender);
        $xtpl->parse('main.gender');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents, 0);
    include NV_ROOTDIR . '/includes/footer.php';
}

<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_USER')) {
    exit('Stop!!!');
}

$myZalo = new NukeViet\Zalo\MyZalo($global_config);

if ($nv_Request->isset_request('code', 'get')) {
    $code_verifier = $nv_Request->get_string('code_verifier', 'session', '');
    $nv_Request->unset_request('code_verifier', 'session');

    $result = $myZalo->accesstokenGet($code_verifier, 'user');

    if (empty($result)) {
        $err = $myZalo->getError();
        $nv_Lang->existsModule($err) && $err = $nv_Lang->getModule($err);
        exit($err);
    }

    $result = $myZalo->getUserInfo($result['access_token']);
    if (isset($result['id'])) {
        $attribs = [
            'identity' => $result['id'],
            'result' => 'is_res',
            'id' => $result['id'],
            'contact/email' => '',
            'namePerson/first' => '',
            'namePerson/last' => '',
            'namePerson' => $result['name'],
            'person/gender' => '',
            'server' => $server,
            'picture_url' => $result['picture'],
            'picture_mode' => 0, // 0: Remote picture
            'current_mode' => 3
        ];
    } else {
        $attribs = ['result' => 'notlogin'];
    }
    $nv_Request->set_Session('openid_attribs', json_encode($attribs));

    $op_redirect = (defined('NV_IS_USER')) ? 'editinfo/openid' : 'login';
    $nv_redirect_session = $nv_Request->get_title('nv_redirect_' . $module_data, 'session', '');
    $nv_redirect = '';
    if (!empty($nv_redirect_session) and nv_redirect_decrypt($nv_redirect_session) != '') {
        $nv_redirect = $nv_redirect_session;
    }
    if (!empty($nv_redirect)) {
        $nv_redirect = '&nv_redirect=' . $nv_redirect;
    }
    $nv_redirect .= '&t=' . NV_CURRENTTIME;

    $nv_Request->unset_request('nv_redirect_' . $module_data, 'session');
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op_redirect . '&server=' . $server . '&result=1' . $nv_redirect);
}

$result = $myZalo->permissionURLCreate(NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=oauth&server=zalo', 'user');
if (empty($result['code_verifier']) or empty($result['permission_url'])) {
    exit('permission_url_error');
}
$nv_Request->set_Session('code_verifier', $result['code_verifier']);
nv_redirect_location($result['permission_url']);

<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_USER') and !defined('NV_ADMIN')) {
    exit('Stop!!!');
}

/**
 * check_user_login()
 *
 * @param string $username
 * @return mixed
 */
function check_user_login($username)
{
    return checkLoginName('username', $username);
}

/**
 * check_admin_login()
 *
 * @param string $username
 * @return mixed
 */
function check_admin_login($username)
{
    global $db;

    $sql = "t2.md5username ='" . nv_md5safe($username) . "'";
    // Lấy thông tin đăng nhập
    $sql = 'SELECT t1.admin_id admin_id, t1.lev admin_lev, t1.last_agent admin_last_agent, t1.last_ip admin_last_ip, t1.last_login admin_last_login,
        t2.userid, t2.last_agent, t2.last_ip, t2.last_login, t2.last_openid, t2.username, t2.email, t2.password, t2.active2step, t2.in_groups, t2.secretkey
        FROM ' . NV_AUTHORS_GLOBALTABLE . ' t1, ' . NV_USERS_GLOBALTABLE . ' t2
        WHERE t1.admin_id=t2.userid AND ' . $sql . ' AND t1.lev!=0 AND t1.is_suspend=0 AND t2.active=1';

    $row = $db->query($sql)->fetch();
    if (empty($row['username']) or $row['username'] != $username) {
        return false;
    }

    return $row;
}

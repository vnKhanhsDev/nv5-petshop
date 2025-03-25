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

if (!nv_function_exists('nv_block_counter_button')) {
    /**
     * nv_block_counter_button()
     *
     * @return string
     */
    function nv_block_counter_button()
    {
        global $global_config, $db, $nv_Lang;

        $sql = 'SELECT c_type, c_count FROM ' . NV_COUNTER_GLOBALTABLE . " WHERE (c_type='day' AND c_val='" . date('d', NV_CURRENTTIME) . "') OR (c_type='month' AND c_val='" . date('M', NV_CURRENTTIME) . "') OR (c_type='total' AND c_val='hits')";
        $query = $db->query($sql);
        $count_data = [];
        while ([$c_type, $c_count] = $query->fetch(3)) {
            $c_type == 'total' && $c_type = 'all';
            $count_data[$c_type] = $c_count;
        }

        $sql = 'SELECT userid, username FROM ' . NV_SESSIONS_GLOBALTABLE . ' WHERE onl_time >= ' . (NV_CURRENTTIME - NV_ONLINE_UPD_TIME);
        $query = $db->query($sql);

        $count_data['online'] = $count_data['users'] = $count_data['bots'] = $count_data['guests'] = 0;
        while ($row = $query->fetch()) {
            ++$count_data['online'];

            if ($row['userid']) {
                ++$count_data['users'];
            } elseif (preg_match('/^bot\:/', $row['username'])) {
                ++$count_data['bots'];
            } else {
                ++$count_data['guests'];
            }
        }

        $count_data = array_map(function ($number) {
            return !empty($number) ? nv_number_format($number) : 0;
        }, $count_data);

        $block_theme = get_tpl_dir([$global_config['module_theme'], $global_config['site_theme']], 'default', '/modules/statistics/global.counter_button.tpl');
        $xtpl = new XTemplate('global.counter_button.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/statistics');

        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_global);
        $xtpl->assign('IMG_PATH', NV_STATIC_URL . 'themes/' . $block_theme . '/');

        foreach ($count_data as $key => $value) {
            $xtpl->assign('COUNT_' . strtoupper($key), $value);
        }

        if ($count_data['users']) {
            $xtpl->parse('main.users');
        }

        if ($count_data['bots']) {
            $xtpl->parse('main.bots');
        }

        if ($count_data['guests'] and $count_data['guests'] != $count_data['online']) {
            $xtpl->parse('main.guests');
        }

        $xtpl->parse('main');
        $content = $xtpl->text('main');

        return $content;
    }
}

if (defined('NV_SYSTEM')) {
    global $global_config;
    if ($global_config['online_upd']) {
        $content = nv_block_counter_button();
    }
}

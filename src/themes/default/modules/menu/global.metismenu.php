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

if (!nv_function_exists('nv_metismenu')) {
    /**
     * nv_metismenu()
     *
     * @param array  $block_config
     * @param string $blockID
     * @return string
     */
    function nv_metismenu($block_config, $blockID)
    {
        global $nv_Cache;

        $sql = 'SELECT id, parentid, title, link, icon, note, subitem, groups_view, module_name, op, target, css, active_type FROM ' . NV_PREFIXLANG . '_menu_rows WHERE status=1 AND mid = ' . $block_config['menuid'] . ' ORDER BY parentid, weight ASC';
        $list = $nv_Cache->db($sql, 'id', $block_config['module']);

        $menulist = menu_getdata($list, 0, $block_config);
        $block_theme = get_tpl_dir([$block_config['real_theme']], 'default', '/css/jquery.metisMenu.css');

        $stpl = new \NukeViet\Template\NVSmarty();
        $stpl->setTemplateDir($block_config['real_path'] . '/smarty');
        $stpl->assign('MENUID', $blockID);
        $stpl->assign('BLOCK_THEME', $block_theme);
        $stpl->assign('MENU', $menulist);

        return $stpl->fetch('global.metismenu.tpl');
    }
}

if (defined('NV_SYSTEM')) {
    require_once NV_ROOTDIR . '/modules/menu/menu_blocks.php';
    $content = nv_metismenu($block_config, $blockID);
}

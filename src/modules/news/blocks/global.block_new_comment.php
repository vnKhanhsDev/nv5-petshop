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

if (!nv_function_exists('nv_comment_new')) {
    /**
     * nv_block_comment_new()
     *
     * @param string $module
     * @param array  $data_block
     * @return string
     */
    function nv_block_comment_new($module, $data_block)
    {
        global $nv_Lang;

        $html = '<div class="row mb-3">';
        $html .= '	<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('titlelength') . ':</label>';
        $html .= '	<div class="col-sm-5"><input type="text" name="config_titlelength" class="form-control" value="' . $data_block['titlelength'] . '"/><span class="form-text">' . $nv_Lang->getModule('titlenote') . '</span></div>';
        $html .= '</div>';

        $html .= '<div class="row mb-3">';
        $html .= '	<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('numrow') . ':</label>';
        $html .= '	<div class="col-sm-5"><input type="text" name="config_numrow" class="form-control" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * nv_block_comment_new_submit()
     *
     * @param string $module
     * @return array
     */
    function nv_block_comment_new_submit($module)
    {
        global $nv_Request;
        $return = [];
        $return['error'] = [];
        $return['config'] = [];
        $return['config']['titlelength'] = $nv_Request->get_int('config_titlelength', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);

        return $return;
    }

    /**
     * nv_comment_new()
     *
     * @param array $block_config
     * @return string|void
     */
    function nv_comment_new($block_config)
    {
        global $db, $site_mods, $db_slave, $module_info, $global_config;

        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_comment WHERE module = ' . $db->quote($module) . ' AND status=1 ORDER BY post_time DESC LIMIT ' . $block_config['numrow'];
        $result = $db_slave->query($sql);
        $array_comment = [];
        $array_news_id = [];
        while ($comment = $result->fetch()) {
            $array_comment[] = $comment;
            $array_news_id[] = $comment['id'];
        }

        if (!empty($array_news_id)) {
            $result = $db_slave->query('SELECT t1.id, t1.alias AS alias_id, t2.alias AS alias_cat FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $mod_data . '_cat t2 ON t1.catid = t2.catid WHERE t1.id IN (' . implode(',', array_unique($array_news_id)) . ') AND t1.status = 1');
            $array_news_id = [];
            while ($row = $result->fetch()) {
                $array_news_id[$row['id']] = $row;
            }

            $mod_file = $site_mods[$module]['module_file'];
            $block_theme = get_tpl_dir($module_info['template'], 'default', '/modules/' . $mod_file . '/block_new_comment.tpl');

            $xtpl = new XTemplate('block_new_comment.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
            $xtpl->assign('TEMPLATE', $block_theme);

            foreach ($array_comment as $comment) {
                if (isset($array_news_id[$comment['id']])) {
                    $comment['url_comment'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module . '&' . NV_OP_VARIABLE . '=' . $array_news_id[$comment['id']]['alias_cat'] . '/' . $array_news_id[$comment['id']]['alias_id'] . '-' . $comment['id'] . $global_config['rewrite_exturl'], true);
                    $comment['content'] = nv_clean60($comment['content'], $block_config['titlelength']);
                    $comment['post_time'] = nv_datetime_format($comment['post_time']);
                    $xtpl->assign('COMMENT', $comment);
                    $xtpl->parse('main.loop');
                }
            }
            $xtpl->parse('main');

            return $xtpl->text('main');
        }
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_comment_new($block_config);
}

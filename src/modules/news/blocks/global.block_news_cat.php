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

if (!nv_function_exists('nv_block_news_cat')) {
    /**
     * nv_block_config_news_cat()
     *
     * @param string $module
     * @param array  $data_block
     * @return string
     */
    function nv_block_config_news_cat($module, $data_block)
    {
        global $nv_Cache, $site_mods, $nv_Lang;

        $tooltip_position = [
            'top' => $nv_Lang->getModule('tooltip_position_top'),
            'bottom' => $nv_Lang->getModule('tooltip_position_bottom'),
            'left' => $nv_Lang->getModule('tooltip_position_left'),
            'right' => $nv_Lang->getModule('tooltip_position_right')
        ];

        $html = '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('catid') . ':</label>';

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        if (!is_array($data_block['catid'])) {
            $data_block['catid'] = [$data_block['catid']];
        }

        $html .= '<div class="col-sm-9">';
        foreach ($list as $l) {
            if ($l['status'] == 1 or $l['status'] == 2) {
                $xtitle_i = '';

                if ($l['lev'] > 0) {
                    for ($i = 1; $i <= $l['lev']; ++$i) {
                        $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                }
                $html .= '<div class="form-check"><input class="form-check-input" type="checkbox" name="config_catid[]" value="' . $l['catid'] . '" ' . ((in_array((int) $l['catid'], array_map('intval', $data_block['catid']), true)) ? ' checked="checked"' : '') . ' id="checkbox_catid_' . $l['catid'] . '"><label class="form-check-label" for="checkbox_catid_' . $l['catid'] . '">' . $xtitle_i . $l['title'] . '</label></div>';
            }
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('title_length') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_title_length" size="5" value="' . $data_block['title_length'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('numrow') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('showtooltip') . ':</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="row g-2 align-items-center">';
        $html .= '<div class="col-sm-2">';
        $html .= '<input class="form-check-input" type="checkbox" value="1" name="config_showtooltip" ' . ($data_block['showtooltip'] == 1 ? 'checked="checked"' : '') . ' /></div>';
        $html .= '<div class="col-sm-5">';
        $html .= '<div class="input-group">';
        $html .= '<div class="input-group-text">' . $nv_Lang->getModule('tooltip_position') . '</div>';
        $html .= '<select name="config_tooltip_position" class="form-select">';

        foreach ($tooltip_position as $key => $value) {
            $html .= '<option value="' . $key . '" ' . ($data_block['tooltip_position'] == $key ? 'selected="selected"' : '') . '>' . $value . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-sm-5">';
        $html .= '<div class="input-group">';
        $html .= '<div class="input-group-text">' . $nv_Lang->getModule('tooltip_length') . '</div>';
        $html .= '<input type="text" class="form-control" name="config_tooltip_length" value="' . $data_block['tooltip_length'] . '"/>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * nv_block_config_news_cat_submit()
     *
     * @param string $module
     * @return array
     */
    function nv_block_config_news_cat_submit($module)
    {
        global $nv_Request;
        $return = [];
        $return['error'] = [];
        $return['config'] = [];
        $return['config']['catid'] = $nv_Request->get_array('config_catid', 'post', []);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['title_length'] = $nv_Request->get_int('config_title_length', 'post', 20);
        $return['config']['showtooltip'] = $nv_Request->get_int('config_showtooltip', 'post', 0);
        $return['config']['tooltip_position'] = $nv_Request->get_string('config_tooltip_position', 'post', 0);
        $return['config']['tooltip_length'] = $nv_Request->get_string('config_tooltip_length', 'post', 0);

        return $return;
    }

    /**
     * nv_block_news_cat()
     *
     * @param array $block_config
     * @return string|void
     */
    function nv_block_news_cat($block_config)
    {
        global $nv_Cache, $module_array_cat, $site_mods, $module_config, $global_config, $db;

        $module = $block_config['module'];
        $show_no_image = $module_config[$module]['show_no_image'];
        $blockwidth = $module_config[$module]['blockwidth'];
        $order_articles_by = ($module_config[$module]['order_articles']) ? 'weight' : 'publtime';

        if (empty($block_config['catid'])) {
            return '';
        }

        $catid = implode(',', $block_config['catid']);

        $db->sqlreset()
            ->select('id, catid, title, alias, homeimgfile, homeimgthumb, hometext, publtime, external_link')
            ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows')
            ->where('status= 1 AND catid IN(' . $catid . ')')
            ->order($order_articles_by . ' DESC')
            ->limit($block_config['numrow']);
        $list = $nv_Cache->db($db->sql(), '', $module);

        if (!empty($list)) {
            $block_theme = get_tpl_dir($global_config['module_theme'], 'default', '/modules/news/block_groups.tpl');
            $xtpl = new XTemplate('block_groups.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/news');
            $xtpl->assign('TEMPLATE', $block_theme);
            $xtpl->assign('BLOCKWIDTH', $module_config[$module]['blockwidth']);
            $xtpl->assign('BLOCKHEIGHT', $module_config[$module]['blockheight']);

            foreach ($list as $l) {
                $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
                if ($l['homeimgthumb'] == 1) {
                    $l['thumb'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['homeimgfile'];
                    if (!empty($global_config['cdn_url'])) {
                        $l['thumb'] = $global_config['cdn_url'] . $l['thumb'];
                    }
                } elseif ($l['homeimgthumb'] == 2) {
                    $l['thumb'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['homeimgfile'];
                    if (!empty($global_config['cdn_url'])) {
                        $l['thumb'] = $global_config['cdn_url'] . $l['thumb'];
                    }
                } elseif ($l['homeimgthumb'] == 3) {
                    $l['thumb'] = $l['homeimgfile'];
                } elseif (!empty($show_no_image)) {
                    $l['thumb'] = NV_BASE_SITEURL . $show_no_image;
                } else {
                    $l['thumb'] = '';
                }

                $l['blockwidth'] = $module_config[$module]['blockwidth'];

                $l['hometext_clean'] = strip_tags($l['hometext']);
                $l['hometext_clean'] = nv_clean60($l['hometext_clean'], $block_config['tooltip_length'], true);

                if (!$block_config['showtooltip']) {
                    $xtpl->assign('TITLE', 'title="' . $l['title'] . '"');
                }

                $l['title_clean'] = nv_clean60($l['title'], $block_config['title_length']);

                if ($l['external_link']) {
                    $l['target_blank'] = 'target="_blank"';
                }

                $xtpl->assign('ROW', $l);
                if (!empty($l['thumb'])) {
                    $xtpl->parse('main.loop.img');
                }
                $xtpl->parse('main.loop');
            }

            if ($block_config['showtooltip']) {
                $xtpl->assign('TOOLTIP_POSITION', $block_config['tooltip_position']);
                $xtpl->parse('main.tooltip');
            }

            $xtpl->parse('main');

            return $xtpl->text('main');
        }
    }
}
if (defined('NV_SYSTEM')) {
    global $nv_Cache, $site_mods, $module_name, $global_array_cat, $module_array_cat;
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $global_array_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = [];
            $sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, keywords, groups_view, status FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'catid', $module);
            if (!empty($list)) {
                foreach ($list as $l) {
                    $module_array_cat[$l['catid']] = $l;
                    $module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_block_news_cat($block_config);
    }
}

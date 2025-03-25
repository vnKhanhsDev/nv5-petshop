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

if (!nv_function_exists('nv_copyright_info')) {
    /**
     * nv_copyright_info_config()
     *
     * @return string
     */
    function nv_copyright_info_config()
    {
        global $nv_Lang, $data_block;

        $html = '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('copyright_by') . ':</label>';
        $html .= '<div class="col-sm-9"><input class="form-control" type="text" name="copyright_by" value="' . nv_htmlspecialchars($data_block['copyright_by']) . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('copyright_url') . ':</label>';
        $html .= '<div class="col-sm-9"><input class="form-control" type="text" name="copyright_url" value="' . nv_htmlspecialchars($data_block['copyright_url']) . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('design_by') . ':</label>';
        $html .= '<div class="col-sm-9"><input class="form-control" type="text" name="design_by" value="' . nv_htmlspecialchars($data_block['design_by']) . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('design_url') . ':</label>';
        $html .= '<div class="col-sm-9"><input class="form-control" type="text" name="design_url" value="' . nv_htmlspecialchars($data_block['design_url']) . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('siteterms_url') . ':</label>';
        $html .= '<div class="col-sm-9"><input class="form-control" type="text" name="siteterms_url" value="' . nv_htmlspecialchars($data_block['siteterms_url']) . '"></div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * nv_copyright_info_submit()
     *
     * @return array
     */
    function nv_copyright_info_submit()
    {
        global $nv_Request;

        $return = [];
        $return['error'] = [];
        $return['config']['copyright_by'] = $nv_Request->get_title('copyright_by', 'post');
        $return['config']['copyright_url'] = $nv_Request->get_title('copyright_url', 'post');
        $return['config']['design_by'] = $nv_Request->get_title('design_by', 'post');
        $return['config']['design_url'] = $nv_Request->get_title('design_url', 'post');
        $return['config']['siteterms_url'] = $nv_Request->get_title('siteterms_url', 'post');

        return $return;
    }

    /**
     * nv_copyright_info()
     *
     * @param array $block_config
     * @return string
     */
    function nv_copyright_info($block_config)
    {
        global $global_config;

        $block_theme = get_tpl_dir([$global_config['module_theme'], $global_config['site_theme']], 'default', '/blocks/global.copyright.tpl');
        $xtpl = new XTemplate('global.copyright.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_global);

        if (empty($block_config['copyright_by'])) {
            $block_config['copyright_by'] = $global_config['site_name'];
        }
        if (empty($block_config['copyright_url'])) {
            $block_config['copyright_url'] = 'http://' . $global_config['my_domains'][0];
        }

        $xtpl->assign('DATA', $block_config);
        $xtpl->parse('main.copyright_by.copyright_url');
        $xtpl->parse('main.copyright_by.copyright_url2');
        $xtpl->parse('main.copyright_by');

        if (!empty($block_config['design_by'])) {
            if (!empty($block_config['design_url'])) {
                $xtpl->parse('main.design_by.design_url');
                $xtpl->parse('main.design_by.design_url2');
            }
            $xtpl->parse('main.design_by');
        }
        if (!empty($block_config['siteterms_url'])) {
            $xtpl->parse('main.siteterms_url');
        }
        if (defined('NV_IS_SPADMIN')) {
            $xtpl->parse('main.memory_time_usage');
        }
        $xtpl->parse('main');

        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_copyright_info($block_config);
}

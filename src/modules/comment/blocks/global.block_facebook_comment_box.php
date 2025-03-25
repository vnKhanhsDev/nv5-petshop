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

if (!nv_function_exists('nv_facebook_comment_box_blocks')) {
    /**
     * nv_block_config_facebook_comment_box_blocks()
     *
     * @param string $module
     * @param array  $data_block
     * @return string
     */
    function nv_block_config_facebook_comment_box_blocks($module, $data_block)
    {
        global $nv_Lang;

        $html = '';

        $html .= '<div class="row mb-3">';
        $html .= '	<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('facebookappid') . ':</label>';
        $html .= '	<div class="col-sm-9"><input class="form-control" type="text" name="config_facebookappid" value="' . $data_block['facebookappid'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '	<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('width') . ':</label>';
        $html .= '	<div class="col-sm-9"><input class="form-control" type="text" name="config_width" value="' . $data_block['width'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= ' <label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('numpost') . ':</label>';
        $html .= ' <div class="col-sm-9"><input class="form-control" type="text" name="config_numpost" value="' . $data_block['numpost'] . '"/></div>';
        $html .= '</div>';

        $html .= '<div class="row mb-3">';
        $html .= '	<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('scheme') . ':</label>';
        $html .= '	<div class="col-sm-5"> <select class="form-select" name="config_scheme"> ';

        $se1 = ($data_block['scheme'] == 'light') ? 'selected="selected"' : '';
        $se2 = ($data_block['scheme'] == 'dark') ? 'selected="selected"' : '';

        $html .= ' <option value="light"' . $se1 . '> Light </option>';
        $html .= ' <option value="dark"' . $se2 . ' >Dark </option>';

        $html .= ' <\select>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * nv_block_config_facebook_comment_box_blocks_submit()
     *
     * @param string $module
     * @return array
     */
    function nv_block_config_facebook_comment_box_blocks_submit($module)
    {
        global $nv_Request;
        $return = [];
        $return['error'] = [];
        $return['config'] = [];
        $return['config']['facebookappid'] = $nv_Request->get_title('config_facebookappid', 'post', 0);
        $return['config']['width'] = $nv_Request->get_string('config_width', 'post', 0);
        $return['config']['numpost'] = $nv_Request->get_int('config_numpost', 'post', 0);
        $return['config']['scheme'] = $nv_Request->get_title('config_scheme', 'post', 0);

        return $return;
    }

    /**
     * nv_facebook_comment_box_blocks()
     *
     * @param array $block_config
     * @return string
     */
    function nv_facebook_comment_box_blocks($block_config)
    {
        global $page_url, $module_name;
        $content = '';
        if (!defined('FACEBOOK_JSSDK')) {
            $lang = (NV_LANG_DATA == 'vi') ? 'vi_VN' : 'en_US';
            $facebookappid = (isset($module_config[$module_name]['facebookappid'])) ? $module_config[$module_name]['facebookappid'] : $block_config['facebookappid'];

            $content .= '<div id="fb-root"></div>
			<script' . (defined('NV_SCRIPT_NONCE') ? ' nonce="' . NV_SCRIPT_NONCE . '"' : '') . '>
			 (function(d, s, id) {
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) return;
			 js = d.createElement(s); js.id = id;
			 js.src = "//connect.facebook.net/' . $lang . '/all.js#xfbml=1&appId=' . $facebookappid . "\";
			 fjs.parentNode.insertBefore(js, fjs);
			 }(document, 'script', 'facebook-jssdk'));
			</script>";
            define('FACEBOOK_JSSDK', true);
        }
        $href = !empty($page_url) ? urlRewriteWithDomain($page_url, NV_MAIN_DOMAIN) : '';
        $content .= '<div class="fb-comments" data-href="' . $href . '" data-num-posts="' . $block_config['numpost'] . '" data-width="' . $block_config['width'] . '" data-colorscheme="' . $block_config['scheme'] . '"></div>';

        return $content;
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_facebook_comment_box_blocks($block_config);
}

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

if (!nv_function_exists('nv_company_info')) {
    /**
     * nv_company_info_config()
     *
     * @param string $module
     * @param array  $data_block
     * @return string
     */
    function nv_company_info_config($module, $data_block)
    {
        global $nv_Lang;

        $html = '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_name') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_name" value="' . $data_block['company_name'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_sortname') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_sortname" value="' . $data_block['company_sortname'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_regcode') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_regcode" value="' . $data_block['company_regcode'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_regplace') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_regplace" value="' . $data_block['company_regplace'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_licensenumber') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_licensenumber" value="' . $data_block['company_licensenumber'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_responsibility') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_responsibility" value="' . $data_block['company_responsibility'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_address') . ':</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<div class="row g-2 mb-3">';
        $html .= '<div class="col-8">';
        $html .= '<input type="text" class="form-control" name="config_company_address" id="config_company_address" value="' . $data_block['company_address'] . '">';
        $html .= '</div>';
        $html .= '<div class="col-4">';
        $html .= '<select name="config_company_showmap" id="config_company_mapshow" class="form-select">
                    <option value="0"' . (empty($data_block['company_showmap']) ? ' selected="selected"' : '') . '>' . $nv_Lang->getModule('cominfo_map_no') . '</option>
                    <option value="1"' . (!empty($data_block['company_showmap']) ? ' selected="selected"' : '') . '>' . $nv_Lang->getModule('cominfo_map_yes') . '</option>
                  </select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="config_company_maparea"' . (!empty($data_block['company_showmap']) ? '' : ' class="d-none"') . '>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getModule('cominfo_mapurl') . ':</label>';
        $html .= '<div class="col-sm-9">';
        $html .= '<input type="text" class="form-control" name="config_company_mapurl" id="config_company_mapurl" value="' . $data_block['company_mapurl'] . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_phone') . ':</label>';
        $html .= '<div class="col-sm-9">
                    <input type="text" class="form-control mb-2" name="config_company_phone" value="' . $data_block['company_phone'] . '">
                    <button class="btn btn-secondary btn-sm" onclick="modalShow(\'' . $nv_Lang->getGlobal('phone_note_title') . '\',\'' . $nv_Lang->getGlobal('phone_note_content') . '\');return!1;">' . $nv_Lang->getGlobal('phone_note_title') . '</button>
                  </div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_fax') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_fax" value="' . $data_block['company_fax'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_email') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_email" value="' . $data_block['company_email'] . '"><span class="form-text">' . $nv_Lang->getGlobal('multi_note') . '</span></div>';
        $html .= '</div>';
        $html .= '<div class="row mb-3">';
        $html .= '<label class="col-sm-3 col-form-label text-sm-end text-truncate fw-medium">' . $nv_Lang->getGlobal('company_website') . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control" name="config_company_website" value="' . $data_block['company_website'] . '"><span class="form-text">' . $nv_Lang->getGlobal('multi_note') . '</span></div>';
        $html .= '</div>';
        $html .= '<tr class="hide">';
        $html .= '<div class="col-sm-9" colspan="2"><script type="text/javascript">
        $(document).ready(function() {
            $("#config_company_mapshow").on("change", function() {
                if ($(this).val() == "1") {
                    $("#config_company_maparea").removeClass("d-none");
                } else {
                    $("#config_company_maparea").addClass("d-none");
                }
            });
        });
        </script></div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * nv_company_info_submit()
     *
     * @return array
     */
    function nv_company_info_submit()
    {
        global $nv_Request;

        $return = [];
        $return['error'] = [];
        $return['config']['company_name'] = $nv_Request->get_title('config_company_name', 'post');
        $return['config']['company_sortname'] = $nv_Request->get_title('config_company_sortname', 'post');
        $return['config']['company_regcode'] = $nv_Request->get_title('config_company_regcode', 'post');
        $return['config']['company_regplace'] = $nv_Request->get_title('config_company_regplace', 'post');
        $return['config']['company_licensenumber'] = $nv_Request->get_title('config_company_licensenumber', 'post');
        $return['config']['company_responsibility'] = $nv_Request->get_title('config_company_responsibility', 'post');
        $return['config']['company_address'] = $nv_Request->get_title('config_company_address', 'post');
        $return['config']['company_showmap'] = $nv_Request->get_int('config_company_showmap', 'post', 0) == 0 ? 0 : 1;
        $return['config']['company_mapurl'] = $nv_Request->get_title('config_company_mapurl', 'post', '');
        $return['config']['company_phone'] = $nv_Request->get_title('config_company_phone', 'post');
        $return['config']['company_fax'] = $nv_Request->get_title('config_company_fax', 'post');
        $return['config']['company_email'] = $nv_Request->get_title('config_company_email', 'post');
        $return['config']['company_website'] = $nv_Request->get_title('config_company_website', 'post');

        return $return;
    }

    /**
     * nv_company_info()
     *
     * @param array $block_config
     * @return string
     */
    function nv_company_info($block_config)
    {
        global $global_config, $nv_Lang;

        $block_theme = get_tpl_dir([$global_config['module_theme'], $global_config['site_theme']], 'default', '/blocks/global.company_info.tpl');
        $xtpl = new XTemplate('global.company_info.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_global);
        $xtpl->assign('DATA', $block_config);

        if (!empty($block_config['company_name'])) {
            if (!empty($block_config['company_sortname'])) {
                $xtpl->parse('main.company_name.company_sortname');
            }
            $xtpl->parse('main.company_name');
        }

        $key = [];
        $i = 0;
        if (!empty($block_config['company_regcode'])) {
            $key[$i] = $nv_Lang->getGlobal('company_regcode2') . ': ' . $block_config['company_regcode'];
            if (!empty($block_config['company_regplace'])) {
                $key[$i] .= ', ' . $nv_Lang->getGlobal('company_regplace') . ' ' . $block_config['company_regplace'];
            }
            ++$i;
        }
        if (!empty($block_config['company_licensenumber'])) {
            $key[$i] = $nv_Lang->getGlobal('company_licensenumber') . ': ' . $block_config['company_licensenumber'];
            ++$i;
        }

        if ($i) {
            $key = implode('.<br>', $key);
            $xtpl->assign('LICENSE', $key);
            $xtpl->parse('main.company_regcode');
        }

        if (!empty($block_config['company_responsibility'])) {
            $xtpl->parse('main.company_responsibility');
        }

        if (!empty($block_config['company_address'])) {
            if (!empty($block_config['company_showmap'])) {
                $xtpl->parse('main.company_map_modal');
                $xtpl->parse('main.company_address.company_map_triger');
            }

            $xtpl->parse('main.company_address');
        }

        if (!empty($block_config['company_phone'])) {
            $nums = array_map('trim', explode('|', nv_unhtmlspecialchars($block_config['company_phone'])));
            foreach ($nums as $k => $num) {
                unset($m);
                if (preg_match("/^(.*)\s*\[([0-9\+\.\,\;\*\#]+)\]$/", $num, $m)) {
                    $xtpl->assign('PHONE', ['number' => nv_htmlspecialchars($m[1]), 'href' => $m[2]]);
                    $xtpl->parse('main.company_phone.item.href');
                    $xtpl->parse('main.company_phone.item.href2');
                } else {
                    $num = preg_replace("/\[[^\]]*\]/", '', $num);
                    $xtpl->assign('PHONE', ['number' => nv_htmlspecialchars($num)]);
                }
                if ($k) {
                    $xtpl->parse('main.company_phone.item.comma');
                }
                $xtpl->parse('main.company_phone.item');
            }

            $xtpl->parse('main.company_phone');
        }
        if (!empty($block_config['company_fax'])) {
            $xtpl->parse('main.company_fax');
        }
        if (!empty($block_config['company_email'])) {
            $emails = array_map('trim', explode(',', $block_config['company_email']));
            foreach ($emails as $k => $email) {
                $xtpl->assign('EMAIL', $email);
                if ($k) {
                    $xtpl->parse('main.company_email.item.comma');
                }
                $xtpl->parse('main.company_email.item');
            }
            $xtpl->parse('main.company_email');
        }
        if (!empty($block_config['company_website'])) {
            $webs = array_map('trim', explode(',', $block_config['company_website']));
            foreach ($webs as $k => $web) {
                if (!preg_match("/^https?\:\/\//", $web)) {
                    $web = 'http://' . $web;
                }
                $xtpl->assign('WEBSITE', $web);
                if ($k) {
                    $xtpl->parse('main.company_website.item.comma');
                }
                $xtpl->parse('main.company_website.item');
            }
            $xtpl->parse('main.company_website');
        }
        $xtpl->assign('SITE_LOGO', NV_MY_DOMAIN . NV_BASE_SITEURL . $global_config['site_logo']);
        $xtpl->parse('main');

        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_company_info($block_config);
}

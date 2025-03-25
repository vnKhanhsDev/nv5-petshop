<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_voting')) {
    /**
     * nv_block_voting()
     *
     * @return string
     * @param mixed $block_config
     */
    function nv_block_voting($block_config)
    {
        global $nv_Cache, $db, $my_footer, $site_mods, $global_config, $nv_Lang, $module_config;

        $module = $block_config['module'];
        $content = '';

        if (!isset($site_mods['voting'])) {
            return '';
        }

        $sql = 'SELECT vid, question, link, acceptcm, active_captcha, groups_view, publ_time, exp_time FROM ' . NV_PREFIXLANG . '_' . $site_mods['voting']['module_data'] . ' WHERE act=1';

        $list = $nv_Cache->db($sql, 'vid', 'voting');

        if (empty($list)) {
            return '';
        }

        $allowed = [];
        $is_update = [];

        $a = 0;
        foreach ($list as $row) {
            if ($row['exp_time'] > 0 and $row['exp_time'] < NV_CURRENTTIME) {
                $is_update[] = $row['vid'];
            } elseif ($row['publ_time'] <= NV_CURRENTTIME and nv_user_in_groups($row['groups_view'])) {
                $allowed[$a] = $row;
                ++$a;
            }
        }

        if (!empty($is_update)) {
            $is_update = implode(',', $is_update);

            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $site_mods['voting']['module_data'] . ' SET act=0 WHERE vid IN (' . $is_update . ')';
            $db->query($sql);

            $nv_Cache->delMod('voting');
        }

        if ($allowed) {
            --$a;
            $rand = random_int(0, $a);
            $current_voting = $allowed[$rand];

            $sql = 'SELECT id, vid, title, url FROM ' . NV_PREFIXLANG . '_' . $site_mods['voting']['module_data'] . '_rows WHERE vid = ' . $current_voting['vid'] . ' ORDER BY id ASC';

            $list = $nv_Cache->db($sql, '', 'voting');

            if (empty($list)) {
                return '';
            }

            $nv_Lang->loadModule($site_mods['voting']['module_file'], false, true);

            $block_theme = get_tpl_dir([$global_config['module_theme'], $global_config['site_theme']], 'default', '/modules/' . $site_mods['voting']['module_file'] . '/global.voting.tpl');

            $action = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=voting';

            $voting_array = [
                'checkss' => md5($current_voting['vid'] . NV_CHECK_SESSION),
                'accept' => (int) $current_voting['acceptcm'],
                'active_captcha' => (int) $current_voting['active_captcha'],
                'errsm' => (int) $current_voting['acceptcm'] > 1 ? $nv_Lang->getModule('voting_warning_all', (int) $current_voting['acceptcm']) : $nv_Lang->getModule('voting_warning_accept1'),
                'vid' => $current_voting['vid'],
                'question' => (empty($current_voting['link'])) ? $current_voting['question'] : '<a target="_blank" href="' . $current_voting['link'] . '">' . $current_voting['question'] . '</a>',
                'action' => $action,
                'langresult' => $nv_Lang->getModule('voting_result'),
                'langsubmit' => $nv_Lang->getModule('voting_hits')
            ];

            $xtpl = new XTemplate('global.voting.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $site_mods['voting']['module_file']);
            $xtpl->assign('LANG', \NukeViet\Core\Language::$tmplang_module);
            $xtpl->assign('VOTING', $voting_array);
            $xtpl->assign('TEMPLATE', $block_theme);

            foreach ($list as $row) {
                if (!empty($row['url'])) {
                    $row['title'] = '<a target="_blank" href="' . $row['url'] . '">' . $row['title'] . '</a>';
                }
                $xtpl->assign('RESULT', $row);
                if ((int) $current_voting['acceptcm'] > 1) {
                    $xtpl->parse('main.resultn');
                } else {
                    $xtpl->parse('main.result1');
                }
            }

            if ($voting_array['active_captcha']) {
                $captcha_type = (empty($module_config[$module]['captcha_type']) or in_array($module_config[$module]['captcha_type'], ['captcha', 'recaptcha', 'turnstile'], true)) ? $module_config[$module]['captcha_type'] : 'captcha';
                if ($captcha_type == 'recaptcha' and (empty($global_config['recaptcha_sitekey']) or empty($global_config['recaptcha_secretkey']))) {
                    $captcha_type = 'captcha';
                }
                if ($captcha_type == 'turnstile' and (empty($global_config['turnstile_sitekey']) or empty($global_config['turnstile_secretkey']))) {
                    $captcha_type = 'captcha';
                }

                if ($captcha_type == 'recaptcha' and $global_config['recaptcha_ver'] == 3) {
                    $xtpl->parse('main.recaptcha3');
                } elseif (($captcha_type == 'recaptcha' and $global_config['recaptcha_ver'] == 2) or $captcha_type == 'captcha') {
                    if ($captcha_type == 'recaptcha' and $global_config['recaptcha_ver'] == 2) {
                        $xtpl->assign('RECAPTCHA_ELEMENT', 'recaptcha' . nv_genpass(8));
                        $xtpl->assign('N_CAPTCHA', $nv_Lang->getGlobal('securitycode1'));
                        $xtpl->parse('main.has_captcha.recaptcha');
                    } else {
                        $xtpl->assign('N_CAPTCHA', $nv_Lang->getGlobal('securitycode'));
                        $xtpl->parse('main.has_captcha.basic');
                    }
                    $xtpl->parse('main.has_captcha');
                } elseif ($captcha_type == 'turnstile') {
                    $xtpl->parse('main.turnstile');
                }
            }

            $xtpl->parse('main');
            $content = $xtpl->text('main');

            $nv_Lang->changeLang();
        }

        return $content;
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_voting($block_config);
}

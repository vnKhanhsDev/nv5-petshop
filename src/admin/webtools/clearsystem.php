<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_WEBTOOLS')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('clearsystem');

/**
 * @param string $dir
 * @param string $base
 * @return array
 */
function nv_clear_files($dir, $base)
{
    $dels = [];
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (!preg_match("/^[\.]{1,2}([a-zA-Z0-9]*)$/", $file) and $file != 'index.html' and is_file($dir . '/' . $file)) {
                if (unlink($dir . '/' . $file)) {
                    $dels[] = $base . '/' . $file;
                }
            }
        }
        closedir($dh);
    }
    if (!file_exists($dir . '/index.html')) {
        file_put_contents($dir . '/index.html', '');
    }

    return $dels;
}

$clears = ['clearcache'];
if (defined('NV_IS_GODADMIN')) {
    $clears = array_merge($clears, ['clearfiletemp', 'clearerrorlogs', 'clearip_logs']);
}

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_info['userid']);

if ($checkss == $nv_Request->get_string('checkss', 'post') and $nv_Request->isset_request('deltype', 'post')) {
    $deltype = $nv_Request->get_typed_array('deltype', 'post', 'string', []);
    $deltype = array_intersect($deltype, $clears);
    if (empty($deltype)) {
        nv_jsonOutput([
            'status' => 'error',
            'mess' => 'Data Wrong!!!'
        ]);
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('clearsystem'), implode(', ', $deltype), $admin_info['userid']);
    clearstatcache();

    $contents = [];
    foreach ($deltype as $type) {
        if ($type == 'clearfiletemp') {
            $dir = NV_ROOTDIR . '/' . NV_TEMP_DIR;
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (preg_match('/^(' . nv_preg_quote(NV_TEMPNAM_PREFIX) . ")[a-zA-Z0-9\-\_\.]+$/", $file)) {
                        if (is_file($dir . '/' . $file)) {
                            if (@unlink($dir . '/' . $file)) {
                                $contents[] = NV_TEMP_DIR . '/' . $file;
                            }
                        } else {
                            $rt = nv_deletefile($dir . '/' . $file, true);
                            if ($rt[0] == 1) {
                                $contents[] = NV_TEMP_DIR . '/' . $file;
                            }
                        }
                    }
                }
                closedir($dh);
            }
        } elseif ($type == 'clearerrorlogs') {
            $dir = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/error_logs';
            $files = nv_clear_files($dir, NV_LOGS_DIR . '/error_logs');
            foreach ($files as $file) {
                $contents[] = $file;
            }

            $dir = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/error_logs/errors256';
            $files = nv_clear_files($dir, NV_LOGS_DIR . '/error_logs/errors256');
            foreach ($files as $file) {
                $contents[] = $file;
            }

            $dir = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/error_logs/old';
            $files = nv_clear_files($dir, NV_LOGS_DIR . '/error_logs/old');
            foreach ($files as $file) {
                $contents[] = $file;
            }

            $dir = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/error_logs/tmp';
            $files = nv_clear_files($dir, NV_LOGS_DIR . '/error_logs/tmp');
            foreach ($files as $file) {
                $contents[] = $file;
            }
        } elseif ($type == 'clearip_logs') {
            $dir = NV_ROOTDIR . '/' . NV_LOGS_DIR . '/ip_logs';
            $files = nv_clear_files($dir, NV_LOGS_DIR . '/ip_logs');
            foreach ($files as $file) {
                $contents[] = $file;
            }
        } elseif ($type == 'clearcache') {
            if ($dh = opendir(NV_ROOTDIR . '/' . NV_CACHEDIR)) {
                while (($modname = readdir($dh)) !== false) {
                    if (preg_match($global_config['check_module'], $modname)) {
                        $cacheDir = NV_ROOTDIR . '/' . NV_CACHEDIR . '/' . $modname;
                        $files = nv_clear_files($cacheDir, NV_CACHEDIR . '/' . $modname);
                        foreach ($files as $file) {
                            $contents[] = $file;
                        }
                    }
                }
                closedir($dh);
            }
            $nv_Cache->delAll();
            if (defined('NV_IS_GODADMIN')) {
                $db->query('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value = '" . NV_CURRENTTIME . "' WHERE lang = 'sys' AND module = 'global' AND config_name = 'timestamp'");
                nv_save_file_config_global();
            }
        }
    }

    nv_jsonOutput([
        'status' => 'success',
        'data' => $contents
    ]);
}

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('clearsystem.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);
$tpl->assign('CHECKSS', $checkss);
$tpl->assign('CLEARS', $clears);

$contents = $tpl->fetch('clearsystem.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

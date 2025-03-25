<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_LANG')) {
    exit('Stop!!!');
}

$include_lang = '';
$page_title = $language_array[$dirlang]['name'];

if ($nv_Request->isset_request('idfile,checksess', 'get') and $nv_Request->get_string('checksess', 'get') == md5($nv_Request->get_int('idfile', 'get') . NV_CHECK_SESSION)) {
    $idfile = $nv_Request->get_int('idfile', 'get');
    nv_mkdir(NV_ROOTDIR . '/includes/language/', $dirlang);
    $content = nv_admin_write_lang($dirlang, $idfile);

    //Resets the contents of the opcode cache
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }

    if (empty($content)) {
        nv_jsonOutput([
            'status' => 'OK',
            'mess' => $nv_Lang->getModule('nv_lang_wite_ok') . ': ' . str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang))
        ]);
    }

    nv_jsonOutput([
        'status' => 'error',
        'mess' => $content
    ]);
}

if ($nv_Request->isset_request('checksess', 'get') and $nv_Request->get_string('checksess', 'get') == md5('writeallfile' . NV_CHECK_SESSION)) {
    $dirlang = $nv_Request->get_string('dirlang', 'get', '');

    if ($dirlang != '' and preg_match('/^([a-z]{2})$/', $dirlang)) {
        nv_mkdir(NV_ROOTDIR . '/includes/language/', $dirlang);

        $content = '';
        $array_filename = [];

        $result = $db->query('SELECT idfile, author_' . $dirlang . ' FROM ' . NV_LANGUAGE_GLOBALTABLE . '_file ORDER BY idfile ASC');
        while ([$idfile, $author_lang] = $result->fetch(3)) {
            $content = nv_admin_write_lang($dirlang, $idfile);

            if (!empty($content)) {
                break;
            }
            $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));
        }

        if (empty($content)) {
            nv_jsonOutput([
                'success' => 1,
                'text' => $nv_Lang->getModule('nv_lang_wite_ok'),
                'files' => array_values($array_filename)
            ]);
        }
    }

    nv_jsonOutput([
        'success' => 0,
        'text' => $nv_Lang->getModule('nv_error_write_file')
    ]);
}

nv_jsonOutput([
    'success' => 0,
    'text' => 'Wrong request data!!!'
]);

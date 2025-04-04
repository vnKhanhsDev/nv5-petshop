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

/**
 * nv_admin_read_lang()
 *
 * @param mixed $dirlang
 * @param mixed $idfile
 * @param mixed $module
 * @param mixed $admin_file
 * @return error read file
 */
function nv_admin_read_lang($dirlang, $module, $admin_file = 1)
{
    global $db, $global_config, $include_lang, $nv_Lang;

    $include_lang = '';
    $modules_exit = nv_scandir(NV_ROOTDIR . '/modules', $global_config['check_module']);

    if (preg_match('/^theme\_(.*?)$/', $module, $m)) {
        // Ngôn ngữ của giao diện
        $include_lang = NV_ROOTDIR . '/themes/' . $m[1] . '/language/' . $dirlang . '.php';
    } elseif ($module == 'global' and $admin_file == 1) {
        // Global trong quản trị
        $include_lang = NV_ROOTDIR . '/includes/language/' . $dirlang . '/admin_' . $module . '.php';
    } elseif ($module == 'global' and $admin_file == 0) {
        // Global ngoài site
        $include_lang = NV_ROOTDIR . '/includes/language/' . $dirlang . '/' . $module . '.php';
    } elseif ($module == 'install' and $admin_file == 0) {
        // Lang cài đặt ngoài site
        $include_lang = NV_ROOTDIR . '/includes/language/' . $dirlang . '/' . $module . '.php';
    } elseif (in_array($module, $modules_exit, true) and $admin_file == 0) {
        // Lang các module
        $include_lang = NV_ROOTDIR . '/modules/' . $module . '/language/' . $dirlang . '.php';
    } elseif (file_exists(NV_ROOTDIR . '/includes/language/' . $dirlang . '/admin_' . $module . '.php')) {
        // Lang các module trong quản trị
        $admin_file = 1;
        $include_lang = NV_ROOTDIR . '/includes/language/' . $dirlang . '/admin_' . $module . '.php';
    }

    if ($include_lang != '' and file_exists($include_lang)) {
        $lang_module = [];
        $lang_global = [];
        $lang_translator = [];

        include $include_lang;

        $sth = $db->prepare('SELECT idfile, langtype FROM ' . NV_LANGUAGE_GLOBALTABLE . '_file WHERE module = :module AND admin_file= :admin_file');
        $sth->bindParam(':module', $module, PDO::PARAM_STR);
        $sth->bindParam(':admin_file', $admin_file, PDO::PARAM_STR);
        $sth->execute();
        [$idfile, $langtype] = $sth->fetch(3);

        if (empty($idfile)) {
            // Tạo file mới trong CSDL
            $langtype = isset($lang_translator['langtype']) ? trim($lang_translator['langtype']) : 'lang_theme';

            $lang_translator_save = [];
            $lang_translator_save['author'] = isset($lang_translator['author']) ? trim($lang_translator['author']) : 'VINADES.,JSC <contact@vinades.vn>';
            $lang_translator_save['createdate'] = isset($lang_translator['createdate']) ? trim($lang_translator['createdate']) : date('d/m/Y, H:i');
            $lang_translator_save['copyright'] = isset($lang_translator['copyright']) ? trim($lang_translator['copyright']) : 'Copyright (C) ' . date('Y') . ' VINADES.,JSC. All rights reserved';
            $lang_translator_save['info'] = isset($lang_translator['info']) ? trim($lang_translator['info']) : '';
            $lang_translator_save['langtype'] = $langtype;

            $data = [];
            $data['module'] = $module;
            $data['admin_file'] = $admin_file;
            $data['langtype'] = $langtype;
            $data['author'] = serialize($lang_translator_save);
            $idfile = $db->insert_id('INSERT INTO ' . NV_LANGUAGE_GLOBALTABLE . '_file (module, admin_file, langtype, author_' . $dirlang . ') VALUES (:module, :admin_file, :langtype, :author)', 'idfile', $data);
            if (empty($idfile)) {
                nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), 'error read file: ' . str_replace(NV_ROOTDIR . '/', '', $include_lang), 404);
            }
        } else {
            // Cập nhật lại tác giả cho các file đã có trong CSDL
            $lang_translator_save = [];

            $langtype = isset($lang_translator['langtype']) ? trim($lang_translator['langtype']) : 'lang_theme';

            $lang_translator_save['author'] = isset($lang_translator['author']) ? trim($lang_translator['author']) : 'VINADES.,JSC <contact@vinades.vn>';
            $lang_translator_save['createdate'] = isset($lang_translator['createdate']) ? trim($lang_translator['createdate']) : date('d/m/Y, H:i');
            $lang_translator_save['copyright'] = isset($lang_translator['copyright']) ? trim($lang_translator['copyright']) : 'Copyright (C) ' . date('Y') . ' VINADES.,JSC. All rights reserved';
            $lang_translator_save['info'] = isset($lang_translator['info']) ? trim($lang_translator['info']) : '';
            $lang_translator_save['langtype'] = $langtype;

            $author = serialize($lang_translator_save);
            try {
                $sth = $db->prepare('UPDATE ' . NV_LANGUAGE_GLOBALTABLE . '_file SET author_' . $dirlang . '= :author WHERE idfile= ' . $idfile);
                $sth->bindParam(':author', $author, PDO::PARAM_STR, strlen($author));
                $sth->execute();
            } catch (PDOException $e) {
                nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $e->getMessage(), 404);
            }
        }

        $array_full_readlang = [
            'lang_global' => $lang_global,
            'lang_module' => $lang_module
        ];
        $array_lang_key = $array_lang_value = [];

        $columns_array = $db->columns_array(NV_LANGUAGE_GLOBALTABLE . '_file');
        foreach ($columns_array as $row) {
            if (substr($row['field'], 0, 7) == 'author_' and $row['field'] != 'author_' . $dirlang) {
                $array_lang_key[] = str_replace('author_', 'lang_', $row['field']);
                $array_lang_value[] = '';
            }
        }

        $string_lang_key = implode(', ', $array_lang_key);
        $string_lang_value = '';

        if ($string_lang_key != '') {
            $string_lang_key = ', ' . $string_lang_key;
            $string_lang_value = implode("', '", $array_lang_value);
            $string_lang_value = ", '" . $string_lang_value . "'";
        }

        $read_type = (int) $global_config['read_type'];

        $sth_is = $db->prepare('INSERT INTO ' . NV_LANGUAGE_GLOBALTABLE . ' (
            idfile, langtype, lang_key, weight, lang_' . $dirlang . ', update_' . $dirlang . '
        ) VALUES (
            :idfile, :langtype, :lang_key, :weight, :lang_value, ' . NV_CURRENTTIME . '
        )');
        $sth_ud = $db->prepare('UPDATE ' . NV_LANGUAGE_GLOBALTABLE . ' SET
            lang_' . $dirlang . ' = :lang_value,
            update_' . $dirlang . ' = ' . NV_CURRENTTIME . '
        WHERE idfile = :idfile AND langtype=:langtype AND lang_key = :lang_key');

        foreach ($array_full_readlang as $langtype_row => $data_row) {
            $weight = 0;
            foreach ($data_row as $lang_key => $lang_value) {
                $check_type_update = false;
                $lang_key = trim($lang_key);
                $lang_value = nv_nl2br($lang_value);
                $lang_value = preg_replace("/<br\s*\/>/", '<br />', $lang_value);
                $lang_value = preg_replace("/<\/\s*br\s*>/", '<br />', $lang_value);

                if ($read_type == 0 or $read_type == 1) {
                    ++$weight;
                    try {
                        $sth_is->bindParam(':idfile', $idfile, PDO::PARAM_INT);
                        $sth_is->bindParam(':langtype', $langtype_row, PDO::PARAM_STR);
                        $sth_is->bindParam(':lang_key', $lang_key, PDO::PARAM_STR);
                        $sth_is->bindParam(':weight', $weight, PDO::PARAM_INT);
                        $sth_is->bindParam(':lang_value', $lang_value, PDO::PARAM_STR);
                        $sth_is->execute();
                        if ($read_type == 0 and !$sth_is->rowCount()) {
                            $check_type_update = true;
                        }
                    } catch (PDOException $e) {
                        if ($read_type == 0) {
                            $check_type_update = true;
                        }
                    }
                }

                if ($read_type == 2 or $check_type_update) {
                    ++$weight;
                    $sth_ud->bindParam(':idfile', $idfile, PDO::PARAM_INT);
                    $sth_ud->bindParam(':langtype', $langtype_row, PDO::PARAM_STR);
                    $sth_ud->bindParam(':lang_key', $lang_key, PDO::PARAM_STR);
                    $sth_is->bindParam(':weight', $weight, PDO::PARAM_INT);
                    $sth_ud->bindParam(':lang_value', $lang_value, PDO::PARAM_STR);
                    $sth_ud->execute();
                }
            }
        }

        return '';
    }
    $include_lang = '';

    return $nv_Lang->getModule('nv_error_exit_module') . ' : ' . $module;
}

$dirlang = $nv_Request->get_title('dirlang', 'get', '');
$page_title = $language_array[$dirlang]['name'] . ': ' . $nv_Lang->getModule('nv_admin_read');

if ($nv_Request->get_string('checksess', 'get') == md5('readallfile' . NV_CHECK_SESSION) and preg_match('/^([a-z]{2})$/', $dirlang) and is_dir(NV_ROOTDIR . '/includes/language/' . $dirlang)) {
    $array_filename = [];

    nv_admin_add_field_lang($dirlang);
    // Đọc ngôn ngữ global ngoài site
    nv_admin_read_lang($dirlang, 'global', 0);
    // Đọc ngôn ngữ cài đặt ngoài site
    nv_admin_read_lang($dirlang, 'install', 0);

    $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));

    // Đọc ngôn ngữ global admin
    nv_admin_read_lang($dirlang, 'global', 1);

    $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));
    $dirs = nv_scandir(NV_ROOTDIR . '/' . NV_ADMINDIR, $global_config['check_module']);

    foreach ($dirs as $module) {
        // Đọc ngôn ngữ các module trong quản trị
        nv_admin_read_lang($dirlang, $module, 1);
        $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));
    }

    $dirs = nv_scandir(NV_ROOTDIR . '/modules', $global_config['check_module']);
    foreach ($dirs as $module) {
        // Đọc ngôn ngữ ngoài site các module
        nv_admin_read_lang($dirlang, $module, 0);
        $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));

        // Đọc ngôn ngữ admin các module
        nv_admin_read_lang($dirlang, $module, 1);
        $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));

        $blocks = nv_scandir(NV_ROOTDIR . '/modules/' . $module . '/language/', '/^block\.(global|module)\.([a-zA-Z0-9\-\_]+)\_' . $dirlang . '\.php$/');
        foreach ($blocks as $file_i) {
            // Đọc ngôn ngữ các block của module tương ứng
            nv_admin_read_lang($dirlang, $module, $file_i);
        }
    }

    $dirs1 = nv_scandir(NV_ROOTDIR . '/themes', $global_config['check_theme']);
    $dirs2 = nv_scandir(NV_ROOTDIR . '/themes', $global_config['check_theme_mobile']);
    $dirs = array_unique(array_merge_recursive($dirs1, $dirs2));
    foreach ($dirs as $theme) {
        // Đọc ngôn ngữ các giao diện
        nv_admin_read_lang($dirlang, 'theme_' . $theme, 0);
        $array_filename[] = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $include_lang));
    }
    $array_filename = array_filter($array_filename);
    $nv_Request->set_Cookie('drlg', $dirlang, NV_LIVE_COOKIE_TIME);

    nv_jsonOutput([
        'success' => 1,
        'text' => $nv_Lang->getModule('read_files'),
        'files' => array_values($array_filename)
    ]);
}

nv_jsonOutput([
    'success' => 0,
    'text' => 'Wrong request data!!!'
]);

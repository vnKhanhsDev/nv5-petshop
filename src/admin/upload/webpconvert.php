<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

if ($nv_Request->get_title('checkss', 'post', '') !== NV_CHECK_SESSION) {
    nv_jsonOutput([
        'status' => 'error',
        'mess' => 'Error session!!!'
    ]);
}

$path = nv_check_path_upload($nv_Request->get_string('path', 'post'));
$check_allow_upload_dir = nv_check_allow_upload_dir($path);

if (!isset($check_allow_upload_dir['move_file'])) {
    nv_jsonOutput([
        'status' => 'error',
        'mess' => $nv_Lang->getModule('notlevel')
    ]);
}

$img = htmlspecialchars(trim($nv_Request->get_string('img', 'post')), ENT_QUOTES);
$img = basename($img);

if (empty($img)) {
    nv_jsonOutput([
        'status' => 'error',
        'mess' => $nv_Lang->getModule('errorNotSelectFile')
    ]);
}
if (!nv_is_file(NV_BASE_SITEURL . $path . '/' . $img, $path)) {
    nv_jsonOutput([
        'status' => 'error',
        'mess' => $nv_Lang->getModule('file_no_exists')
    ]);
}

$newimg = NukeViet\Files\Image::createFilename($img, 'webp');
if (nv_is_file(NV_BASE_SITEURL . $path . '/' . $newimg, $path)) {
    nv_jsonOutput([
        'status' => 'info',
        'mess' => $nv_Lang->getModule('webpconvert_exists')
    ]);
}

$createImage = new NukeViet\Files\Image(NV_ROOTDIR . '/' . $path . '/' . $img, NV_MAX_WIDTH, NV_MAX_HEIGHT);
$createImage->webpConvert(NV_ROOTDIR . '/' . $path . '/' . $newimg);
$createImage->close();

if (isset($array_dirname[$path])) {
    $did = $array_dirname[$path];
    $info = nv_getFileInfo($path, $newimg);
    $info['userid'] = $admin_info['userid'];
    $db->query('INSERT INTO ' . NV_UPLOAD_GLOBALTABLE . "_file
    (name, ext, type, filesize, src, srcwidth, srcheight, sizes, userid, mtime, did, title) VALUES
    ('" . $info['name'] . "', '" . $info['ext'] . "', '" . $info['type'] . "', " . $info['filesize'] . ", '" . $info['src'] . "', " . $info['srcwidth'] . ', ' . $info['srcheight'] . ", '" . $info['size'] . "', " . $info['userid'] . ', ' . $info['mtime'] . ', ' . $did . ", '" . $newimg . "')");
}

nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('webpconvert'), $path . '/' . $newimg, $admin_info['userid']);

nv_jsonOutput([
    'status' => 'success',
    'file' => $newimg
]);

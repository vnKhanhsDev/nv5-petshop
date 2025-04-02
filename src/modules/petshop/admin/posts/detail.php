<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

global $db, $module_name, $module_file, $lang_module;

$id = $nv_Request->get_int('id', 'get', 0);
if ($id < 1) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=posts');
}

// Lấy thông tin bài viết từ database
$sql = 'SELECT id, title, description, image, content, views, likes, tags, status, updated_at, created_at FROM ' . NV_PREFIXLANG . '_petshop_posts WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$post = $stmt->fetch();
if (!$post) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=posts');
}

// Xử lý dữ liệu bài viết
$post['created_at'] = date('d/m/Y H:i', $post['created_at']);
$post['updated_at'] = ($post['updated_at'] == 0 || $post['updated_at'] == '') ? 'Chưa cập nhật' : date('d/m/Y H:i', $post['updated_at']);
$post['status_text'] = ($post['status'] == 1) ? 'Hiển thị' : 'Ẩn';

// Gửi dữ liệu sang template
$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/admin_default/modules/petshop/posts');

$xtpl->assign('POST', $post);
$xtpl->assign('BACK_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=posts');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

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

$title = $nv_Request->get_title('title', 'post', '');
$id = $nv_Request->get_int('id', 'post', 0);

$alias = change_alias($title);
$alias = $page_config['alias_lower'] ? strtolower($alias) : $alias;

$stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id !=' . $id . ' AND alias = :alias');
$stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->fetchColumn()) {
    $weight = $db->query('SELECT MAX(id) FROM ' . NV_PREFIXLANG . '_' . $module_data)->fetchColumn();
    $weight = (int) $weight + 1;
    $alias = $alias . '-' . $weight;
}

include NV_ROOTDIR . '/includes/header.php';
echo $alias;
include NV_ROOTDIR . '/includes/footer.php';

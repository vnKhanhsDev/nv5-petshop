<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_PAGE')) {
    exit('Stop!!!');
}

$channel = [];
$items = [];

$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = !empty($module_info['description']) ? $module_info['description'] : $global_config['site_description'];
$atomlink = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss'];

if ($module_info['rss']) {
    $sql = 'SELECT id, title, alias, image, imagealt, description, bodytext, add_time FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE status=1 ORDER BY weight ASC LIMIT 20';
    $result = $db_slave->query($sql);
    while ($row = $result->fetch()) {
        $rimages = (!empty($row['image'])) ? '<img src="' . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'] . '" width="100" align="left" border="0">' : '';
        $description = !empty($row['description']) ? $row['description'] : strip_tags($row['bodytext']);
        $description = $rimages . nv_clean60($description, 300, false);
        $items[] = [
            'title' => $row['title'],
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'],
            'guid' => $module_name . '_' . $row['id'],
            'description' => $description,
            'pubdate' => $row['add_time']
        ];
    }
}

if (theme_file_exists($module_info['template'] . '/css/rss.xsl')) {
    $channel['xsltheme'] = $module_info['template'];
}
nv_rss_generate($channel, $items, $atomlink);
exit();

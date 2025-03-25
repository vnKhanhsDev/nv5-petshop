<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

if (!function_exists('nv_news_array_cat_admin')) {
    /**
     * @param string $module_data
     * @return array
     */
    function nv_news_array_cat_admin($module_data)
    {
        global $db_slave;

        $array_cat_admin = [];
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);

        while ($row = $result->fetch()) {
            $array_cat_admin[$row['userid']][$row['catid']] = $row;
        }

        return $array_cat_admin;
    }
}

$is_refresh = false;
$array_cat_admin = nv_news_array_cat_admin($module_data);

if (!empty($module_info['admins'])) {
    $module_admin = explode(',', $module_info['admins']);
    foreach ($module_admin as $userid_i) {
        if (!isset($array_cat_admin[$userid_i])) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, catid, admin, add_content, pub_content, edit_content, del_content) VALUES (' . $userid_i . ', 0, 1, 1, 1, 1, 1)');
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_cat_admin = nv_news_array_cat_admin($module_data);
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if (defined('NV_IS_SPADMIN')) {
    $NV_IS_ADMIN_MODULE = true;
    $NV_IS_ADMIN_FULL_MODULE = true;
} else {
    if (isset($array_cat_admin[$admin_id][0])) {
        $NV_IS_ADMIN_MODULE = true;
        if ((int) ($array_cat_admin[$admin_id][0]['admin']) == 2) {
            $NV_IS_ADMIN_FULL_MODULE = true;
        }
    }
}

$allow_func = [
    'main',
    'drafts',
    'view',
    'stop',
    'publtime',
    'waiting',
    'declined',
    're-published',
    'content',
    'rpc',
    'del_content',
    'alias',
    'keywordsajax',
    'topicajax',
    'sourceajax',
    'tagsajax'
];

if (!isset($site_mods['cms'])) {
    $submenu['content'] = [
        'title' => $nv_Lang->getModule('content_add'),
        'submenu' => [
            'drafts' => $nv_Lang->getModule('draft_menu')
        ]
    ];
}

if ($NV_IS_ADMIN_MODULE) {
    $submenu['cat'] = $nv_Lang->getModule('categories');
    $submenu['tags'] = $nv_Lang->getModule('tags_manage');
    $submenu['groups'] = $nv_Lang->getModule('block');
    $submenu['topics'] = $nv_Lang->getModule('topics');
    $submenu['sources'] = $nv_Lang->getModule('sources');
    $submenu['authors'] = $nv_Lang->getModule('author_manage');
    $submenu['admins'] = $nv_Lang->getModule('admin');
    $submenu['report'] = $nv_Lang->getModule('report');
    $submenu['setting'] = [
        'title' => $nv_Lang->getModule('setting'),
        'submenu' => [
            'voices' => $nv_Lang->getModule('voice_manager')
        ]
    ];

    $allow_func[] = 'cat';
    $allow_func[] = 'change_cat';
    $allow_func[] = 'list_cat';
    $allow_func[] = 'del_cat';

    $allow_func[] = 'admins';
    $allow_func[] = 'topicsnews';
    $allow_func[] = 'topics';
    $allow_func[] = 'topicdelnews';
    $allow_func[] = 'addtotopics';
    $allow_func[] = 'change_topic';
    $allow_func[] = 'list_topic';
    $allow_func[] = 'del_topic';

    $allow_func[] = 'sources';
    $allow_func[] = 'change_source';
    $allow_func[] = 'list_source';
    $allow_func[] = 'del_source';

    $allow_func[] = 'block';
    $allow_func[] = 'groups';
    $allow_func[] = 'del_block_cat';
    $allow_func[] = 'list_block_cat';
    $allow_func[] = 'chang_block_cat';
    $allow_func[] = 'change_block';
    $allow_func[] = 'list_block';

    $allow_func[] = 'authors';

    $allow_func[] = 'tags';
    $allow_func[] = 'setting';
    $allow_func[] = 'voices';
    $allow_func[] = 'move';
    $allow_func[] = 'report';
}

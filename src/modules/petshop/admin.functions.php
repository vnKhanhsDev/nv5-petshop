<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$allow_func = [
    'main',
    'pets',
    'pets/add',
    'pets/detail',
    'pets/edit',
    'pets/delete',
    'accessories',
    'accessories/add',
    'accessories/detail',
    'accessories/edit',
    'accessories/delete',
    'services',
    'services/add',
    'services/detail',
    'services/edit',
    'services/delete',
    'orders',
    'orders/detail',
    'orders/delete',
    'orders/edit',
    'customers',
    'customers/detail',     
    'customers/delete',
    'posts',
    'posts/add',
    'posts/detail',
    'posts/edit',
    'posts/delete'
];

define('NV_IS_FILE_ADMIN', true);
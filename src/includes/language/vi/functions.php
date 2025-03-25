<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

/**
 * plural()
 *
 * @param mixed  $number
 * @param string $word
 * @return string
 */
function plural($number, $word)
{
    $wordObj = array_map('trim', explode(',', $word));

    return $number . ' ' . $wordObj[0];
}

/**
 * searchPatternByLang()
 *
 * @param string $str
 * @return string
 */
function searchPatternByLang($str)
{
    $unicode = [
        'a' => '(a|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ)',
        'd' => '(d|đ|Đ)', // Trong mot so truong hop MySQL khong coi Đ la chu in hoa cua đ
        'e' => '(e|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ)',
        'i' => '(i|í|ì|ỉ|ĩ|ị)',
        'o' => '(o|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)',
        'u' => '(u|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự)',
        'y' => '(y|ý|ỳ|ỷ|ỹ|ỵ)'
    ];
    $str = strtolower($str);

    return strtr($str, $unicode);
}

if (!empty($global_config['unsign_vietwords'])) {
    /**
     * searchKeywordforSQL()
     *
     * @param string $keyword
     * @return string
     */
    function searchKeywordforSQL($keyword)
    {
        global $db;

        $keyword = $db->regexpescape($keyword);

        return searchPatternByLang(nv_EncString($keyword));
    }
}

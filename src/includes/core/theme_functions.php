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
 * Hàm lấy thông báo lỗi
 *
 * @return string|void
 */
function nv_error_info()
{
    global $nv_Lang, $global_config, $error_info, $admin_info;

    if (!defined('NV_IS_ADMIN') or empty($error_info)) {
        return '';
    }

    if (defined('NV_ADMIN')) {
        $php_dir = get_tpl_dir([$admin_info['admin_theme'], $global_config['admin_theme']], NV_DEFAULT_SITE_THEME, '/theme_error_info.php');
    } else {
        $php_dir = get_tpl_dir($global_config['site_theme'], NV_DEFAULT_SITE_THEME, '/theme_error_info.php');
    }
    return require NV_ROOTDIR . '/themes/' . $php_dir . '/theme_error_info.php';
}

/**
 * nv_info_die()
 *
 * @param string $page_title
 * @param string $info_title
 * @param string $info_content
 * @param int    $error_code
 * @param string $admin_link
 * @param string $admin_title
 * @param string $site_link
 * @param string $site_title
 * @param array  $http_headers
 */
function nv_info_die($page_title, $info_title, $info_content, $error_code = 200, $admin_link = NV_BASE_ADMINURL, $admin_title = '', $site_link = NV_BASE_SITEURL, $site_title = '', $http_headers = [])
{
    global $nv_Lang, $global_config;

    // https://www.php.net/manual/en/function.http-response-code.php#114996
    $php_work_response_codes = [200, 201, 202, 203, 204, 205, 206, 207, 208, 226, 300, 301, 302, 303, 304, 305, 307, 308, 400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417, 422, 423, 424, 426, 428, 429, 431, 500, 501, 502, 503, 504, 505, 506, 507, 508, 510, 511];
    if (in_array((int) $error_code, $php_work_response_codes, true)) {
        http_response_code($error_code);
    } else {
        $phpsapi = substr(php_sapi_name(), 0, 3);
        if ($phpsapi == 'cgi' || $phpsapi == 'fpm') {
            header('Status: ' . $error_code . ' ' . $info_content);
        } else {
            $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
            header($protocol . ' ' . $error_code . ' ' . $info_content);
        }
    }

    if (!empty($http_headers)) {
        foreach ($http_headers as $header) {
            if (is_string($header) and !empty($header)) {
                header($header);
            } elseif (is_array($header)) {
                $response_code = 0;
                $replace = true;
                if (is_string($header[0]) and !empty($header[0])) {
                    if (isset($header[1])) {
                        $replace = (bool) ($header[1]);
                    }
                    if (isset($header[2])) {
                        $response_code = (int) ($header[2]);
                    }
                    header($header[0], $replace, $response_code);
                }
            }
        }
    }

    if (empty($page_title) and !empty($global_config['site_description'])) {
        $page_title = $global_config['site_description'];
    }

    // Get theme
    $dir_basenames = [];
    if (defined('NV_ADMIN')) {
        !empty($global_config['admin_theme']) && $dir_basenames[] = $global_config['admin_theme'];
        $dir_basenames[] = 'admin_default';
    }
    !empty($global_config['module_theme']) && $dir_basenames[] = $global_config['module_theme'];
    !empty($global_config['site_theme']) && $dir_basenames[] = $global_config['site_theme'];

    empty($global_config['site_url']) && $global_config['site_url'] = NV_SERVER_PROTOCOL . '://' . $global_config['my_domains'][0] . NV_SERVER_PORT;
    empty($global_config['site_logo']) && $global_config['site_logo'] = NV_ASSETS_DIR . '/images/logo.png';

    $php_dir = get_tpl_dir($dir_basenames, NV_DEFAULT_SITE_THEME, '/theme_info_die.php');

    include NV_ROOTDIR . '/includes/header.php';
    echo require NV_ROOTDIR . '/themes/' . $php_dir . '/theme_info_die.php';
    include NV_ROOTDIR . '/includes/footer.php';
}

/**
 * nv_error404()
 */
function nv_error404()
{
    global $nv_Lang;

    nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'), 404);
}

/**
 * nv_htmlOutput()
 *
 * @param string $html
 * @param string $type
 * @param array $custom_headers
 */
function nv_htmlOutput($html, $type = 'html', $custom_headers = [])
{
    global $global_config, $headers, $nv_BotManager;

    // Xuất cấu hình robot vào header
    if (is_object($nv_BotManager)) {
        $sys_info = [];
        $nv_BotManager->outputToHeaders($headers, $sys_info);
    }

    $html_headers = $global_config['others_headers'];
    if (defined('NV_ADMIN') or !defined('NV_ANTI_IFRAME') or NV_ANTI_IFRAME != 0) {
        $html_headers['X-Frame-Options'] = 'SAMEORIGIN';
    }
    if (!empty($global_config['nv_csp_act']) and !empty($global_config['nv_csp'])) {
        $html_headers['Content-Security-Policy'] = nv_unhtmlspecialchars($global_config['nv_csp']);
    }
    if (!empty($global_config['nv_rp_act']) and !empty($global_config['nv_rp'])) {
        $html_headers['Referrer-Policy'] = $global_config['nv_rp'];
    }
    if (!empty($global_config['nv_pp_act']) and !empty($global_config['nv_pp'])) {
        $html_headers['Permissions-Policy'] = $global_config['nv_pp'];
    }
    if (!empty($global_config['nv_fp_act']) and !empty($global_config['nv_fp'])) {
        $html_headers['Feature-Policy'] = $global_config['nv_fp'];
    }
    $content_types = [
        'svg' => 'image/svg+xml',
        'json' => 'application/json',
        'xml' => 'text/xml; charset=utf-8'
    ];
    if (isset($content_types[$type])) {
        $html_headers['Content-Type'] = $content_types[$type];
    } else {
        $html_headers['Content-Type'] = 'text/html; charset=' . $global_config['site_charset'];
    }
    $html_headers['Last-Modified'] = gmdate('D, d M Y H:i:s', strtotime('-1 day')) . ' GMT';
    $html_headers['Cache-Control'] = 'max-age=0, no-cache, no-store, must-revalidate'; // HTTP 1.1.
    $html_headers['Pragma'] = 'no-cache'; // HTTP 1.0.
    $html_headers['Expires'] = '-1'; // Proxies.
    $html_headers['X-Content-Type-Options'] = 'nosniff';
    $html_headers['X-XSS-Protection'] = '1; mode=block';

    if (str_contains(NV_USER_AGENT, 'MSIE')) {
        $html_headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
    }

    if (!empty($headers)) {
        // $headers sẽ ghi đè $html_headers
        $html_headers = array_merge($html_headers, $headers);
    }
    if (!empty($custom_headers)) {
        $html_headers = array_merge($html_headers, $custom_headers);
    }

    if (!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] != 'on') {
        unset($html_headers['Strict-Transport-Security']);
    }

    foreach ($html_headers as $key => $value) {
        $_key = strtolower($key);
        if (!is_array($value)) {
            $value = [
                $value
            ];
        }

        foreach ($value as $val) {
            $replace = ($_key != 'link') ? true : false;
            header($key . ': ' . $val, $replace);
        }
    }

    if (!isset($html_headers['Content-Encoding'])) {
        ob_start('ob_gzhandler');
    }
    echo $html;
    exit(0);
}

/**
 * nv_jsonOutput()
 *
 * @param array $array_data
 * @param int   $flags
 * @return never
 */
function nv_jsonOutput($array_data, $flags = 0)
{
    nv_htmlOutput(json_encode($array_data, $flags), 'json');
}

/**
 * nv_xmlOutput()
 *
 * @param string $content
 * @param int    $lastModified
 */
function nv_xmlOutput($content, $lastModified)
{
    if (nv_class_exists('tidy', false)) {
        $tidy_options = [
            'input-xml' => true,
            'output-xml' => true,
            'indent' => true,
            'indent-cdata' => true,
            'wrap' => 2000
        ];
        $tidy = new tidy();
        $tidy->parseString($content, $tidy_options, 'utf8');
        $tidy->cleanRepair();
        $content = (string) $tidy;
    } else {
        $content = trim($content);
    }

    $lastModified = gmdate('D, d M Y H:i:s', $lastModified) . ' GMT';
    $custom_headers = [
        'Last-Modified' => $lastModified,
        'Expires' => $lastModified
    ];

    $encoding = 'none';

    if (nv_function_exists('gzencode') and isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
        $encoding = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ? 'gzip' : (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') ? 'deflate' : 'none');

        if ($encoding != 'none') {
            if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') and preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
                $version = (float) ($matches[1]);

                if ($version < 6 or ($version == 6 and !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1'))) {
                    $encoding = 'none';
                }
            }
        }
    }

    if ($encoding != 'none') {
        $content = gzencode($content, 6, $encoding == 'gzip' ? FORCE_GZIP : FORCE_DEFLATE);
        $custom_headers['Content-Encoding'] = $encoding;
        $custom_headers['Content-Length'] = strlen($content);
        $custom_headers['Vary'] = 'Accept-Encoding';
    }

    nv_htmlOutput($content, 'xml', $custom_headers);
}

/**
 * nv_rss_generate()
 *
 * @param array  $channel
 * @param array  $items
 * @param string $atomlink
 * @param string $timemode
 * @param bool   $noindex
 * @return never
 * @throws DOMException
 */
function nv_rss_generate($channel, $items, $atomlink = '', $timemode = '', $noindex = true)
{
    global $global_config, $nv_Request;

    $type = $nv_Request->get_title('type', 'get', '');
    $type != 'atom' && $type = 'rss';
    $timemode != 'ISO8601' && $timemode = 'GMT';
    $noindex = (bool) $noindex;

    $xsl = NV_BASE_SITEURL . 'sload.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;xsl=' . $type;
    !empty($channel['xsltheme']) && $xsl .= '&amp;theme=' . $channel['xsltheme'];

    if (preg_match('/^' . nv_preg_quote(NV_MY_DOMAIN . NV_BASE_SITEURL) . '(.+)$/', $channel['link'], $matches)) {
        $channel['link'] = NV_BASE_SITEURL . $matches[1];
    }
    $channel['link'] = nv_url_rewrite($channel['link'], true);

    $channel['atomlink'] = '';
    if (!empty($atomlink)) {
        if (preg_match('/^' . nv_preg_quote(NV_MY_DOMAIN . NV_BASE_SITEURL) . '(.+)$/', $atomlink, $matches)) {
            $atomlink = NV_BASE_SITEURL . $matches[1];
        }
        if ($type == 'atom') {
            $atomlink .= '&amp;type=atom';
        }
        $channel['atomlink'] = nv_url_rewrite($atomlink, true);
    }

    $channel['docs'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=rss', true);

    if (empty($channel['description'])) {
        $channel['description'] = $global_config['site_description'];
    }

    $channel['generator'] = 'NukeViet v4.x';
    $channel['copyright'] = $global_config['site_name'];
    $channel['lang'] = $global_config['site_lang'];
    $channel['charset'] = $global_config['site_charset'];
    $channel['domain'] = NV_MY_DOMAIN;
    $channel['rootdir'] = NV_ROOTDIR;

    $feed_configs = file_exists(NV_ROOTDIR . '/' . NV_DATADIR . '/feeds_' . NV_LANG_DATA . '.json') ? json_decode(file_get_contents(NV_ROOTDIR . '/' . NV_DATADIR . '/feeds_' . NV_LANG_DATA . '.json'), true) : [];
    if ($type == 'rss') {
        $channel['image'] = NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/images/logo_rss.png';
        if (!empty($feed_configs['rss_logo']) and file_exists(NV_ROOTDIR . '/' . $feed_configs['rss_logo'])) {
            $channel['image'] = NV_ROOTDIR . '/' . $feed_configs['rss_logo'];
        }
    } else {
        $channel['image'] = NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/images/logo_atom.png';
        if (!empty($feed_configs['atom_logo']) and file_exists(NV_ROOTDIR . '/' . $feed_configs['atom_logo'])) {
            $channel['image'] = NV_ROOTDIR . '/' . $feed_configs['atom_logo'];
        }
    }

    $channel['icon'] = NV_BASE_SITEURL . 'favicon.ico';
    if (!empty($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
        $channel['icon'] = NV_BASE_SITEURL . $global_config['site_favicon'];
    }

    $channel['pubDate'] = 0;
    $channel['modified'] = 0;

    $pubdates = [];
    if (!empty($items)) {
        $keys = array_keys($items);
        foreach ($keys as $key) {
            if (empty($items[$key]['title']) and empty($items[$key]['pubdate'])) {
                unset($items[$key]);
                continue;
            }
            // Fix lỗi vòng while bị lặp vô hạn nếu truyền giá trị $item[pubdate] = null #3496
            if (!empty($items[$key]['pubdate']) and is_numeric($items[$key]['pubdate'])) {
                while (isset($pubdates[$items[$key]['pubdate']])) {
                    --$items[$key]['pubdate'];
                }
                $pubdates[$items[$key]['pubdate']] = 0;
            } else {
                $items[$key]['pubdate'] = 0;
            }

            $channel['pubDate'] = max($channel['pubDate'], $items[$key]['pubdate']);

            if (!empty($items[$key]['modifydate'])) {
                $channel['modified'] = max($channel['modified'], $items[$key]['modifydate']);
            }
            unset($items[$key]['modifydate']);

            if (preg_match('/^' . nv_preg_quote(NV_MY_DOMAIN . NV_BASE_SITEURL) . '(.+)$/', $items[$key]['link'], $matches)) {
                $items[$key]['link'] = NV_BASE_SITEURL . $matches[1];
            }
            $items[$key]['link'] = nv_url_rewrite($items[$key]['link'], true);

            if (!empty($items[$key]['content'])) {
                if (!empty($items[$key]['content']['pubdate'])) {
                    $items[$key]['content']['published_display'] = nv_date('H:i: d/m/Y', $items[$key]['content']['pubdate']);
                }
                if (!empty($items[$key]['content']['modifydate'])) {
                    $items[$key]['content']['modified_display'] = nv_date('H:i: d/m/Y', $items[$key]['content']['modifydate']);
                }
            }
        }
    }

    $channel['updated'] = !empty($channel['pubDate']) ? $channel['pubDate'] : NV_CURRENTTIME;
    $channel['updated'] = max($channel['updated'], $channel['modified']);

    [$channel, $items, $xsl, $type, $timemode] = nv_apply_hook('', 'before_rss_output_xml', [$channel, $items, $xsl, $type, $timemode], [$channel, $items, $xsl, $type, $timemode]);

    if ($type == 'rss') {
        $output = NukeViet\Xml\Feed::rss_create($channel, $items, $xsl, $timemode);
    } else {
        $output = NukeViet\Xml\Feed::atom_create($channel, $items, $xsl);
    }

    if ($noindex) {
        global $nv_BotManager;
        $nv_BotManager->setNoIndex()
            ->setFollow()
            ->printToHeaders();
    }

    nv_xmlOutput($output, $channel['updated']);
}

/**
 * nv_xmlSitemap_generate()
 *
 * @param array  $url
 * @param string $changefreq
 * @param string $priority
 */
function nv_xmlSitemap_generate($url, $changefreq = 'daily', $priority = '0.8')
{
    //Chrome chỉ cho phép các file xml kết nối với file xsl có nguồn same-origin
    $xsl = NV_BASE_SITEURL . NV_ASSETS_DIR . '/css/sitemap.xsl';
    if (!str_starts_with($xsl, NV_MY_DOMAIN)) {
        $xsl = NV_MY_DOMAIN . $xsl;
    }

    $lastModified = time() - 86400;
    $sitemapHeader = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . $xsl . '"?><urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
    $xml = new SimpleXMLElement($sitemapHeader);
    if (!empty($url)) {
        foreach ($url as $key => $values) {
            $values['link'] = nv_url_rewrite($values['link'], true);
            if (!str_starts_with($values['link'], NV_MY_DOMAIN)) {
                $values['link'] = NV_MY_DOMAIN . $values['link'];
            }
            $row = $xml->addChild('url');
            $row->addChild('loc', $values['link']);
            $row->addChild('lastmod', date('c', $values['publtime']));
            $row->addChild('changefreq', !empty($values['changefreq']) ? $values['changefreq'] : $changefreq);
            $row->addChild('priority', !empty($values['priority']) ? $values['priority'] : $priority);

            if ($key == 0) {
                $lastModified = $values['publtime'];
            }
        }
    }

    $contents = $xml->asXML();
    $contents = nv_url_rewrite($contents);

    nv_xmlOutput($contents, $lastModified);
}

/**
 * nv_xmlSitemapCat_generate()
 *
 * @param array $url
 */
function nv_xmlSitemapCat_generate($url)
{
    global $global_config;

    //Chrome chỉ cho phép các file xml kết nối với file xsl có nguồn same-origin
    $xsl = NV_BASE_SITEURL . NV_ASSETS_DIR . '/css/sitemapindex.xsl';
    if (!str_starts_with($xsl, NV_MY_DOMAIN)) {
        $xsl = NV_MY_DOMAIN . $xsl;
    }

    $sitemapHeader = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . $xsl . '"?><sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>';
    $xml = new SimpleXMLElement($sitemapHeader);
    $lastModified = NV_CURRENTTIME - 86400;

    foreach ($url as $link) {
        if (!str_starts_with($link, NV_MY_DOMAIN)) {
            $link = NV_MY_DOMAIN . $link;
        }
        $row = $xml->addChild('sitemap');
        $row->addChild('loc', $link);
    }

    $contents = $xml->asXML();

    if ($global_config['rewrite_enable']) {
        if ($global_config['check_rewrite_file']) {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'sitemap-\\1.\\2.\\3.xml', $contents);
        } elseif ($global_config['rewrite_optional']) {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'index.php/\\2/sitemap/\\3' . $global_config['rewrite_endurl'], $contents);
        } else {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'index.php/\\1/\\2/sitemap/\\3' . $global_config['rewrite_endurl'], $contents);
        }
    }

    nv_xmlOutput($contents, $lastModified);
}

/**
 * nv_xmlSitemapIndex_generate()
 */
function nv_xmlSitemapIndex_generate()
{
    global $db_config, $db, $global_config;

    //Chrome chỉ cho phép các file xml kết nối với file xsl có nguồn same-origin
    $xsl = NV_BASE_SITEURL . NV_ASSETS_DIR . '/css/sitemapindex.xsl';
    if (!str_starts_with($xsl, NV_MY_DOMAIN)) {
        $xsl = NV_MY_DOMAIN . $xsl;
    }

    $sitemapHeader = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . $xsl . '"?><sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>';
    $xml = new SimpleXMLElement($sitemapHeader);

    $lastModified = NV_CURRENTTIME - 86400;

    if ($global_config['lang_multi']) {
        foreach ($global_config['allow_sitelangs'] as $lang) {
            $sql = 'SELECT m.title, m.module_file FROM ' . $db_config['prefix'] . '_' . $lang . '_modules m LEFT JOIN ' . $db_config['prefix'] . '_' . $lang . "_modfuncs f ON m.title=f.in_module WHERE m.act = 1 AND m.groups_view='6' AND m.sitemap=1 AND f.func_name = 'sitemap' ORDER BY m.weight, f.subweight";
            $result = $db->query($sql);
            while ([$modname, $modfile] = $result->fetch(3)) {
                $sitemaps = nv_scandir(NV_ROOTDIR . '/modules/' . $modfile . '/funcs', '/^sitemap(.*?)\.php$/');
                [$modname, $sitemaps] = nv_apply_hook('', 'generating_sitemap_module', [$modname, $sitemaps], [$modname, $sitemaps]);
                if (!empty($sitemaps)) {
                    foreach ($sitemaps as $filename) {
                        if (preg_match('/^sitemap(\.*)([a-zA-Z0-9\-]*)\.php$/', $filename, $m)) {
                            if ($m[0] == 'sitemap.php') {
                                $link = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . $lang . '&amp;' . NV_NAME_VARIABLE . '=' . $modname . '&amp;' . NV_OP_VARIABLE . '=sitemap';
                            } elseif ($m[1] == '.' and $m[2] != '') {
                                $link = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . $lang . '&amp;' . NV_NAME_VARIABLE . '=' . $modname . '&amp;' . NV_OP_VARIABLE . '=sitemap/' . $m[2];
                            }
                            $row = $xml->addChild('sitemap');
                            $row->addChild('loc', $link);
                        }
                    }
                }
            }
        }
    } else {
        $site_mods = nv_site_mods();

        foreach ($site_mods as $modname => $values) {
            if (isset($values['funcs']) and isset($values['funcs']['sitemap']) and !empty($values['sitemap'])) {
                $sitemaps = nv_scandir(NV_ROOTDIR . '/modules/' . $values['module_file'] . '/funcs', '/^sitemap(.*?)\.php$/');
                [$modname, $sitemaps] = nv_apply_hook('', 'generating_sitemap_module', [$modname, $sitemaps], [$modname, $sitemaps]);
                if (!empty($sitemaps)) {
                    foreach ($sitemaps as $filename) {
                        if (preg_match('/^sitemap(\.*)([a-zA-Z0-9\-]*)\.php$/', $filename, $m)) {
                            if ($m[0] == 'sitemap.php') {
                                $link = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $modname . '&amp;' . NV_OP_VARIABLE . '=sitemap';
                            } elseif ($m[1] == '.' and $m[2] != '') {
                                $link = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $modname . '&amp;' . NV_OP_VARIABLE . '=sitemap/' . $m[2];
                            }
                            $row = $xml->addChild('sitemap');
                            $row->addChild('loc', $link);
                        }
                    }
                }
            }
        }
    }
    $db = null;

    $contents = $xml->asXML();

    if ($global_config['rewrite_enable']) {
        if ($global_config['check_rewrite_file']) {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=SitemapIndex/", 'sitemap-\\1.xml', $contents);
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'sitemap-\\1.\\2.\\3.xml', $contents);
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap/", 'sitemap-\\1.\\2.xml', $contents);
        } elseif ($global_config['rewrite_optional']) {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'index.php/\\2/sitemap/\\3' . $global_config['rewrite_endurl'], $contents);
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap/", 'index.php/\\2/sitemap' . $global_config['rewrite_endurl'], $contents);
        } else {
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap\/([a-zA-Z0-9\-]+)/", 'index.php/\\1/\\2/sitemap/\\3' . $global_config['rewrite_endurl'], $contents);
            $contents = preg_replace("/index\.php\?" . NV_LANG_VARIABLE . "\=([a-z]{2})\&[amp\;]*" . NV_NAME_VARIABLE . "\=([a-zA-Z0-9\-]+)\&[amp\;]*" . NV_OP_VARIABLE . "\=sitemap/", 'index.php/\\1/\\2/sitemap' . $global_config['rewrite_endurl'], $contents);
        }
    }

    nv_xmlOutput($contents, $lastModified);
}

/**
 * nv_css_setproperties()
 *
 * @param string $tag
 * @param mixed  $property_array
 * @return mixed
 */
function nv_css_setproperties($tag, $property_array)
{
    if (empty($tag)) {
        return '';
    }
    if (!is_array($property_array)) {
        return $property_array;
    }

    $css = '';
    foreach ($property_array as $property => $value) {
        if ($property != 'customcss') {
            if (!empty($property) and !empty($value)) {
                $property = str_replace('_', '-', $property);
                if ($property == 'background-image') {
                    $value = "url('" . $value . "')";
                }
                $css .= $property . ':' . $value . ';';
            }
        } elseif (!empty($value)) {
            $value = substr(trim($value), -1) == ';' ? $value : $value . ';';
            $css .= $value;
        }
    }
    !empty($css) and $css = $tag . '{' . $css . '}';

    return $css;
}

/**
 * nv_theme_alert()
 *
 * @param string $message_title
 * @param string $message_content
 * @param string $type
 * @param string $url_back
 * @param string $lang_back
 * @param int    $time_back
 * @return string
 */
function nv_theme_alert($message_title, $message_content, $type = 'info', $url_back = '', $lang_back = '', $time_back = 5)
{
    global $global_config, $module_info, $page_title;

    $dir_basenames = [];
    if (defined('NV_ADMIN')) {
        !empty($global_config['admin_theme']) && $dir_basenames[] = $global_config['admin_theme'];
        $dir_basenames[] = 'admin_default';
    }
    !empty($global_config['module_theme']) && $dir_basenames[] = $global_config['module_theme'];
    !empty($global_config['site_theme']) && $dir_basenames[] = $global_config['site_theme'];

    $php_dir = get_tpl_dir($dir_basenames, NV_DEFAULT_SITE_THEME, '/theme_alert.php');
    return require NV_ROOTDIR . '/themes/' . $php_dir . '/theme_alert.php';
}

/**
 * nv_disable_site()
 */
function nv_disable_site()
{
    global $global_config, $nv_Lang;

    $disable_site_content = $nv_Lang->getGlobal('disable_site_content');
    $disable_site_headers = [];
    $disable_site_code = 200;

    if (file_exists(NV_ROOTDIR . '/' . NV_DATADIR . '/disable_site_content.' . NV_LANG_DATA . '.txt')) {
        $disable_site_content = file_get_contents(NV_ROOTDIR . '/' . NV_DATADIR . '/disable_site_content.' . NV_LANG_DATA . '.txt');
    }

    $reopening_time = $global_config['closed_site'] > 0 ? $global_config['site_reopening_time'] : ((!empty($global_config['closed_subsite']) and $global_config['idsite'] > 0) ? $global_config['subsite_reopening_time'] : 0);
    if (!empty($reopening_time) and $reopening_time > NV_CURRENTTIME) {
        $disable_site_content .= '<br/><br/>' . $nv_Lang->getGlobal('closed_site_reopening_time') . ': ' . nv_datetime_format($reopening_time);
        $disable_site_headers = [
            'Retry-After: ' . gmdate('D, d M Y H:i:s', $reopening_time) . ' GMT'
        ];
        $disable_site_code = 503;
    }

    nv_info_die($nv_Lang->getGlobal('disable_site_title'), $nv_Lang->getGlobal('disable_site_title'), $disable_site_content, $disable_site_code, '', '', '', '', $disable_site_headers);
}

<?php

/**
 * 广告管理
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_advert
{

    /**
     * 广告缓存
     *
     * @return void
     */
    public static function update_cache_main_advert()
    {
        $result = app_db::select('ylmf_advert', '*', 'state = 1 ORDER BY vieworder');
        if (empty($result))
        {
            return false;
        }
        $advert_list = array();
        foreach ($result as $row)
        {
            $conf = unserialize($row['config']);
            if (strtotime($conf['starttime']) > $_SERVER['REQUEST_TIME'] || (strtotime($conf['endtime']) != 0 && strtotime($conf['endtime']) < $_SERVER['REQUEST_TIME']))
            {
                continue;
            }
            $code = '';

            if (!empty($conf['style']) && $conf['style'] == 'code')
            {
                $code = $conf['htmlcode'];
            }
            elseif (!empty($conf['style']) && $conf['style'] == 'txt')
            {
                $style = '';
                if ($conf['color'])
                {
                    $style .= "color:{$conf['color']};";
                }
                if ($conf['size'])
                {
                    $style .= "font-size:{$conf['size']};";
                }
                (!empty($style)) && $style = " style=\"{$style}\"";

                if (preg_match('/^6685/i', $row['varname']))
                {
                    $code = "<a href=\"{$conf['link']}\" target=\"_blank\"{$style}>{$conf['title']}</a>";
                }
                else
                {
                    if (!empty($conf['title']))
                    {
                        $code = "<a href=\"{$conf['link']}\" target=\"_blank\"{$style} onclick=\"'{$row['id']}';\" >{$conf['title']}</a>";
                    }
                }
            }
            elseif (!empty($conf['style']) && $conf['style'] == 'img')
            {
                $style = '';
                if ($conf['width'])
                {
                    $style .= " width=\"{$conf['width']}\"";
                }
                if ($conf['height'])
                {
                    $style .= " height=\"{$conf['height']}\"";
                }
                if ($conf['descrip'])
                {
                    $style .= " alt=\"{$conf['descrip']}\"";
                }

                if (preg_match('/^6685/i', $row['varname']))
                {
                    $code = "<a href=\"{$conf['link']}\" target=\"_blank\" ><img src=\"{$conf['url']}\"  border=\"0\" {$style}></a>";
                }
                else
                {
                    $code = "<a href=\"{$conf['link']}\" target=\"_blank\" onclick=\"'{$row['id']}';\"><img src=\"{$conf['url']}\"  border=\"0\" {$style}></a>";
                }
            }
            elseif (!empty($conf['style']) && $conf['style'] == 'flash')
            {
                $style = '';
                if ($conf['width'])
                {
                    $style .= " width=\"{$conf['width']}\"";
                }
                if ($conf['height'])
                {
                    $style .= " height=\"{$conf['height']}\"";
                }
                $code = "<embed {$style} src=\"{$conf['link']}\" type=\"application/x-shockwave-flash\"></embed>";
            }

            $ad = array();
            !empty($conf['starttime']) && $ad['starttime'] = $conf['starttime'];
            !empty($conf['endtime']) && $ad['endtime'] = $conf['endtime'];
            $ad['descrip'] = (empty($conf['descrip'])) ? '' : $conf['descrip'];
            $ad['link'] = (empty($conf['link'])) ? '' : $conf['link'];
            $ad['color'] = (empty($conf['color'])) ? '' : $conf['color'];
            $ad['title'] = (empty($conf['title'])) ? '' : $conf['title'];
            $ad['code'] = $code;
            $advert_list[$row['varname']][] = $ad;
        }
        if (!empty($advert_list))
        {
            mod_cache::set_cache('cache_main_advert', $advert_list);

            self::update_cache_advert_js();
        }
    }

    /**
     * 广告缓存
     *
     * @return array
     */
    public static function get_cache_main_advert()
    {
        if (false == $output = mod_cache::get_cache('cache_main_advert'))
        {
            self::update_cache_main_advert();
            $output = mod_cache::get_cache('cache_main_advert');
        }
        return $output;
    }

    /**
     * 将广告生成为 JS notice footer header
     *
     * @return viod
     */
    public static function update_cache_advert_js()
    {
        $cache_main_advert = self::get_cache_main_advert();
        if (!empty($cache_main_advert))
        {
            foreach ($cache_main_advert as $key => $val)
            {
                if ($key != 'index_txt' && $key != 'page_baidu')
                {
                    /* 广告轮翻
                    $tmp = "var m=" . count($val) . ";\r\nvar n=Math.floor(Math.random()*m+1);\r\nswitch(n)\r\n{\r\n";
                    $i = 0;
                    foreach ($val as $value)
                    {
                        $i++;
                        $tmp .= "case $i:\r\n";
                        foreach (explode("\r\n", $value['code']) as $value2)
                        {
                            $value2 = str_replace(array('"', '/'), array('\"', '\/'), $value2);
                            $tmp .= 'document.writeln("' . $value2 . '");' . "\r\n";
                        }
                        $tmp .= "break;\r\n";
                    }
                    $tmp .= "}\r\n";
                     */
                    // 广告合并成
                    $tmp = "var m=1;\r\nvar n=Math.floor(Math.random()*m+1);\r\nswitch(n)\r\n{\r\n";
                    $tmp .= "case 1:\r\n";
                    foreach ($val as $value)
                    {
                        $value['code'] = trim($value['code']);
                        foreach (explode("\r\n", $value['code']) as $value2)
                        {
                            $value2 = str_replace(array('"', '/'), array('\"', '\/'), $value2);
                            $tmp .= 'document.writeln("' . $value2 . '");' . "\r\n";
                        }
                    }
                    $tmp .= "break;\r\n";
                    $tmp .= "}\r\n";
                    mod_file::write(PATH_ROOT . '/static/js/' . $key . '.js', $tmp);
                }

                if ($key == 'page_baidu')
                {
                    $page_baiduad = '';
                    foreach ($cache_main_advert['page_baidu'] as $val)
                    {
                        $page_baiduad .= $val['code'] . '&nbsp;&nbsp;&nbsp;';
                    }
                    $tmp = '';
                    foreach (explode("\r\n", $page_baiduad) as $value)
                    {
                        $value = strtr($value2, array('"' => '\"'));
                        $tmp .= 'document.writeln("' . $value . '");' . "\r\n";
                    }
                    mod_file::write(PATH_ROOT . '/static/js/' . $key . '.js', $tmp);
                }
            }
        }
        //写header_2.js
        if (!empty($cache_main_advert['header_2']))
        {
            $header_2 = $cache_main_advert['header_2'];
            $txt = '';
            foreach ($header_2 as $val)
            {
                $txt .= $val['code'] . ' ';
            }

            $jstxt = '';
            $tmp = explode("\r\n", $txt);
            foreach ($tmp as $value)
            {
                $value = str_replace(array('"', '/'), array('\"', '\/'), $value);
                $jstxt .= 'document.writeln("' . $value . '");' . "\r\n";
            }
            mod_file::write(PATH_ROOT . '/static/js/header_2.js', $jstxt);
        }
    }

}

?>

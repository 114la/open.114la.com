<?php

/**
 * �������ӹ���
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_links
{
    /**
     * ������������б�
     * @return <array>
     */
    public static function get_links_list( $is_show = FALSE )
    {
        $and_sql = "";
        ($is_show) && $and_sql = " WHERE `is_show`=1";
        app_db::query("SELECT * FROM `ylmf_links` $and_sql ORDER BY `sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * ���һ������������Ϣ
     * @return <array>
     */
    public static function get_links_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_links` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * �������� ɾ��,���������ʽ
     * @return <array>
     */
    public static function links_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("��ѡ��ɾ������.");
        }
        if ($ids = checkselid($ids))
        {
            app_db::query("DELETE FROM `ylmf_links` WHERE `id` IN($ids)");
            self::update_cache_links_js(); //���»���
        }
        else
        {
            exit("�����Ƿ�.");
        }
    }

    /**
     * �������� ����
     * @return <array>
     */
    public static function links_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_links` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

    /**
     * �������� �Ƿ���ʾ��ҳ����
     * @return <array>
     */
    public static function links_is_show( $is_show )
    {
        //ȫ����Ϊ0
        app_db::query("UPDATE `ylmf_links` SET `is_show`='0'");
        //��ѡ�ϵ���Ϊ1
        if (!empty($is_show))
        {
            foreach($is_show as $id)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_links` SET `is_show`='1' WHERE `id`='{$id}'");
            }
        }
    }
    
    /**
     * �������� �����������
     * @param <array> $form  ��ӵ�POST����
     */
    public static function links_save_add($data)
    {
        if (empty($data['site_name']))
        {
            throw new Exception("������վ������");
        }
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        $data['site_name'] = Char_cv($data['site_name']);
        if (!preg_match("#^http://#", $data['site_url']))
        {
            throw new Exception("��վ��ַ����Ϊ�ջ�����http://��ͷ");
        }
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        $data['add_time'] = time();
        $data['remarks'] = char_cv(trim($data['remarks']));
        if (app_db::insert('ylmf_links', array_keys($data), array_values($data)))
        {
            self::update_cache_links_js(); //���»���
            return true;
        }
        return false;
    }

    /**
     * �������� �����޸�����
     * @param <array> $data
     */
    public static function links_save_edit($data)
    {
        if (!is_numeric($data['id']))
        {
            throw new Exception("�Ƿ�����");
        }
        $data['id'] = intval($data['id']);
        $info = app_db::query("SELECT * FROM `ylmf_links` WHERE id='{$data['id']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("û�����վ��");
        }
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        $data['site_name'] = trim($data['site_name']);
        if ($data['site_name'] == '')
        {
            throw new Exception("������վ������");
        }
        $data['site_name'] = Char_cv($data['site_name']);
        if (!preg_match("#^http://#", $data['site_url']))
        {
            throw new Exception("��վ��ַ����Ϊ�ջ�����http://��ͷ");
        }
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        $data['remarks'] = char_cv(trim($data['remarks']));
        if (app_db::update('ylmf_links', $data, "id='{$data['id']}'"))
        {
            self::update_cache_links_js(); //���»���
            return true;
        }
        return false;
    }

    /**
     * �����վ�Ƿ��Ѵ��� δʹ�ø÷���
     *
     * @param int $site ��վ���ƻ� URL
     */
    public static function check_exists($site)
    {
        $data = app_db::select('ylmf_links', 'id', "`site_name` = '{$site['site_name']}' OR `site_url` = '{$site['site_url']}'");
        return (empty($data)) ? false : true;
    }

    /**
     * ��������������Ϊ JS
     *
     * @return viod
     */
    public static function update_cache_links_js()
    {
        // ���ϲ���
        $tmp = "var m=1;\r\nvar n=Math.floor(Math.random()*m+1);\r\nswitch(n)\r\n{\r\n";
        $tmp .= "case 1:\r\n";
        $html = "<li class='bd'>";
        $html .= "<strong><a href='" .URL_HTML. "/catalog/links.htm'>��������</a> </strong>";
        $data = self::get_links_list(TRUE);
        if (!$data)
        {
            return false;
        }
        foreach ($data as $value)
        {
            $html .= "<a title='{$value['site_name']}' href='{$value['site_url']}'>{$value['site_name']}</a>";
        }
        $html .= "<span class='more'><a href='" .URL_HTML. "/catalog/links.htm'>���� ?</a></span></li>";
        $tmp .= 'document.writeln("' . $html . '");' . "\r\n";
        $tmp .= "break;\r\n";
        $tmp .= "}\r\n";
        mod_file::write(PATH_ROOT . '/static/js/links.js', $tmp);
        mod_make_html::make_html_links();
        return true;
    }

}
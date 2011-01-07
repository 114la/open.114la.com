<?php

/**
 * �������������
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search_class
{
    /**
     * ��������������б�
     * @return <array>
     */
    public static function get_search_class_list()
    {
        app_db::query("SELECT * FROM `ylmf_searchclass` ORDER BY `sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * ���һ��������������Ϣ
     * @return <array>
     */
    public static function get_search_class_info($classid)
    {
        app_db::query("SELECT * FROM `ylmf_searchclass` WHERE `classid`='{$classid}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * ���һ������������options
     * @return <array>
     */
    public static function get_search_class_options()
    {
        $sql = "SELECT `classid`,`classname` FROM `ylmf_searchclass` ORDER BY `sort` ASC";
        app_db::query($sql);
        $rows = app_db::fetch_all();
        $class = array();
        foreach ($rows as $row)
        {
            $class[$row['classid']] = $row['classname'];
        }
        return $class;
    }

    /**
     * ���������� ɾ��,���������ʽ
     * @return <array>
     */
    public static function search_class_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("��ѡ��ɾ������.");
        }
        if ($ids = checkselid($ids))
        {
            //���ɾ���ķ��������Ƿ�������
            app_db::query("SELECT * FROM `ylmf_search` WHERE `class` IN($ids)");
            $have_ylmf_search = app_db::fetch_one();
            app_db::query("SELECT * FROM `ylmf_search_keyword` WHERE `class` IN($ids)");
            $have_ylmf_search_keyword = app_db::fetch_one();
            if (!empty($have_ylmf_search) || !empty($have_ylmf_search_keyword))
            {
                exit("�˷�����������������ַ��ؼ��֣����ܱ�ɾ����");
            }

            //���ɾ���ķ�������һ������ΪĬ�ϵ�,��һ��û��ɾ������ΪĬ�ϣ�Ҫ��Ȼ��û��Ĭ�ϵ���
            app_db::query("SELECT * FROM `ylmf_searchclass` WHERE `classid` IN($ids) AND `is_default`=1");
            $have = app_db::fetch_one();
            if ($have)
            {
                app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=1 WHERE `classid` NOT IN($ids) LIMIT 1");
            }
            app_db::query("DELETE FROM `ylmf_searchclass` WHERE `classid` IN($ids)");
        }
        else
        {
            exit("�����Ƿ�.");
        }
    }

    /**
     * ���������� ����
     * @return <array>
     */
    public static function search_class_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_searchclass` SET `sort`='{$k}' WHERE `classid`='{$v}'");
            }
        }
    }

    /**
     * ���������� �Ƿ���ʾ��ҳ����
     * @return <array>
     */
    public static function search_class_set_default( $classid )
    {
        //��ѡ�ϵ���Ϊ1
        if (!empty($classid))
        {
            //ȫ����Ϊ0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`='0'");
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`='1' WHERE `classid`='{$classid}'");
        }
    }
    
    /**
     * ���������� �����������
     * @param <array> $form  ��ӵ�POST����
     */
    public static function search_class_save_add($data)
    {
        if (empty($data['classname']))
        {
            throw new Exception("�������������");
        }
        $data['is_default'] = empty($data['is_default']) ? 0 : $data['is_default'];
        if ($data['is_default'])
        {   //�����ǰ������ΪĬ�ϣ������Ͷ�����Ĭ�ϣ�ȫ����Ϊ0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=0");
        }
        $data['classname'] = Char_cv($data['classname']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::insert('ylmf_searchclass', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * ���������� �����޸�����
     * @param <array> $data
     */
    public static function search_class_save_edit($data)
    {
        if (!is_numeric($data['classid']))
        {
            throw new Exception("�Ƿ�����");
        }
        $data['classid'] = intval($data['classid']);
        $info = app_db::query("SELECT * FROM `ylmf_searchclass` WHERE classid='{$data['classid']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("û����������������");
        }
        $data['is_default'] = empty($data['is_default']) ? 0 : $data['is_default'];
        if ($data['is_default'])
        {   //�����ǰ������ΪĬ�ϣ������Ͷ�����Ĭ�ϣ�ȫ����Ϊ0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=0");
        }
        $data['classname'] = trim($data['classname']);
        if ($data['classname'] == '')
        {
            throw new Exception("���������������������");
        }
        $data['classname'] = Char_cv($data['classname']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::update('ylmf_searchclass', $data, "classid='{$data['classid']}'"))
        {
            return true;
        }
        return false;
    }

}

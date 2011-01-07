<?php

/**
 * �����������
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search
{
    /**
     * ������������б�
     * @return <array>
     */
    public static function get_search_list($classid = '')
    {
        $and_sql = "";
        ($classid) && $and_sql = "WHERE class = '{$classid}'";
        app_db::query("SELECT a.*,b.classname FROM `ylmf_search` as a LEFT JOIN `ylmf_searchclass` as b ON a.class=b.classid  {$and_sql} ORDER BY a.`sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * ���һ������������Ϣ
     * @return <array>
     */
    public static function get_search_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_search` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * �������� ɾ��,���������ʽ
     * @return <array>
     */
    public static function search_delete($ids, $classid)
    {
        if (!is_array($ids))
        {
            exit("��ѡ��ɾ������.");
        }
        if ($ids = checkselid($ids))
        {
            //���ɾ����������������һ������ΪĬ�ϵ�,��һ��û��ɾ������ΪĬ�ϣ�Ҫ��Ȼ��û��Ĭ�ϵ���
            app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `id` IN($ids) AND `is_default`=1");
            $have = app_db::fetch_one();
            if ($have)
            {
                app_db::query("UPDATE `ylmf_search` SET `is_default`=1 WHERE `class`='{$classid}' AND `id` NOT IN($ids) LIMIT 1");
            }
            app_db::query("DELETE FROM `ylmf_search` WHERE `class`='{$classid}' AND `id` IN($ids)");
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
    public static function search_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

     /**
     * �������� �Ƿ���ʾ��ҳ����
     * @return <array>
     */
    public static function search_is_show( $is_show, $classid )
    {
        //����Ŀ��ȫ����Ϊ0
        app_db::query("UPDATE `ylmf_search` SET `is_show`='0' WHERE `class`='{$classid}'");
        //����Ŀ�¹�ѡ�ϵ���Ϊ1
        if (!empty($is_show))
        {
            foreach($is_show as $id)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search` SET `is_show`='1' WHERE `class`='{$classid}' AND `id`='{$id}'");
            }
        }
    }

    /**
     * �������� �Ƿ���ΪĬ�ϲ���
     * @return <array>
     */
    public static function search_set_default( $id, $classid )
    {
        if (!empty($id))
        {
            //����Ŀ��ȫ����Ϊ0
            app_db::query("UPDATE `ylmf_search` SET `is_default`='0' WHERE `class`='{$classid}'");
            //��Ŀ�¹�ѡ�ϵ���Ϊ1
            app_db::query("UPDATE `ylmf_search` SET `is_default`='1' WHERE `class`='{$classid}' AND `id`='{$id}'");
        }
    }
    
    /**
     * �������� �����������
     * @param <array> $form  ��ӵ�POST����
     */
    public static function search_save_add($data)
    {
        $classid = $data['class'];
        if (empty($data['search_select']))
        {
            throw new Exception("����������");
        }
        if (empty($data['action']))
        {
            throw new Exception("������ӿڵ�ַ");
        }
        if (empty($data['name']))
        {
            throw new Exception("�����������ֶ���");
        }
        if (empty($data['img_url']))
        {
            throw new Exception("������LOGO����");
        }
        if (empty($data['btn']))
        {
            throw new Exception("�����밴ť����");
        }
        //�Ƿ���ʾ
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];

        //��� "����Ŀ" �²�����Ĭ�ϣ��赱ǰΪĬ��
        app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `is_default`=1");
        $have_default = app_db::fetch_all();
        if (!$have_default)
        {
            $data['is_default'] = 1; 
        }
        
        //����html��ǩ
        $data['search_select'] = Char_cv($data['search_select']);
        $data['action'] = Char_cv($data['action']);
        $data['name'] = Char_cv($data['name']);
        $data['url'] = Char_cv($data['url']);
        $data['img_url'] = Char_cv($data['img_url']);
        $data['img_text'] = Char_cv($data['img_text']);
        $data['btn'] = Char_cv($data['btn']);
        $data['params'] = addslashes($data['params']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::insert('ylmf_search', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * �������� �����޸�����
     * @param <array> $data
     */
    public static function search_save_edit($data)
    {
        $classid = $data['class'];
        if (!is_numeric($data['id']))
        {
            throw new Exception("�Ƿ�����");
        }
        $data['id'] = intval($data['id']);
        $info = app_db::query("SELECT * FROM `ylmf_search` WHERE id='{$data['id']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("û�������������");
        }
        //��֤������
        if (empty($data['search_select']))
        {
            throw new Exception("����������");
        }
        if (empty($data['action']))
        {
            throw new Exception("������ӿڵ�ַ");
        }
        if (empty($data['name']))
        {
            throw new Exception("�����������ֶ���");
        }
        if (empty($data['img_url']))
        {
            throw new Exception("������LOGO����");
        }
        if (empty($data['btn']))
        {
            throw new Exception("�����밴ť����");
        }
        //�Ƿ���ʾ
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        //��� "����Ŀ" �²�����Ĭ�ϣ��赱ǰΪĬ��
        app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `is_default`=1");
        $have_default = app_db::fetch_all();
        if (!$have_default)
        {
            $data['is_default'] = 1; 
        }

        //����html��ǩ
        $data['search_select'] = Char_cv($data['search_select']);
        $data['action'] = Char_cv($data['action']);
        $data['name'] = Char_cv($data['name']);
        $data['url'] = Char_cv($data['url']);
        $data['img_url'] = Char_cv($data['img_url']);
        $data['img_text'] = Char_cv($data['img_text']);
        $data['btn'] = Char_cv($data['btn']);
        $data['params'] = addslashes($data['params']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::update('ylmf_search', $data, "id='{$data['id']}'"))
        {
            return true;
        }
        return false;
    }

}

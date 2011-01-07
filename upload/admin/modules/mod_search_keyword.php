<?php

/**
 * �����������
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search_keyword
{
    /**
     * ������������б�
     * @return <array>
     */
    public static function get_search_keyword_list($classid = '')
    {
        $and_sql = "";
        ($classid) && $and_sql = "WHERE class = '{$classid}'";
        app_db::query("SELECT a.*,b.classname FROM `ylmf_search_keyword` as a LEFT JOIN `ylmf_searchclass` as b ON a.class=b.classid  {$and_sql} ORDER BY a.sort ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * ���һ������������Ϣ
     * @return <array>
     */
    public static function get_search_keyword_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_search_keyword` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * �������� ɾ��,���������ʽ
     * @return <array>
     */
    public static function search_keyword_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("��ѡ��ɾ������.");
        }
        if ($ids = checkselid($ids))
        {
            app_db::query("DELETE FROM `ylmf_search_keyword` WHERE `id` IN($ids)");
        }
        else
        {
            exit("�����Ƿ�.");
        }
    }

    /**
     * ��������ؼ��� ����
     * @return <array>
     */
    public static function search_keyword_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search_keyword` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

    /**
     * �������� �����������
     * @param <array> $form  ��ӵ�POST����
     */
    public static function search_keyword_save_add($data)
    {
        $data['class'] = (empty($data['class'])) ? '' : $data['class'];
        if (empty($data['class']))
        {
            throw new Exception('��ѡ�����', 10);
        }

        $data['name'] = (empty($data['name'])) ? '' : htmlspecialchars($data['name'], ENT_QUOTES);
        if (empty($data['name']))
        {
            throw new Exception('�ؼ������Ʋ���Ϊ��', 10);
        }

        $data['url'] = (empty($data['url'])) ? '' : $data['url'];
        if (empty($data['url']) || !preg_match('#^http[s]?://#', $data['url']))
        {
            throw new Exception('��վ��ַ����Ϊ�ջ�����http://��ͷ', 10);
        }

        $data['namecolor'] = (empty($data['namecolor'])) ? '' : trim($data['namecolor']);
        if (!empty($data['namecolor']) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $data['namecolor']))
        {
            throw new Exception('��ɫ���벻��ȷ������ȷ��ʽ��#FF0000��', 10);
        }

        $data['sort'] = (empty($data['sort'])) ? 100 : $data['sort'];

        $data['starttime'] = (empty($data['starttime'])) ? 0 : strtotime($data['starttime']);

        $data['endtime'] = (empty($data['endtime'])) ? 0 : strtotime($data['endtime']);
        if ($data['endtime'] < $data['starttime'])
        {
            throw new Exception('����ʱ�䲻�����ڿ�ʼʱ��', 10);
        }

        $data['remarks'] = (empty($data['remarks'])) ? '' : trim($data['remarks']);

        if (app_db::insert('ylmf_search_keyword', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * �������� �����޸�����
     * @param <array> $data
     */
    public static function search_keyword_save_edit($data)
    {
        $data['class'] = (empty($data['class'])) ? '' : $data['class'];
        if (empty($data['class']))
        {
            throw new Exception('��ѡ�����', 10);
        }

        $data['name'] = (empty($data['name'])) ? '' : htmlspecialchars($data['name'], ENT_QUOTES);
        if (empty($data['name']))
        {
            throw new Exception('�ؼ������Ʋ���Ϊ��', 10);
        }

        $data['url'] = (empty($data['url'])) ? '' : $data['url'];
        if (empty($data['url']) || !preg_match('#^http[s]?://#', $data['url']))
        {
            throw new Exception('��վ��ַ����Ϊ�ջ�����http://��ͷ', 10);
        }

        $data['namecolor'] = (empty($data['namecolor'])) ? '' : trim($data['namecolor']);
        if (!empty($data['namecolor']) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $data['namecolor']))
        {
            throw new Exception('��ɫ���벻��ȷ������ȷ��ʽ��#FF0000��', 10);
        }

        $data['sort'] = (empty($data['sort'])) ? 100 : $data['sort'];

        $data['starttime'] = (empty($data['starttime'])) ? 0 : strtotime($data['starttime']);

        $data['endtime'] = (empty($data['endtime'])) ? 0 : strtotime($data['endtime']);
        if ($data['endtime'] < $data['starttime'])
        {
            throw new Exception('����ʱ�䲻�����ڿ�ʼʱ��', 10);
        }

        $data['remarks'] = (empty($data['remarks'])) ? '' : trim($data['remarks']);

        if (app_db::update('ylmf_search_keyword', $data, "id='{$data['id']}'"))
        {
            return true;
        }
        return false;
    }

}

<?php

/**
 * ��ҳվ�������վ������
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_cool_site
{

    /**
     * �����������
     *
     * @param string $keyword
     * @param string $search_type
     * @param int $start[optional]
     * @param int $num[optional]
     * @return array
     */
    public static function search($keyword, $search_type, $start = 0, $num = 0)
    {
        if ($search_type != 'url' && $search_type != 'name')
        {
            return false;
        }

        $condition = " AND a.`{$search_type}` LIKE '%{$keyword}%'";
        $condition .= ' ORDER BY b.displayorder, a.displayorder';
        if ($start > -1 && $num > 0)
        {
            $condition .= " LIMIT {$start}, {$num}";
        }
        $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid, b.classname, a.name, a.url, a.displayorder,
                       a.good, a.starttime, a.endtime, a.namecolor
                FROM ylmf_coolsite AS a, ylmf_coolclass AS b
                WHERE a.class = b.classid ' . $condition;
        $query = app_db::query($sql);

        $data = array();
        while ($rt = app_db::fetch_one())
        {
            $data[] = $rt;
        }
        if (empty($data))
        {
            return false;
        }

        $output = array();
        $total = app_db::query('SELECT FOUND_ROWS() AS rows');
        $total = app_db::fetch_one();
        $output['total'] = $total['rows'];
        $output['data'] = $data;
        return $output;
    }

    /**
     * ��ȡ�б�
     *
     * @param int $class_id
     * @param int $isend
     * @param int $start[optional]
     * @param int $num[optional]
     * @return array
     */
    public static function get_list($class_id = 0, $isend = false, $start = 0, $num = 0)
    {
        $condition = '';
        // ����
        if ($class_id > 0)
        {
            $condition .= ( !empty($condition)) ? " AND `class` = {$class_id}" :
                    " AND `class` = {$class_id}";
        }
        // ����
        if ($isend)
        {
            $condition .= ( !empty($condition)) ? ' AND `endtime` > 0 AND `endtime` < ' . time() :
                    ' AND `endtime` > 0 AND `endtime` < ' . time();
        }

        $condition .= ' ORDER BY b.displayorder, a.displayorder';
        if ($start > -1 && $num > 0)
        {
            $condition .= " LIMIT {$start}, {$num}";
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid, b.classname, a.name, a.url, a.displayorder,
                       a.good, a.starttime, a.endtime, a.namecolor
                FROM ylmf_coolsite AS a, ylmf_coolclass AS b
                WHERE  a.class = b.classid ' . $condition;
        $query = app_db::query($sql);

        $data = array();
        while ($rt = app_db::fetch_one())
        {
            $data[] = $rt;
        }
        if (empty($data))
        {
            return false;
        }

        $output = array();
        $total = app_db::query('SELECT FOUND_ROWS() AS rows');
        $total = app_db::fetch_one();
        $output['total'] = $total['rows'];
        $output['data'] = $data;
        return $output;
    }

    /**
     * ��ȡһ��վ�����Ϣ
     */
    public static function get_one($id)
    {
        if ($id < 1)
        {
            return false;
        }
        $id = (int) $id;

        $data = app_db::select('ylmf_coolsite', '*', "id = {$id}");
        return (empty($data)) ? false : $data[0];
    }

    /**
     * �����վ�Ƿ��Ѵ���
     *
     * @param int $class_id
     * @param int $site ��վ���� URL
     */
    public static function check_exists($class_id, $site, $id = 0)
    {
        $class_id = (int) $class_id;
        if ($id > 0)
        {
            $data = app_db::select('ylmf_coolsite', 'id', "`class` = {$class_id} AND (`name` = '{$site}' OR url = '{$site}') AND id != {$id}");
        }
        else
        {
            $data = app_db::select('ylmf_coolsite', 'id', "`class` = {$class_id} AND (`name` = '{$site}' OR url = '{$site}')");
        }
        return (empty($data)) ? false : true;
    }

    /**
     * ɾ����������п�վ
     *
     * @param int $class_id ����ID
     */
    public static function delete_by_class($class_id)
    {
        $class_id = (int) $class_id;
        if ($class_id < 1)
        {
            return false;
        }

        return app_db::delete('ylmf_coolsite', "class = {$class_id}");
    }

    /**
     * ��ȡ��ҳ��վ��������¿�վ
     *
     * @param
     * @return array
     */
    public static function get_homepage_cool_site()
    {
        $now_time = time();
        $sql = "SELECT  a.id, b.classid, b.classname, b.path as classurl, a.name, a.url, a.displayorder,
                       a.good, a.starttime, a.endtime, a.namecolor
                FROM ylmf_coolsite AS a, ylmf_coolclass AS b
                WHERE a.class = b.classid order by b.displayorder, a.displayorder";
        $query = app_db::query($sql);

        $data = array();
        while ($rt = app_db::fetch_one())
        {
            //var_dump($rt);
            //û���趨ʱ�� ���� �趨��ʱ��������ڵ�ʱ��
            if ($rt['endtime'] == 0 || $rt['endtime'] > $now_time)
            {
                $data[] = $rt;
            }
        }
        if (empty($data))
        {
            return array();
        }
        return $data;
    }

}

?>

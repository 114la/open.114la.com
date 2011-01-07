<?php
/**
 * �ط�������ҳվ�������
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 * @version    $Id: mod_local_index.php 172 2009-11-19 01:03:44Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_local_index
{
	/**
	 * վ�㻺��
	 *
	 * @param array $local_index_data վ������
	 * @return void
	 */
	public static function update_cache_local_index($local_index_data = array())
	{
        if(!empty($local_index_data))
        {
            usort($local_index_data, "cmp");
        }
		mod_cache::set_cache('cache_local_index', $local_index_data);
	}


	/**
	 * ��ȡվ���б�
	 *
	 * @return array
	 */
	public static function get_local_index_list()
	{
		if (false == $output = mod_cache::get_cache('cache_local_index'))
		{
			self::update_cache_local_index();
			$output = mod_cache::get_cache('cache_local_index');
		}
		return $output;
	}

	/**
	 * ���վ�㹤��
	 *
	 * @param array $local_index ��վ������
	 * @return array
	 */
	public static function add_local_index($local_index = array())
	{
        if(empty($local_index))
        {
            return false;
        }
        $list = self::get_local_index_list();
        $list[] = $local_index;
        self::update_cache_local_index($list);
    }

	/**
	 * ����վ��
	 *
	 * @param array $order վ��˳��
	 * @return array
	 */
	public static function order_local_index($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_local_index_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_local_index($list);
    }

	/**
	 * �޸�վ��
	 *
	 * @param int $id վ��id
	 * @param array $local_index վ������
	 * @return array
	 */
	public static function edit_local_index($id = null, $local_index = array())
	{
        if($id === null || empty($local_index))
        {
            return false;
        }
        $list = self::get_local_index_list();
        $list[$id] = $local_index;
        self::update_cache_local_index($list);
    }

	/**
	 * ��ȡһ��վ�����Ϣ
     *
	 * @param int $id վ��id
	 * @return array
	 */
	public static function get_local_index($id)
	{
        $list = self::get_local_index_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * ɾ��վ��
     *
	 * @param int/array $id վ��id
	 * @return array
	 */
	public static function delete_local_index($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_local_index_list();
        if(is_array($id))
        {
            foreach($id as $i)
            {
                unset($list[$i]);
            }
        }
        else
        {
            unset($list[$id]);
        }
        self::update_cache_local_index($list);
    }

}
?>

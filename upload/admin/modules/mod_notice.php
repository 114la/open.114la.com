<?php
/**
 * ���������
 *
 * @copyright http://www.114la.com
 * @version    $Id: mod_notice.php 1101 2009-11-28 03:54:48Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_notice
{
	/**
	 * ���������
	 *
	 * @param array $notice_data ��ǩ����
	 * @return void
	 */
	public static function update_cache_notice($notice_data = array())
	{
        if(!empty($notice_data))
        {
            usort($notice_data, "cmp");
        }
		mod_cache::set_cache('cache_notice', $notice_data);
	}


	/**
	 * ��ȡ��������б�
	 *
	 * @return array
	 */
	public static function get_notice_list()
	{
		if (false == $output = mod_cache::get_cache('cache_notice'))
		{
			self::update_cache_notice();
			$output = mod_cache::get_cache('cache_notice');
		}
		return $output;
	}

	/**
	 * ��ӹ������
	 *
	 * @param array $notice �¹����������
	 * @return array
	 */
	public static function add_notice($notice = array())
	{
        if(empty($notice))
        {
            return false;
        }
        $list = self::get_notice_list();
        $list[] = $notice;
        self::update_cache_notice($list);
    }

	/**
	 * ���򹫸����
	 *
	 * @param array $order �������˳��
	 * @return array
	 */
	public static function order_notice($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_notice_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_notice($list);
    }

	/**
	 * �޸Ĺ������
	 *
	 * @param int $id �������id
	 * @param array $notice �����������
	 * @return array
	 */
	public static function edit_notice($id = null, $notice = array())
	{
        if($id === null || empty($notice))
        {
            return false;
        }
        $list = self::get_notice_list();
        $list[$id] = $notice;
        self::update_cache_notice($list);
    }

	/**
	 * ��ȡһ������������Ϣ
     *
	 * @param int $id �������id
	 * @return array
	 */
	public static function get_notice($id)
	{
        $list = self::get_notice_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * ɾ���������
     *
	 * @param int/array $id �������id
	 * @return array
	 */
	public static function delete_notice($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_notice_list();
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
        self::update_cache_notice($list);
    }

}
?>

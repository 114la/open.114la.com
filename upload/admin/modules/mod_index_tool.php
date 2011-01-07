<?php
/**
 * ��ҳ����
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_index_tool
{
	/**
	 * ��ҳ���߻���
	 *
	 * @param array $index_tool_data ��ǩ����
	 * @return void
	 */
	public static function update_cache_index_tool($index_tool_data = array())
	{
        if(!empty($index_tool_data))
        {
            usort($index_tool_data, "cmp");
        }
		mod_cache::set_cache('cache_index_tool', $index_tool_data);
	}


	/**
	 * ��ȡ��ҳ�����б�
	 *
	 * @return array
	 */
	public static function get_index_tool_list()
	{
		if (false == $output = mod_cache::get_cache('cache_index_tool'))
		{
			self::update_cache_index_tool();
			$output = mod_cache::get_cache('cache_index_tool');
		}
		return $output;
	}

	/**
	 * �����ҳ����
	 *
	 * @param array $index_tool ����ҳ��������
	 * @return array
	 */
	public static function add_index_tool($index_tool = array())
	{
        if(empty($index_tool))
        {
            return false;
        }
        $list = self::get_index_tool_list();
        $list[] = $index_tool;
        self::update_cache_index_tool($list);
    }

	/**
	 * ������ҳ����
	 *
	 * @param array $order ��ҳ����˳��
	 * @return array
	 */
	public static function order_index_tool($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_index_tool_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_index_tool($list);
    }

	/**
	 * �޸���ҳ����
	 *
	 * @param int $id ��ҳ����id
	 * @param array $index_tool ��ҳ��������
	 * @return array
	 */
	public static function edit_index_tool($id = null, $index_tool = array())
	{
        if($id === null || empty($index_tool))
        {
            return false;
        }
        $list = self::get_index_tool_list();
        $list[$id] = $index_tool;
        self::update_cache_index_tool($list);
    }

	/**
	 * ��ȡһ����ҳ���ߵ���Ϣ
     *
	 * @param int $id ��ҳ����id
	 * @return array
	 */
	public static function get_index_tool($id)
	{
        $list = self::get_index_tool_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * ɾ����ҳ����
     *
	 * @param int/array $id ��ҳ����id
	 * @return array
	 */
	public static function delete_index_tool($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_index_tool_list();
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
        self::update_cache_index_tool($list);
    }

}
?>

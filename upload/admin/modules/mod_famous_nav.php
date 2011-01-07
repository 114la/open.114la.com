<?php
/**
 * 名站导航切换栏
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_famous_nav
{
/**
 * 名站导航 列表
 * @return <type>
 */
	public static function famous_nav_list()
	{
		$timestamp=time();
		$starttime=get_date($timestamp,'Y-m-d');
		$endtime=get_date($timestamp+86400*30,'Y-m-d');
		$sitedb=array();
		$query = app_db::query("SELECT * FROM ylmf_mingzhan  ORDER BY  displayorder,starttime,endtime  ");
		$sitedb=array();
		while ($site = app_db::fetch_one())
		{
			if ($site['starttime']==0)
			{
				$site['starttime']='-';
			}else
			{
				$site['starttime']=date( 'Y-m-d',$site['starttime']);
			}
                        
			if($site['starttime']==0)
			{
				$site['endtime']='-';
			}elseif ($timestamp>$site['endtime'])
			{
				$site['endtime']='<font color=red>'.date('Y-m-d', $site['endtime']).'</font>';
			}else
			{
				$site['endtime']=date( 'Y-m-d',$site['endtime']);
			}
			$sitedb[] = $site;
		}
		return $sitedb;
	}

	/**
	 * 添加信息
	 * @param <array> $data  添加的POST数据
	 */
	public static function famous_nav_add($data)
	{
//		$data=array(
//			'name'=>'wushc测试',
//			'namecolor'=>'232323',
//			'displayorder'=>'232',
//			'url'=>'http://www.baidu.com',
//			'starttime'=>'121212121',
//			'endtime'=>'131313131',
//			'remark'=>'remak_info___detail',
//		);
		if(empty($data['name']))
		{
			throw new Exception("请输入站点名称");
		}
		$data['name']=Char_cv($data['name']);
		$data['namecolor']=trim($data['namecolor']);
		if ($data['namecolor']!='')
		{
			if(!eregi("^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$" ,$data['namecolor']) )
			{
				throw new Exception("颜色非法");
			}
		}
		if(!eregi("^http://",$data['url']))
		{
			throw new Exception("网站地址不能为空或请以http://开头");
		}
		$data['displayorder']=trim($data['displayorder']);
		!is_numeric($data['displayorder']) && $data['displayorder']=100;
		$data['starttime']=trim($data['starttime']);
		$data['endtime']=trim($data['endtime']);
		$data['starttime']=self::to_timestamp($data['starttime']);
		$data['endtime']=self::to_timestamp($data['endtime']);
		if ($data['endtime']<$data['starttime'])
		{
			throw new Exception("结束时间不能小于开始时间.");
		}
		$data['remark']=char_cv(trim($data['remark']));
		app_db::query("INSERT INTO ylmf_mingzhan(name,url,namecolor,displayorder,starttime,endtime,remark)VALUES('{$data['name']}','{$data['url']}',
 '{$data['namecolor']}','{$data['displayorder']}','{$data['starttime']}','{$data['endtime']}','{$data['remark']}')");
		return true;
	}

	/**
	 * 删除,接受数组格式
	 * @param <array> $data
	 */
	public static function famous_nav_delete($delid)
	{
		if(!is_array($delid))
		{
			throw new Exception("请选择删除数据.");
		}
		if($delid=checkselid($delid))
		{
			app_db::query("DELETE FROM ylmf_mingzhan WHERE id IN ($delid) ");
			self::updatecache_classnum();//更新缓存
			return true;
		}else
		{
			throw new Exception("参数非法.");
		}
	}

	/**
	 * 保存数据
	 * @param <array> $data
	 */
	public static function famous_nav_save($data,$type='select')
	{
//		$data=array(
//			'step'=>'2',
//			'id'=>'2',
//			'name'=>'腾讯QQQ',
//			'namecolor'=>'232323',
//			'displayorder'=>'2',
//			'url'=>'http://www.baidu.com',
//			'starttime'=>'121212121',
//			'endtime'=>'131313131',
//			'remark'=>'remak_info___detail',
//		);
		if(!is_numeric($data['id']))
		{
			throw new Exception("非法参数");
		}
		$data['id']=intval($data['id']);
		$info=app_db::query("SELECT * FROM ylmf_mingzhan WHERE id='{$data['id']}' ");
                $info=app_db::fetch_one();
		if(!$info)
		{
			throw new Exception("没有这个站点");
		}
		if ($type=='save')//保存信息

		{
			$data['name']=trim($data['name']);
			if($data['name']=='')
			{
				throw new Exception("请输入站点名称");
			}
			$data['name']=Char_cv($data['name']);
			$data['namecolor']=trim($data['namecolor']);
			if ($data['namecolor']!='')
			{
				if(!eregi("^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$" ,$data['namecolor']) )
				{
					throw new Exception("颜色非法");
				}
			}
			if(!eregi("^http://",$data['url']))
			{
				throw new Exception("网站地址不能为空或请以http://开头");
			}
			$data['displayorder']=trim($data['displayorder']);
			!is_numeric($data['displayorder']) && $data['displayorder']=100;
			$data['starttime']=trim($data['starttime']);
			$data['endtime']=trim($data['endtime']);
			$data['starttime']=self::to_timestamp(($data['starttime']));
			$data['endtime']=self::to_timestamp(($data['endtime']));
			if ($data['endtime']<$data['starttime'])
			{
				throw new Exception("结束时间不能小于开始时间.");
			}
			$data['remark']=char_cv(trim($data['remark']));
			app_db::query("UPDATE ylmf_mingzhan SET name='{$data['name']}',url='{$data['url']}' ,namecolor='{$data['namecolor']}',starttime='{$data['starttime']}',
				displayorder='{$data['displayorder']}',endtime='{$data['endtime']}',remark='{$data['remark']}' WHERE id='{$data['id']}' ");
			return true;
		}
		elseif($type=='select')
		{
			if ($info['starttime']==0)
			{
				$info['starttime']='';
			}else
			{
				$info['starttime']=get_date( $info['starttime'],'Y-m-d');
			}
			if ($info['endtime']==0)
			{
				$info['endtime']='';
			}else
			{
				$info['endtime']=get_date( $info['endtime'],'Y-m-d');
			}
			return $info;
		}
	}

	/**
	 * 排序保存
	 * @param <type> $orderby
	 */
	public static function famous_nav_order($orderby)
        {
            if (is_array($orderby))
            {
                foreach($orderby as $key =>$val)
                {
                    $order=(int)$val;
                    $id=intval($key);
                    app_db::query("UPDATE ylmf_mingzhan SET displayorder='$order' WHERE id=$key");
                }
            }
            else
            {
                throw new Exception("提交排序参数错误,请重试.");
            }
        }



	/**
	 * 更新站点分类
	 * @global <type> $db
	 */
	public static function   updatecache_classnum()
	{
		global  $db;
		$data=app_db::select("ylmf_class" , "*","1");
		foreach ($data as $class)
		{
			app_db::query("SELECT count(*) as sum FROM ylmf_site WHERE class='$class[classid]'");
			$rt=app_db::fetch_one();
			app_db::query("UPDATE ylmf_class SET sitenum='$rt[sum]'  WHERE classid='$class[classid]'");
		}
	}

        public static function to_timestamp($Time,$Which="-",$Long=6)
        {
            if(strlen($Time)>$Long)
            {	$timeexplode=explode($Which,$Time);
                return mktime(0, 0, 0, $timeexplode[1], $timeexplode[2], $timeexplode[0]);
            }
            else
            {	return false;
            }
        }
        public static function from_timestamp($Time,$How=10000000)
        {
            if($Time>$How)
                return date("Y-m-d",$Time);
            else
                return null;
        }
}
?>
<?php
/**
 * 114啦 网址导航系统
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    modules
 * @version    $Id: mod_plan.php 20 2009-11-03 04:12:25Z syh $
 */

/**
 * 计划任务类
 */
 !defined('PATH_ADMIN') &&exit('Forbidden');
class mod_plan
{
	/**
	 * 添加计划任务
	 *
	 * @param  array $data
	 * @return none
	 * @throws none
	 */
	public static function add_plan( $data = array() )
	{
		if( empty( $data ) )
		{
			return false;
		}
		extract( $data, EXTR_SKIP );
		!$title && exit('标题不能为空');
        $title = htmlspecialchars( $title );
        $filename = htmlspecialchars( $filename );

		if( is_numeric( $month ) )
		{
			$month = $month < 1 ? 1 : ( $month > 31 ? 31 : $month);
			$week = '*';
		}
		elseif( is_numeric($week) )
		{
			$week = $week < 1 ? 1 : ( $week > 7 ? 7 : $week );
			$month = '*';
		}
		else
		{
			$month = $week = '*';
		}//end if( is_numeric( $month ) )

		if( is_numeric($day) )
		{
			$day = $day<0 ? 0 : ($day>23 ? 23 : $day);
		}
		else
		{
			$day='*';
		}//end if( is_numeric($day) )

		if( is_array($hours) )
		{
			$hours = array_unique($hours);
			$hour_w = '';
			$hour_t = '';
			foreach( $hours as $key => $hour )
			{
				is_numeric( $hour ) && $hour_t = $hour < 0 ? 0 : ( $hour > 59 ? 59 : $hour );
				$hour_w .= $hour_w ? ',' . $hour_t : $hour_t;
			}
			!$hour_w && $hour_w='*';
		}
		else
		{
			$hour_w='*';
		}
		if( $month == '*' && $week == '*' && $day == '*' && $hour_w == '*' && $ifopen == 1 )
		{
			exit('time_error');
		} //if( is_array($hours) )

		$plan = array(
			'month' => $month,
			'week' => $week,
			'day' => $day,
			'hour' => $hour_w,
			'usetime' => '0',
			'ifopen' => $ifopen
			);
		$nexttime = self::nexttime($plan);
		if( strpos($filename, '..') !== false )
		{
			exit("undefined_action");
		}
		app_db::query("insert into ylmf_plan (subject,month,week,day,hour,nexttime,ifsave,ifopen,filename) VALUES('$title','$month','$week','$day','$hour_w','$nexttime','0','$ifopen','$filename')");
		self::update_cache_admin_plan();
        mod_login::message("添加成功!",'?c=plan&a=index');
	}

	/**
	 * 编辑计划任务
	 *
	 * @param  int $id
	 * @param  array $data
	 * @return none
	 * @throws none
	 */
	public static function edit_plan( $id, $data = array() )
	{
		if( empty( $data ) )
		{
			return false;
		}
		extract( $data, EXTR_SKIP );
		!$title && exit('标题不能为空');
        $title = htmlspecialchars( $title );
        $filename = htmlspecialchars( $filename );

		if( is_numeric( $month ) )
		{
			$month = $month < 1 ? 1 : ( $month > 31 ? 31 : $month);
			$week = '*';
		}
		elseif( is_numeric($week) )
		{
			$week = $week < 1 ? 1 : ( $week > 7 ? 7 : $week );
			$month = '*';
		}
		else
		{
			$month = $week = '*';
		}//end if( is_numeric( $month ) )

		if( is_numeric($day) )
		{
			$day = $day<0 ? 0 : ($day>23 ? 23 : $day);
		}
		else
		{
			$day='*';
		}//end if( is_numeric($day) )

		if( is_array($hours) )
		{
			$hours = array_unique($hours);
			$hour_w = '';
			$hour_t = '';
			foreach( $hours as $key => $hour )
			{
				if( is_numeric( $hour ) )
				{
					$hour_t = $hour < 0 ? 0 : ( $hour > 59 ? 59 : $hour );
					$hour_w .= $hour_w ? ',' . $hour_t : $hour_t;
				}
			}
			$hour_w === '' && $hour_w='*';
		}
		else
		{
			$hour_w='*';
		}
		if( $month == '*' && $week == '*' && $day == '*' && $hour_w == '*' && $ifopen == 1 )
		{
			exit('time_error');
		} //if( is_array($hours) )

		$plan = array(
			'month' => $month,
			'week' => $week,
			'day' => $day,
			'hour' => $hour_w,
			'usetime' => '0',
			'ifopen' => $ifopen
			);
		$nexttime = self::nexttime($plan);
		if( strpos($filename, '..') !== false )
		{
			exit("undefined_action");
		}
		app_db::query("update `ylmf_plan` set subject='$title',month='$month',week='$week',day='$day',hour='$hour_w',nexttime='$nexttime',ifsave='0',ifopen='$ifopen',filename='$filename' where id='$id'");
		self::update_cache_admin_plan();
        mod_login::message("修改成功!",'?c=plan&a=index');
	}

	/**
	 * 删除计划任务
	 *
	 * @param  mixed $plan_id
	 * @return none
	 * @throws none
	 */
	public static function remove_plan( $plan_id )
	{
		if( is_array( $plan_id ) )
		{
			foreach( $plan_id as $current_id )
			{
				self::remove_plan( $current_id );
			}
		}
		else
		{
			app_db::query("delete from `ylmf_plan` where id='" . intval( $plan_id ) . "'");
		}
		self::update_cache_admin_plan();
	}

	public static function check_plan()
	{
		$plan_list = self::get_plan_list();
		$timestamp = $_SERVER['REQUEST_TIME'];
		$plantime = $plan_list['plantime'];
		unset( $plan_list['plantime'] );
		if ($plantime != '' && $timestamp > $plantime)
		{
			foreach($plan_list as $key => $plan)
			{
				if ($timestamp > $plan['nexttime'] && file_exists( PATH_DATA . '/plan/' . $plan['filename'] . '.php') )
				{

					$nexttime = self::nexttime($plan);
					app_db::query("update ylmf_plan set usetime='$timestamp',nexttime='$nexttime' where id='" . $plan['id'] . "'");
					self::update_cache_admin_plan();
					require PATH_DATA . '/plan/' . $plan['filename'] . '.php';
				}
			}
		}
	}

	public static function execute_plan( $id )
	{
		if( $plan = self::get_plan( $id ))
		{
			if( file_exists(PATH_DATA . '/plan/' . $plan['filename'] . '.php') )
			{
				 require PATH_DATA . '/plan/' . $plan['filename'] . '.php';
			}
		}

	}

	/**
	 * 读一条计划任务
	 *
	 * @param  mixed $plan_id
	 * @return none
	 * @throws none
	 */
	public static function get_plan( $plan_id )
	{
		$plan_list = mod_plan::get_plan_list();
		foreach( $plan_list as $current_plan)
		{
			if( $current_plan['id'] == $plan_id )
			{
				return $current_plan;
			}
		}
		return false;
	}

	/**
	 * 读计划任务列表
	 *
	 * @param  none
	 * @return array
	 * @throws none
	 */
	public static function get_plan_list()
	{
		$plan_list = mod_cache::get_cache( 'cache_admin_plan' );
		if( false === $plan_list )
		{
			self::update_cache_admin_plan();
			$plan_list = mod_cache::get_cache( 'cache_admin_plan' );
		}
		return $plan_list;
	}


	private static function get_date($timestamp,$timeformat='')
	{
		$yl_timedf = mod_config::get_one_config( 'yl_timedf' );
		$yl_datefm = mod_config::get_one_config( 'yl_datefm' );
		$date_show=$timeformat ? $timeformat : $yl_datefm;
		$offset = $yl_timedf=='111' ? 0 : $yl_timedf;
		return gmdate($date_show,$timestamp+$offset*3600);
	}

	/**
	 * 更新计划任务缓存
	 *
	 * @param  none
	 * @return none
	 * @throws none
	 */
	public static function update_cache_admin_plan()
	{
		app_db::query("select * from ylmf_plan where ifopen='1' order by id");
		$plans = app_db::fetch_all();
        if( !$plans )
        {
            mod_cache::set_cache( 'cache_admin_plan', array() );
            return;
        }
		foreach ($plans as $current_plan )
		{
			$plantime[] = $current_plan['nexttime'];
		}
		rsort($plantime);
		$plans['plantime'] = array_pop($plantime);
		mod_cache::set_cache( 'cache_admin_plan', $plans );
	}

	private static function nexttime($plan)
	{
		if($plan['ifopen'] == 0) return 0;
		$timestamp = $_SERVER['REQUEST_TIME'];
		$yl_timedf = mod_config::get_one_config( 'yl_timedf' );
		$t		= gmdate( 'G',$timestamp + $yl_timedf*3600 );
		$timenow= ( floor($timestamp / 3600) - $t )*3600;
		$minute = (int)self::get_date($timestamp,'i');
		$hour   = self::get_date($timestamp,'G');
		$day    = self::get_date($timestamp,'j');
		$month  = self::get_date($timestamp,'n');
		$year   = self::get_date($timestamp,'Y');
		$week   = self::get_date($timestamp,'w');
		$week==0 && $week=7;
		if(is_numeric($plan['month']))
		{
			$timenow += ($plan['month']-$day)*86400;
		}
		elseif(is_numeric($plan['week']))
		{
			$timenow += ($plan['week']-$week)*86400;
		}
		if(is_numeric($plan['day']))
		{
			$timenow += $plan['day']*3600;
		}
		if($plan['hour']!='*')
		{
			$hours=explode(',',$plan['hour']);
			asort($hours);
			if(is_numeric($plan['month']) || is_numeric($plan['week']) || is_numeric($plan['day']))
			{
				foreach($hours as $key=>$value)
				{
					if(($timenow+$value*60)>$plan['usetime'] && ($timenow+$value*60)>$timestamp)
					{
						$timenow +=$value*60;
						return $timenow;
					}
				}
			}
			else
			{
				$timenow += $hour*3600;
				for($i=0;$i<2;$i++)
				{
					foreach($hours as $key=>$value)
					{
						if(($timenow+$value*60)>$plan['usetime'] && ($timenow+$value*60)>$timestamp)
						{
							$timenow +=$value*60;
							return $timenow;
						}
					}
					$timenow +=3600;
				}
				return $timenow+$hours['0'];
			}
		}
		elseif($timenow>$plan['usetime'] && $timenow>$timestamp)
		{
			return $timenow;
		}
		if(is_numeric($plan['month']))
		{
			if(in_array($month,array('1','3','5','7','8','10','12')))
			{
				$days=31;
			}
			elseif($month!=2)
			{
				$days=30;
			}
			else
			{
				if(self::get_date($timestamp,'L'))
				{
					$days=29;
				}
				else
				{
					$days=28;
				}
			}
			$timenow += $days*86400;
		}
		elseif(is_numeric($plan['week']))
		{
			$timenow += 604800;
		}
		elseif(is_numeric($plan['day']))
		{
			$timenow += 86400;
		}
		if($plan['hour']!='*')
		{
			$timenow += $hours[0]*60;
		}
		if($timenow>$timestamp)
		{
			return $timenow;
		}
		return $timestamp+86400;
	}
}
?>

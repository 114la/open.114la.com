<?php
/**
 * 行业网站分类管理类
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_trade_class.php 160 2009-11-18 00:47:30Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_trade_class
{
/**
 * 更新主分类缓存
 *
 * @param array $data[optional] //分类数据，可选
 * @return 
 */
    public static function update_cache_main_class($data = array())
    {
        $update_parent_sitenum = false;
        if(!$data)
        {
            $data = app_db::select('ylmf_tradeclass', '*', '1 ORDER BY displayorder');
            $update_parent_sitenum = true;
        }
        $class_list = array();
        if( $data )
        {
            foreach ($data as $row)
            {
                $class_list[$row['classid']] = $row;
            }
            unset($data);
        }
        mod_cache::set_cache('cache_trade_class', $class_list);
    }


    /**
     * 获取所有分类列表
     *
     * @param  
     * @return array
     */
    public static function get_class_list()
    {
        if (false == $output = mod_cache::get_cache('cache_trade_class'))
        {
            self::update_cache_main_class();
            $output = mod_cache::get_cache('cache_trade_class');
        }
        return $output;
    }

    /**
     * 获取一个分类
     *
     * @param int $class_id //分类id
     * @return array
     */
    public static function get_a_class( $class_id )
    {
        if(empty($class_id))
        {
            return false;
        }
        $class_list = self::get_class_list();
        return $class_list[$class_id];
    }

    /**
     * 生成分类树缓存
     *
     * @param
     * @return array
     */
    public static function update_cache_class_tree()
    {
        $class_list = self::get_class_list();
        foreach( $class_list as $class )
        {
            unset($class['keywords']);
            unset($class['description']);
            $class_tree[$class['parentid']][$class['classid']] = $class;
        }
        mod_cache::set_cache( 'cache_trade_class_tree', $class_tree);
    }

    /**
     * 读取分类树缓存
     *
     * @param int $pid[optional] //父分类id 
     * @return array
     */
    public static function get_cache_class_tree($pid = NULL)
    {
        $cache_trade_class_tree = mod_cache::get_cache( 'cache_trade_class_tree' );
        if(false === $cache_trade_class_tree)
        {
            self::update_cache_class_tree();
            $cache_trade_class_tree = mod_cache::get_cache( 'cache_trade_class_tree' );
        }

        if($pid !== NULL)
        {
            return $cache_trade_class_tree[$pid];
        }
        else
        {
            return $cache_trade_class_tree;
        }
    }

    /**
     * 获取子分类列表
     *
     * @param int $p //分类数据
     * @return 
     */
    public static function get_subclass_list($pid = 0)
    {
        $pid = (int)$pid;
        if ($pid < 0)
        {
            return false;
        }
        return self::get_cache_class_tree($pid);
    }

    /**
     * 获取子分类列表,get_subclass_list的别名
     *
     * @param int $p //分类数据
     * @return 
     */
    public static function get_class_list_by_parent($pid = 0)
    {
        return self::get_subclass_list($pid);
    }

    /**
     * 添加新分类
     *
     * @param array $data //分类数据
     * @return 
     */
    public static function add_class( $data = array() )
    {
        if( $data['classnewname']=='' )
        {
            mod_login::message("请输入新分类名称!",'',1000);
        }
        else
        {
            $classid = intval($data['classid']);
            $classnewname = htmlspecialchars(trim($data['classnewname']));
            $orderid = intval(trim($data['orderid']));
            $keywords = htmlspecialchars(trim($data['keywords']));
            $description = htmlspecialchars(trim($data['description']));
            !is_numeric($orderid) && $orderid = 100;
            $path = htmlspecialchars(trim($data['path']));
            if($path != '' && !eregi("^http://",$path))
            {
                if( !eregi("[0-9a-z_]+",$path) )
                {
                    mod_login::message("自定义路径只允许是数字,字母和下划线组合!",'');
                }
            }
            app_db::query("SELECT count(*) as cnt FROM ylmf_tradeclass where parentid = '$classid' AND classname = '$classnewname'");
            $rs = app_db::fetch_one();
            if($rs['cnt']>0)
            {
                mod_login::message("该分类名称已存在!",'');
            }
            else
            {
                $parent_class = mod_class::get_a_class( $classid );
                if (eregi("^http://",$parent_class['path']))
                {
                    mod_login::message("父分类是外部链接,无法添加!",'');
                }
                app_db::query("INSERT INTO ylmf_tradeclass (parentid,classname,displayorder,path,keywords,description)VALUES ('$classid','$classnewname','$orderid','$path','$keywords','$description')");

                $class_list = self::get_class_list();
                if(app_db::insert_id() !== 0)
                {
                    $class_list[app_db::insert_id()] = array('classid' => app_db::insert_id(), 'parentid' => $classid, 'classname' => $classnewname, 'displayorder' => $orderid,  'sitenum' => '0', 'path' => $path, 'keywords' => $keywords, 'description' => $description);
                }
                self::update_cache_main_class($class_list);
                self::update_cache_class_tree();

                //mod_make_html::auto_update('catalog', app_db::insert_id());
                mod_login::message("添加成功!",'?c=trade_class&a=index&classid='.$classid);
            }
        }
    }

    /**
     * 修改分类
     *
     * @param array $data //分类数据
     * @return 
     */
    public static function edit_class($data)
    {
        $type = $data['type'];
        $returnid =  $data['returnid'];;
        $classid = intval($data['classid']);
        $classnewname = htmlspecialchars(trim($data['classnewname']));
        $id = trim( $data['id'] );
        if( $id == $classid )
        {
            $classid = 0;
        }
        $path = htmlspecialchars(trim($data['path']));
        $keywords = htmlspecialchars(trim($data['keywords']));
        $description = htmlspecialchars(trim($data['description']));

        if( $data['classnewname']=='' )
        {
            mod_login::message("请输入新分类名称!",'?c=trade_class&a=index&type='.$type.'&classid='.$returnid);
        }
        else
        {
            if($path!='')
            {
                if(!eregi("[0-9a-z_]+",$path))
                {
                    mod_login::message("自定义路径只允许是数字,字母和下划线组合!",'?c=trade_class&a=index&type='.$type.'&classid='.$returnid);
                }
            }
            if (eregi("^http://",$parent_class['path']))
            {
                mod_login::message("父分类是外部链接,无法添加!",'?c=trade_class&a=index&type='.$type.'&classid='.$returnid);
            }
            app_db::query("UPDATE ylmf_tradeclass SET classname='$classnewname' ,parentid='$classid',path='$path', keywords='$keywords',description='$description'  WHERE classid='$id'");

            $class_list = self::get_class_list();
            $class_list[$id]['parentid'] = $classid;
            $class_list[$id]['classname'] = $classnewname;
            $class_list[$id]['path'] = $path;
            $class_list[$id]['keywords'] = $keywords;
            $class_list[$id]['description'] = $description;
            self::update_cache_main_class($class_list);
            self::update_cache_class_tree();

            //mod_make_html::auto_update('catalog', $id);
        }
        mod_login::message("修改成功!",'?c=trade_class&a=index&type='.$type.'&classid='.$returnid);
    }


    /**
     * 按关键字搜索分类
     *
     * @param string $keyword //关键字
     * @return array
     */
    public static function search_class( $keyword = '' )
    {
        if(empty($keyword))
        {
            return array();
        }

        $search_rs = app_db::select('ylmf_tradeclass', 'classid', "classname like '%" . $keyword . "%'");
        if( !$search_rs )
        {
            return array();
        }

        $class = self::get_class_list();

        $result = array();
        foreach( $search_rs as $row )
        {
            $path = array();
            $id_list = array();
            if( isset($class[$row['classid']]) )
            {
                $cur_class = $class[$row['classid']];
                while(1)
                {
                    array_unshift($path, $cur_class['classname']);
                    array_unshift($id_list, $cur_class['classid']);
                    if($cur_class['parentid'] == 0) //当是一级分类时 break
                    {
                        break;
                    }
                    $cur_class = $class[$cur_class['parentid']];
                }

                $result[] = array('key' => $row['classid'], 'value' => iconv('gbk', 'utf-8//IGNORE',implode( '&raquo;', $path) ), 'id_list' => iconv('gbk', 'utf-8//IGNORE',implode( ',', $id_list)));
            }
        }
        return $result;
    }


    /**
     * 批量修改分类属性
     *
     * @param array $data //分类数据
     * @param string $action //操作类型
     * @return 
     */
    public static function update_class( $data, $action = 'update' )
    {
        if( $action == 'del' && isset($data['rmid']) )
        {
            foreach( $data['rmid'] as $id => $v )
            {
                self::delete_class( $id );
            }
        }
        else
        {
            self::order_class( $data );
            self::class_path( $data );
        }
        self::update_cache_main_class();
        self::update_cache_class_tree();
    }

    /**
     * 修改分类页面生成目录(外链地址)
     *
     * @param array $data //分类路径
     * @return 
     */
    public static function class_path( $data )
    {
        $path = $data['path'];
        foreach($path as $key => $val)
        {
            $key=intval($key);
            $newpath=$val;
            app_db::query("UPDATE ylmf_tradeclass SET path='$newpath' WHERE classid=$key");
        }
        self::update_cache_main_class();
        self::update_cache_class_tree();
    }

    /**
     * 修改分类排序
     *
     * @param array $data //分类顺序
     * @return 
     */
    public static function order_class($data )
    {
        $pre = $data['io'] ? 'index' : '';
        $order = $data['order'];
        $orderid = $data['orderid'];

        foreach($orderid as $key => $val)
        {
            $order[$key]=(int)$order[$key];
            app_db::query("UPDATE ylmf_tradeclass SET 	{$pre}displayorder='$order[$key]' WHERE classid=$val");
        }
    }

    /**
     * 删除分类,并更新分类缓存 
     *
     * @param int $id //分类id
     * @return 
     */
    public static function delete_class_and_update_cache( $id )
    {
        self::delete_class( $id );
        self::update_cache_main_class();
        self::update_cache_class_tree();
        //mod_make_html::auto_update('index');
    }

    /**
     * 删除分类
     *
     * @param int $id //分类id
     * @return 
     */
    public static function delete_class( $id )
    {
        $id = intval( $id );
        if( $class_list = app_db::select('ylmf_tradeclass', 'classid', "parentid='$id'" ))
        {
            foreach( $class_list as $class )
            {
                self::delete_class($class['classid']);
            }
            app_db::delete('ylmf_tradeclass', "classid = {$id}");
        }
        else
        {
            mod_site_manage::delete_by_class($id);
            app_db::delete('ylmf_tradeclass', "classid = {$id}");
        }
    }

    /**
     * 更新分类下的站点数量
     *
     * @param int $id //分类id
     * @return 
     */
    public static function update_site_count( $id )
    {
        $class_list = self::get_class_list();
        $count = app_db::select('ylmf_tradesite', 'count(*) count', "class='$id'" );
        app_db::query("update ylmf_tradeclass set sitenum='" . $count[0]['count'] . "' where classid=$id");
        $class_list[$id]['sitenum'] = $count[0]['count'];
        self::update_cache_main_class($class_list);
    }

    /**
     * 更新父分类站点数
     *
     * @param  int $id  //分类id
     * @return
     */
    public static function update_parent_sitenum($id = null)
    {
        if($id === null)
        {
            return false;
        }
        $class_list = self::get_class_list();
        $class = $class_list[$id];
        if(!empty($class['sitenum']))
        {
            $cur_class = &$class_list[$class['parentid']];
            $cur_class['sub_sitenum'] += $class['sitenum'];
            while(($pid = $cur_class['parentid']) && $cur_class['classid'] != $cur_class['parentid'])
            {
                $sub_sitenum = $cur_class['sub_sitenum'];
                $cur_class = &$class_list[$pid];
                $cur_class['sub_sitenum'] += $sub_sitenum;
            }
        }
        self::update_cache_main_class($class_list);
    }

}
?>

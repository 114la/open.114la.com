<?php
/**
 * 酷站分类管理类
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_cool_class.php 79 2009-11-06 09:35:41Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_cool_class
{
    /**
     * 获取酷站分类列表
     *
     * @param  
     * @return array
     */
    public static function get_class_list()
    {
        $class_list = app_db::select('ylmf_coolclass', '*', '1 ORDER BY displayorder');
        if ($class_list)
        {
            return $class_list;
        }
        return false;
    }

    /**
     * 获取一个酷站分类
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
        $class = app_db::select('ylmf_coolclass', '*', "classid='$class_id'");
        if($class)
        {
            return $class[0];
        }
        return false;
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
            $classnewname = htmlspecialchars(trim($data['classnewname']));
            $orderid = intval(trim($data['orderid']));
            !is_numeric($orderid) && $orderid = 100;
            $path = htmlspecialchars(trim($data['path']));
            if($path != '' && !eregi("^http://",$path))
            {
                if( !eregi("[0-9a-z_]+",$path) )
                {
                    mod_login::message("自定义路径只允许是数字,字母和下划线组合!",'');
                }
            }
            app_db::query("SELECT count(*) as cnt FROM ylmf_coolclass where classname = '$classnewname'");
            $rs = app_db::fetch_one();
            if($rs['cnt']>0)
            {
                mod_login::message("该分类名称已存在!",'');
            }
            else
            {
                app_db::query("INSERT INTO ylmf_coolclass (classname,displayorder,path)VALUES ('$classnewname','$orderid','$path')");

                //mod_make_html::auto_update('catalog', app_db::insert_id());
                mod_login::message("添加成功!",'?c=cool_class&a=index');
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
        $id = trim( $data['id'] );
        $classnewname = htmlspecialchars(trim($data['classnewname']));
        $path = htmlspecialchars(trim($data['path']));
        $orderid = intval(trim($data['orderid']));

        if( $data['classnewname']=='' )
        {
            mod_login::message("请输入新分类名称!",'?c=cool_class&a=index');
        }
        else
        {
            if($path!='')
            {
                if(!eregi("[0-9a-z_]+",$path))
                {
                    mod_login::message("自定义路径只允许是数字,字母和下划线组合!",'?c=class&a=index&type='.$type.'&classid='.$returnid);
                }
            }
            app_db::query("UPDATE ylmf_coolclass SET classname='$classnewname', path='$path', displayorder='$orderid' WHERE classid='$id'");

            //mod_make_html::auto_update('catalog', $id);
        }
        mod_login::message("修改成功!",'?c=cool_class&a=index');
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

        $search_rs = app_db::select('ylmf_coolclass', '*', "classname like '%" . $keyword . "%'");
        if( !$search_rs )
        {
            return array();
        }
        return $search_rs;
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
            $order = $data['order'];
            $path = $data['path'];
            foreach($path as $key => $val)
            {
                $key=intval($key);
                $newpath=$val;
                $order[$key]=intval($order[$key]);
                app_db::query("UPDATE ylmf_coolclass SET path='$newpath', displayorder='$order[$key]' WHERE classid=$key");
            }
        }
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
        //mod_cool_site::delete_by_class($id);
        app_db::delete('ylmf_coolclass', "classid = {$id}");
        //mod_make_html::auto_update('index');
    }

    /**
     * 更新分类下的站点数量
     *
     * @param int $id //分类id
     * @return 
     */
    public static function update_site_count( $id )
    {
        $count = app_db::select('ylmf_site', 'count(*) count', "class='$id'" );
        app_db::query("update ylmf_class set sitenum='" . $count[0]['count'] . "' where classid=$id");
    }

}
?>

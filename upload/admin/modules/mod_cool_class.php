<?php
/**
 * ��վ���������
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_cool_class.php 79 2009-11-06 09:35:41Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_cool_class
{
    /**
     * ��ȡ��վ�����б�
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
     * ��ȡһ����վ����
     *
     * @param int $class_id //����id
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
     * ����·���
     *
     * @param array $data //��������
     * @return 
     */
    public static function add_class( $data = array() )
    {
        if( $data['classnewname']=='' )
        {
            mod_login::message("�������·�������!",'',1000);
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
                    mod_login::message("�Զ���·��ֻ����������,��ĸ���»������!",'');
                }
            }
            app_db::query("SELECT count(*) as cnt FROM ylmf_coolclass where classname = '$classnewname'");
            $rs = app_db::fetch_one();
            if($rs['cnt']>0)
            {
                mod_login::message("�÷��������Ѵ���!",'');
            }
            else
            {
                app_db::query("INSERT INTO ylmf_coolclass (classname,displayorder,path)VALUES ('$classnewname','$orderid','$path')");

                //mod_make_html::auto_update('catalog', app_db::insert_id());
                mod_login::message("��ӳɹ�!",'?c=cool_class&a=index');
            }
        }
    }

    /**
     * �޸ķ���
     *
     * @param array $data //��������
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
            mod_login::message("�������·�������!",'?c=cool_class&a=index');
        }
        else
        {
            if($path!='')
            {
                if(!eregi("[0-9a-z_]+",$path))
                {
                    mod_login::message("�Զ���·��ֻ����������,��ĸ���»������!",'?c=class&a=index&type='.$type.'&classid='.$returnid);
                }
            }
            app_db::query("UPDATE ylmf_coolclass SET classname='$classnewname', path='$path', displayorder='$orderid' WHERE classid='$id'");

            //mod_make_html::auto_update('catalog', $id);
        }
        mod_login::message("�޸ĳɹ�!",'?c=cool_class&a=index');
    }


    /**
     * ���ؼ�����������
     *
     * @param string $keyword //�ؼ���
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
     * �����޸ķ�������
     *
     * @param array $data //��������
     * @param string $action //��������
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
     * ɾ������
     *
     * @param int $id //����id
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
     * ���·����µ�վ������
     *
     * @param int $id //����id
     * @return 
     */
    public static function update_site_count( $id )
    {
        $count = app_db::select('ylmf_site', 'count(*) count', "class='$id'" );
        app_db::query("update ylmf_class set sitenum='" . $count[0]['count'] . "' where classid=$id");
    }

}
?>

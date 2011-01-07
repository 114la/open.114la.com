<?php
/**
 * �ط�������������
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_local_class.php 929 2009-11-26 04:19:10Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_local_class
{

    /**
     * ��ʼ���ط�����
     *
     * @param
     * @return 
     */
    //
    public static function init_local_class()
    {
        $provinces = array(
            '1' => array('����', 'beijing'), '2' => array('���', 'tianjin'), '3' => array('�Ϻ�', 'shanghai'), '4' => array('����', 'chongqing'), '5' => array('�ӱ�', 'hebei'),
            '6' => array('ɽ��', 'shanxi'), '7' => array('����', 'liaoning'), '8' => array('����', 'jilin'), '9' => array('������', 'heilongjiang'), '10' => array('����', 'jiangsu'),
            '11' => array('�㽭', 'zhejiang'), '12' => array('����', 'anhui'), '13' => array('����', ''), '14' => array('����', 'jiangxi'), '15' => array('ɽ��', 'shandong'),
            '16' => array('����', 'henan'), '17' => array('����', 'hubei'), '18' => array('����', 'hunan'), '19' => array('�㶫', 'guangdong'), '20' => array('����', 'hainan'),
            '21' => array('�Ĵ�', 'sichuan'), '22' => array('����', 'guizhou'), '23' => array('����', 'yunnan'), '24' => array('����', 'shaanxi'), '25' => array('����', 'gansu'),
            '26' => array('�ຣ', 'qinghai'), '27' => array('����', 'guangxi'), '28' => array('���ɹ�', 'neimenggu'), '29' => array('����', 'xicang'), '30' => array('����', 'ningxia'),
            '31' => array('�½�', ''), '32' => array('���', ''), '33' => array('����', ''), '34' => array('̨��', ''),
            );
        foreach($provinces as $i => $p)
        {
            $name = $p[0];
            $path = $p[1];
            app_db::query("INSERT INTO ylmf_localclass (classid,parentid,classname,displayorder,path,keywords,description)VALUES ('$i','0','$name','$i','$path','','')");
        }

    }

    /**
     * ���������໺��
     *
     * @param array $data[optional] //�������ݣ���ѡ
     * @return 
     */
    public static function update_cache_main_class($data = array())
    {
        $update_parent_sitenum = false;
        if(!$data)
        {
            $data = app_db::select('ylmf_localclass', '*', '1 ORDER BY displayorder');

            if(!$data)
            {
                self::init_local_class();
                $data = app_db::select('ylmf_localclass', '*', '1 ORDER BY displayorder');
            }
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
        //���·�����վ������
        if($update_parent_sitenum)
        {
            foreach($class_list as $class)
            {
                if($class['parentid'])
                {
                    $class_list[$class['parentid']]['sub_classnum']++;
                }

                $id = $class['classid'];
                $count = app_db::select('ylmf_localsite', 'count(*) count', "class='$id'" );
                app_db::query("update ylmf_localclass set sitenum='" . $count[0]['count'] . "' where classid=$id");
                $class_list[$id]['sitenum'] = $count[0]['count'];

                if($class['sitenum'])
                {
                    $cur_class = &$class_list[$class['parentid']];
                    $cur_class['sub_sitenum'] += $class['sitenum'];
                    while(($pid = $cur_class['parentid']) && $cur_class['classid'] != $cur_class['parentid'])
                    {
                        $cur_class = &$class_list[$pid];
                        $cur_class['sub_sitenum'] += $class['sitenum'];
                    }
                }
            }
        }
        mod_cache::set_cache('cache_local_class', $class_list);
    }


    /**
     * ��ȡ���з����б�
     *
     * @param  
     * @return array
     */
    public static function get_class_list()
    {
        if (false == $output = mod_cache::get_cache('cache_local_class'))
        {
            self::update_cache_main_class();
            $output = mod_cache::get_cache('cache_local_class');
        }
        return $output;
    }

    /**
     * ��ȡһ������
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
        $class_list = self::get_class_list();
        $id_list = array();
        if( isset($class_list[$class_id]) )
        {
            $cur_class = $class_list[$class_id];
            while(1)
            {
                if($cur_class['parentid'] == 0) //����һ������ʱ break
                {
                    break;
                }
                $cur_class = $class_list[$cur_class['parentid']];
                array_unshift($id_list, $cur_class['classid']);
            }
        }
        $class_list[$class_id]['id_list'] = implode( ',', $id_list);
        return $class_list[$class_id];
    }

    /**
     * ���ɷ���������
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
        mod_cache::set_cache( 'cache_local_class_tree', $class_tree);
    }

    /**
     * ��ȡ����������
     *
     * @param int $pid[optional] //������id 
     * @return array
     */
    public static function get_cache_class_tree($pid = NULL)
    {
        $cache_local_class_tree = mod_cache::get_cache( 'cache_local_class_tree' );
        if(empty($cache_local_class_tree))
        {
            self::update_cache_class_tree();
            $cache_local_class_tree = mod_cache::get_cache( 'cache_local_class_tree' );
        }

        if($pid !== NULL)
        {
            return $cache_local_class_tree[$pid];
        }
        else
        {
            return $cache_local_class_tree;
        }
    }

    /**
     * ��ȡ�ӷ����б�
     *
     * @param int $p //��������
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
     * ��ȡ�ӷ����б�,get_subclass_list�ı���
     *
     * @param int $p //��������
     * @return 
     */
    public static function get_class_list_by_parent($pid = 0)
    {
        return self::get_subclass_list($pid);
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
            $classid = intval($data['classid']);
            $classnewname = htmlspecialchars(trim($data['classnewname']));
            $orderid = intval(trim($data['orderid']));
            $keywords = htmlspecialchars(trim($data['keywords']));
            $description = htmlspecialchars(trim($data['description']));
            !is_numeric($orderid) && $orderid = 100;
            //$path = htmlspecialchars(trim($data['path']));
            $path = '';
            if($path != '' && !eregi("^http://",$path))
            {
                if( !eregi("[0-9a-z_]+",$path) )
                {
                    mod_login::message("�Զ���·��ֻ����������,��ĸ���»������!",'');
                }
            }
            app_db::query("SELECT count(*) as cnt FROM ylmf_localclass where parentid = '$classid' AND classname = '$classnewname'");
            $rs = app_db::fetch_one();
            if($rs['cnt']>0)
            {
                mod_login::message("�÷��������Ѵ���!",'');
            }
            else
            {
                $parent_class = mod_class::get_a_class( $classid );
                if (eregi("^http://",$parent_class['path']))
                {
                    mod_login::message("���������ⲿ����,�޷����!",'');
                }
                app_db::query("INSERT INTO ylmf_localclass (parentid,classname,displayorder,path,keywords,description)VALUES ('$classid','$classnewname','$orderid','$path','$keywords','$description')");

                $class_list = self::get_class_list();
                if(app_db::insert_id() !== 0)
                {
                    $class_list[app_db::insert_id()] = array('classid' => app_db::insert_id(), 'parentid' => $classid, 'classname' => $classnewname, 'displayorder' => $orderid,  'sitenum' => '0', 'path' => $path, 'keywords' => $keywords, 'description' => $description);
                }
                self::update_cache_main_class($class_list);
                self::update_cache_class_tree();

                //mod_make_html::auto_update('catalog', app_db::insert_id());
                mod_login::message("��ӳɹ�!",'?c=local_class&a=index&classid='.$classid);
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
        $type = $data['type'];
        $returnid =  $data['returnid'];;
        $classid = intval($data['classid']);
        $classnewname = htmlspecialchars(trim($data['classnewname']));
        $id = trim( $data['id'] );
        if( $id == $classid )
        {
            $classid = 0;
        }
        //$path = htmlspecialchars(trim($data['path']));
        $path = '';
        $keywords = htmlspecialchars(trim($data['keywords']));
        $description = htmlspecialchars(trim($data['description']));

        if( $data['classnewname']=='' )
        {
            mod_login::message("�������·�������!",'?c=local_class&a=index&type='.$type.'&classid='.$returnid);
        }
        else
        {
            if($path!='')
            {
                if(!eregi("[0-9a-z_]+",$path))
                {
                    mod_login::message("�Զ���·��ֻ����������,��ĸ���»������!",'?c=local_class&a=index&type='.$type.'&classid='.$returnid);
                }
            }
            if (eregi("^http://",$parent_class['path']))
            {
                mod_login::message("���������ⲿ����,�޷����!",'?c=local_class&a=index&type='.$type.'&classid='.$returnid);
            }
            app_db::query("UPDATE ylmf_localclass SET classname='$classnewname' ,parentid='$classid',path='$path', keywords='$keywords',description='$description'  WHERE classid='$id'");

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
        mod_login::message("�޸ĳɹ�!",'?c=local_class&a=index&type='.$type.'&classid='.$returnid);
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

        $search_rs = app_db::select('ylmf_localclass', 'classid', "classname like '%" . $keyword . "%'");
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
                    if($cur_class['parentid'] == 0) //����һ������ʱ break
                    {
                        break;
                    }
                    $cur_class = $class[$cur_class['parentid']];
                }

                $result[] = array('key' => $row['classid'], 'value' => iconv('gbk', 'utf-8//IGNORE',implode( '&raquo;', $path) ), 'id_list' => iconv('gbk', 'utf-8//IGNORE',implode( ',', $id_list)) );
            }
        }
        return $result;
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
            self::order_class( $data );
            //self::class_path( $data );
        }
        self::update_cache_main_class();
        self::update_cache_class_tree();
    }

    /**
     * �޸ķ���ҳ������Ŀ¼(������ַ)
     *
     * @param array $data //����·��
     * @return 
     */
    public static function class_path( $data )
    {
        $path = $data['path'];
        foreach($path as $key => $val)
        {
            $key=intval($key);
            $newpath=$val;
            app_db::query("UPDATE ylmf_localclass SET path='$newpath' WHERE classid=$key");
        }
        self::update_cache_main_class();
        self::update_cache_class_tree();
    }

    /**
     * �޸ķ�������
     *
     * @param array $data //����˳��
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
            app_db::query("UPDATE ylmf_localclass SET 	{$pre}displayorder='$order[$key]' WHERE classid=$val");
        }
    }

    /**
     * ɾ������,�����·��໺�� 
     *
     * @param int $id //����id
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
     * ɾ������
     *
     * @param int $id //����id
     * @return 
     */
    public static function delete_class( $id )
    {
        $id = intval( $id );
        if( $class_list = app_db::select('ylmf_localclass', 'classid', "parentid='$id'" ))
        {
            foreach( $class_list as $class )
            {
                self::delete_class($class['classid']);
            }
            app_db::delete('ylmf_localclass', "classid = {$id}");
        }
        else
        {
            mod_site_manage::delete_by_class($id);
            app_db::delete('ylmf_localclass', "classid = {$id}");
        }
    }

    /**
     * ���·����µ�վ������
     *
     * @param int $id //����id
     * @return 
     */
    public static function update_site_count( $id_in = null )
    {
        $class_list = self::get_class_list();
        if($id_in === null)
        {
            foreach($class_list as $class)
            {
                $id = $class['classid'];
                $count = app_db::select('ylmf_localsite', 'count(*) count', "class='$id'" );
                app_db::query("update ylmf_localclass set sitenum='" . $count[0]['count'] . "' where classid=$id");
                $class_list[$id]['sitenum'] = $count[0]['count'];
            }
        }
        else
        {
            $count = app_db::select('ylmf_localsite', 'count(*) count', "class='$id_in'" );
            app_db::query("update ylmf_localclass set sitenum='" . $count[0]['count'] . "' where classid=$id_in");
            $class_list[$id_in]['sitenum'] = $count[0]['count'];
        }
        self::update_cache_main_class($class_list);
        if($id_in === null)
        {
            foreach($class_list as $class)
            {
                $id = $class['classid'];
                self::update_parent_sitenum($id);
            }
        }
        else
        {
            self::update_parent_sitenum($id_in);
        }
    }

    /**
     * ���¸�����վ����
     *
     * @param  int $id  //����id
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
                $sub_sitenum = $class['sitenum'];
                $cur_class = &$class_list[$pid];
                $cur_class['sub_sitenum'] += $sub_sitenum;
            }
        }
        self::update_cache_main_class($class_list);
    }

}
?>

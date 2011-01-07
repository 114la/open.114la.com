<?php
/**
 * 114�� ��ַ����ϵͳ
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    modules
 * @version    $Id: mod_mysites_import.php 20 2009-11-03 04:12:25Z syh $
 */

/**
 * ����mysites����
 */
class mod_mysites_import
{
    public static function create_table()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `tmp_hs_applies` (
              `f_id` int(10) NOT NULL auto_increment COMMENT '���',
              `f_name` varchar(255) NOT NULL COMMENT '��վ����',
              `f_url` varchar(255) NOT NULL COMMENT '��ַ',
              `f_description` text NOT NULL COMMENT '˵��',
              `f_category` varchar(255) NOT NULL COMMENT '����',
              `f_buildTime` varchar(255) NOT NULL COMMENT '��վʱ��',
              `f_ips` varchar(255) NOT NULL COMMENT '��IP������',
              `f_contact` varchar(255) NOT NULL COMMENT '��ϵ��',
              `f_tel` varchar(255) NOT NULL COMMENT '�绰',
              `f_qq` varchar(255) NOT NULL COMMENT 'QQ',
              `f_linked` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ��Ѿ�������������',
              `f_addTime` int(10) NOT NULL COMMENT '����ʱ��',
              `f_addIp` varchar(255) NOT NULL COMMENT '����IP',
              PRIMARY KEY  (`f_id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��¼����'
        ";
        app_db::query( $sql );
        $sql = "
            CREATE TABLE IF NOT EXISTS `tmp_hs_categories` (
              `f_id` int(10) NOT NULL auto_increment COMMENT '���',
              `f_sort` int(10) NOT NULL default '0' COMMENT '�źõ���˳��',
              `f_parentId` int(10) NOT NULL default '0' COMMENT '������',
              `f_haveChild` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ����ӷ���',
              `f_autoList` tinyint(1) NOT NULL default '1' COMMENT '�Ƿ��Զ��г�',
              `f_indent` tinyint(1) NOT NULL default '1' COMMENT '����',
              `f_order` int(10) NOT NULL default '1000' COMMENT '˳��ԽСԽ��ǰ',
              `f_name` varchar(255) NOT NULL COMMENT '����',
              `f_englishName` varchar(255) default NULL COMMENT 'Ӣ������������ַ�ļ���',
              `f_url` varchar(255) default NULL COMMENT '��ַ',
              `f_keywords` varchar(255) default NULL COMMENT '�ؼ���',
              `f_description` text COMMENT '����',
              PRIMARY KEY  (`f_id`),
              KEY `f_parentId` (`f_parentId`,`f_indent`,`f_order`),
              KEY `f_sort` (`f_sort`),
              KEY `f_autoList` (`f_autoList`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����'
        ";
        app_db::query( $sql );
        $sql = "
            CREATE TABLE IF NOT EXISTS `tmp_hs_sites` (
              `f_id` int(10) NOT NULL auto_increment COMMENT '���',
              `f_categoryId` int(10) NOT NULL COMMENT '������',
              `f_expireTime` int(10) NOT NULL default '0' COMMENT '����ʱ��',
              `f_isRecommend` tinyint(1) NOT NULL default '0' COMMENT '�Ƽ�',
              `f_order` int(10) NOT NULL default '1000' COMMENT '˳��ԽСԽ��ǰ',
              `f_name` varchar(255) NOT NULL COMMENT '����',
              `f_url` varchar(255) NOT NULL COMMENT '��ַ',
              `f_color` varchar(7) default NULL COMMENT '��ɫ',
              `f_description` text COMMENT '˵��',
              `f_clickScore` int(10) NOT NULL default '0' COMMENT '��������',
              `f_clickIn` int(10) NOT NULL default '0' COMMENT '������',
              `f_clickOut` int(10) NOT NULL default '0' COMMENT '�����',
              PRIMARY KEY  (`f_id`),
              KEY `f_categoryId` (`f_categoryId`),
              KEY `f_expireTime` (`f_expireTime`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ַ'
            ";
        app_db::query( $sql );
    }

    public static function data_import( $sql_file )
    {
        if (!file_exists($sql_file))
        {
            return false;
        }

        $lines = file($sql_file);
        if (empty($lines))
        {
            return false;
        }

        // ������
        self::create_table();

        foreach ($lines as $key => $row)
        {
            $row = trim($row);
            if (empty($row) || preg_match('#^((--)|\#|(/\*))#', $row))
            {
                continue;
            }
            if ( !preg_match('/`.*?_applies` | `.*?_sites` | `.*?_categories`/', $row) )
            {
                continue;
            }
            $row = iconv('UTF-8', 'GBK', $row);

            $sql = '';
            if (!preg_match('#;$#', $row))
            {
                $sql .= $row;
                continue;
            }
            else
            {
                $sql = $row;
            }

            $sql = preg_replace('#^REPLACE INTO `.*?_([^_]*?)` VALUES#i', 'REPLACE INTO `tmp_hs_$1` VALUES', $sql);
            app_db::query($sql);
        }
        return true;
    }

    public static function data_move()
    {
        self::addurl_move();
        self::mingzhan_move();
        self::indextool_move();
        self::zhuanti_move();
        self::sites_move();
        self::indexsite_move();
    }


    /**
     * ����������������
     */
    public static function addurl_move()
    {
        $mysites_urladd_tbl = 'tmp_hs_applies';
        $ylmf_urladd_tbl = 'ylmf_urladd';

        $mysites_result = app_db::select( $mysites_urladd_tbl, '*', "1");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            $info = array(
                'name' => $mysites_rs['f_name'],
                'siteurl' => $mysites_rs['f_url'],
                'jianjie' => $mysites_rs['f_description'],
                'fav' => '',
                'pv' => $mysites_rs['f_ips'],
                'class' => $mysites_rs['f_category'],
                'icp' => '',
                'sitetime' => $mysites_rs['f_buildTime'],
                'lianxiren' => $mysites_rs['f_contact'],
                'address' => '',
                'qq' => $mysites_rs['f_qq'],
                'mobile' => '',
                'tel' => $mysites_rs['f_tel'],
                'email' => '',
                'sharelink' => $mysites_rs['f_linked'],
                'action' => 'add'
                );
            $ylmf_sql = "insert into " . $ylmf_urladd_tbl . " set domain='" . $mysites_rs['f_url'] . "', info='" . serialize( $info ) . "', addtime='" . $_SERVER['REQUEST_TIME'] . "', type=0, shenhe=''";
            app_db::query( $ylmf_sql );
            }
    }

    /**
     * ������վ��������
     */
    public static function mingzhan_move()
    {
        $mysites_mingzhan_tbl = 'tmp_hs_sites';
        $ylmf_mingzhan_tbl = 'ylmf_mingzhan';

        app_db::query( "truncate  " . $ylmf_mingzhan_tbl );
        $mysites_result = app_db::select( $mysites_mingzhan_tbl, '*', "f_categoryId=775");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            $ylmf_sql = "insert into " . $ylmf_mingzhan_tbl . " set name='" . $mysites_rs['f_name'] . "', url='" . $mysites_rs['f_url'] . "',  namecolor='" . $mysites_rs['f_color'] . "', displayorder='" . $mysites_rs['f_order'] . "',  endtime='" . intval($mysites_rs['f_expireTime']) . "', remark='" . $mysites_rs['f_description'] . "', total='" . $mysites_rs['f_clickOut'] . "'";
            app_db::query( $ylmf_sql );
        }

        app_db::delete($mysites_mingzhan_tbl, "f_categoryId=775" );
    }

    /**
     * ������ҳ��������
     */
    public static function indextool_move()
    {
        $mysites_indextool_tbl = 'tmp_hs_sites';
        $indextool = array();
        $mysites_result = app_db::select( $mysites_indextool_tbl, '*', "f_categoryId=776");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            $indextool['name'][] = $mysites_rs['f_name'];
            $indextool['url'][] = $mysites_rs['f_url'];
            $indextool['color'][] = $mysites_rs['f_color'];
        }
        $filename = PATH_DATA . '/db/index_tool.php';
        $output = "<?php\n\$_DB['index_tool'] = '" . serialize( $indextool ) . "';\n?>";
        file_put_contents($filename, $output);
        @chmod($filename, 0777);
        app_db::delete($mysites_indextool_tbl, "f_categoryId=776" );
    }


    /**
     * ����ר������
     */
    public static function zhuanti_move()
    {
        $mysites_zhuanti_class_tbl = 'tmp_hs_categories';
        $ylmf_zhuanti_class_tbl = 'ylmf_toolclass';

        $mysites_zhuanti_tbl = 'tmp_hs_sites';
        $ylmf_zhuanti_tbl = 'ylmf_tool';

        //���ԭ�����վ������
        app_db::query( "truncate  " . $ylmf_zhuanti_class_tbl );
        app_db::query( "truncate  " . $ylmf_zhuanti_tbl );

        $mysites_result = app_db::select( $mysites_zhuanti_class_tbl, '*', "f_parentId in (7, 8)");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            $class = array( 7 => 'game', 8 => 'game1' );
            //�������
            $ylmf_sql = "insert into " . $ylmf_zhuanti_class_tbl . " set name='" . $mysites_rs['f_name'] . "', displayorder='" . $mysites_rs['f_sort'] . "', type='" . $class[$mysites_rs['f_parentId']] . "', inindex='" . $mysites_rs['f_autoList'] . "'";
            app_db::query( $ylmf_sql );
            $class_id = app_db::insert_id();

            //����վ��
            $mysites_site_result = app_db::select( $mysites_zhuanti_tbl, '*', "f_categoryId='" . $mysites_rs['f_id'] . "'" );
            foreach( $mysites_site_result as $mysites_site_rs )
            {
                $ylmf_sql = "insert into " . $ylmf_zhuanti_tbl . " set name='" . $mysites_site_rs['f_name'] . "', class='" . $class_id . "', url='" . $mysites_site_rs['f_url'] . "', displayorder='" . $mysites_site_rs['f_order'] . "', total='" . $mysites_site_rs['f_clickOut'] . "', remark='" . $mysites_site_rs['f_description'] . "', endtime='" . intval($mysites_site_rs['f_expireTime']) . "', namecolor='" . $mysites_site_rs['f_color'] . "'";
                app_db::query( $ylmf_sql );
            }
        }
        app_db::delete($mysites_zhuanti_class_tbl, "f_parentId in (7,8)" );
    }//end function zhuanti_move()


    /**
     * �������վ������
     */
    public static function sites_move()
    {
        $mysites_class_tbl = 'tmp_hs_categories';
        $ylmf_class_tbl = 'ylmf_class';

        $mysites_site_tbl = 'tmp_hs_sites';
        $ylmf_site_tbl = 'ylmf_site';

        //���ԭ�����վ������
        app_db::query( "truncate  " . $ylmf_class_tbl );
        app_db::query( "truncate  " . $ylmf_site_tbl );

        $mysites_result = app_db::select( $mysites_class_tbl, '*', "f_parentId<>778");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            //�������
            $ylmf_sql = "insert into " . $ylmf_class_tbl . " set classid='" . $mysites_rs['f_id'] . "', classname='" . $mysites_rs['f_name'] . "', displayorder='" . $mysites_rs['f_sort'] . "', parentid='" . $mysites_rs['f_parentId'] . "', inindex='0', path='" . $mysites_rs['f_url']  . "', indexdisplayorder='" . $mysites_rs['f_order'] . "', keywords='" . $mysites_rs['f_keywords'] . "',description='" . $mysites_rs['f_description'] . "'";
            app_db::query( $ylmf_sql );
            $class_id = app_db::insert_id();

            //����վ��
            $mysites_site_result = app_db::select( $mysites_site_tbl, '*', "f_categoryId='" . $mysites_rs['f_id'] ."'" );
            if( !$mysites_site_result )
            {
                continue;
            }
            foreach( $mysites_site_result as $mysites_site_rs )
            {
                foreach( $mysites_site_rs as $key => $value )
                {
                    $mysites_site_rs[$key] = mysql_real_escape_string( $value );
                }
                $ylmf_sql = "insert into " . $ylmf_site_tbl . " set name='" . $mysites_site_rs['f_name'] . "', class='" . $class_id . "', url='" . $mysites_site_rs['f_url'] . "', displayorder='" . $mysites_site_rs['f_order'] . "', total='" . $mysites_site_rs['f_clickOut'] . "', remark='" . $mysites_site_rs['f_description'] . "', endtime='" . intval($mysites_site_rs['f_expireTime']) . "', namecolor='" . $mysites_site_rs['f_color'] . "'";
                app_db::query( $ylmf_sql );
            }
        }
    }//end function sites_move()

    /**
     * �����վ����
     */
    public static function indexsite_move()
    {
        $mysites_class_tbl = 'tmp_hs_categories';
        $ylmf_class_tbl = 'ylmf_class';

        $mysites_site_tbl = 'tmp_hs_sites';
        $ylmf_site_tbl = 'ylmf_indexsite';

        $mysites_result = app_db::select( $mysites_class_tbl, '*', "f_parentId=778");
        if( !$mysites_result )
        {
            return false;
        }
        foreach( $mysites_result as $mysites_rs )
        {
            //����վ��
            preg_match( '/.*(?)\/(\d+)\.html.*/', $mysites_rs['f_url'], $match);
            $class_id = $match[1];
            
            $ylmf_sql = "update " . $ylmf_class_tbl . " set indexname='" . $mysites_rs['f_name'] . "', inindex='1' where classid='" . $class_id . "'";
            app_db::query( $ylmf_sql );

            $mysites_site_result = app_db::select( $mysites_site_tbl, '*', "f_categoryId='" . $mysites_rs['f_id']. "'" );
            if( !$mysites_site_result )
            {
                continue;
            }
            foreach( $mysites_site_result as $mysites_site_rs )
            {
                foreach( $mysites_site_rs as $key => $value )
                {
                    $mysites_site_rs[$key] = mysql_real_escape_string( $value );
                }
                $ylmf_sql = "insert into " . $ylmf_site_tbl . " set name='" . $mysites_site_rs['f_name'] . "', class='" . $class_id . "', url='" . $mysites_site_rs['f_url'] . "', displayorder='" . $mysites_site_rs['f_order'] . "', total='" . $mysites_site_rs['f_clickOut'] . "', remark='" . $mysites_site_rs['f_description'] . "', endtime='" . intval($mysites_site_rs['f_expireTime']) . "', namecolor='" . $mysites_site_rs['f_color'] . "'";
                app_db::query( $ylmf_sql );
            }
        }
    }

    /**
     * ������ʱ����
     */
    public static function clean_up()
    {
        app_db::query( 'drop table `tmp_hs_applies`');
        app_db::query( 'drop table `tmp_hs_categories`');
        app_db::query( 'drop table `tmp_hs_sites`');
        mod_class::delete_class( 777 );
        mod_class::delete_class( 1000 );
        mod_class::delete_class( 1069 );
    }
}
?>

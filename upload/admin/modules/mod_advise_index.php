<?php
/**
 * ��ҳ���
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_advise_index
{
    public static function advise_index_list()
    {
        $add_sql='';
        if(!empty($_REQUEST['action']))
        {
            $add_sql=" and varname='{$_REQUEST['action']}'";
        }
        app_db::query("SELECT id,varname,state,vieworder,title,config,`day`,`week`,`month`,`total` FROM  ylmf_advert where 1 $add_sql  ORDER BY varname,vieworder");
        while($rt=app_db::fetch_one())
        {
            $config = unserialize($rt['config']);
            $rt['adtitle']	 = @$config['title'];
            $rt['starttime'] = @$config['starttime'];
            $rt['endtime']	 = @$config['endtime'];
            switch ($rt['varname'])
            {
                case 'header':
                    $rt['varname']='�������';
                    break;
                    case 'footer':
                    $rt['varname']='��վ�Ϸ��Ƽ���';
                    break;
                    case 'notice':
                    $rt['varname']='��վ�·��Ƽ���';
                    break;
            }
            $moduledb[]=$rt;
        }
        return $moduledb;
    }

    /**
     * ���
     * @param <array> $data  ��ӵ�POST����
     */
    public static function advise_index_add($data)
    {
$step=(empty($data['step']))?'':$data['step'];
        if($step!=2)
        {
//            $timestamp=time();
//            $style='code';
//            $selids_01 = 'checked';
//            $config['starttime'] = get_date($timestamp,'Y-m-d');
//            $config['endtime']	 = get_date($timestamp+31536000,'Y-m-d');//Ĭ�ϼ���ʱ��~~
        }
        elseif($data['step']=='2')
        {
            if(empty($data['varname']))
            {
                throw new Exception("����ʶ������Ϊ��");
            }
            if(empty($data['title']))
            {
                throw new Exception("�����������Ϊ��");//�ȴ����.�޸�..
            }
            if(empty($data['config']['style']))
            {
                throw new Exception("��ѡ��չʾ��ʽ");
            }
            elseif(@$data['config']['style'] == 'code' && empty($data['config']['htmlcode']))
            {
                throw new Exception("���������ݲ���Ϊ��");
            }elseif(@$data['config']['style'] == 'txt' && (empty($data['config']['title']) || empty($data['config']['link'])))
            {
                throw new Exception("���ֱ�������Ӳ���Ϊ��");
            }elseif(@$data['config']['style'] == 'img' && (empty($data['config']['url']) || empty($data['config']['link'])))
            {
                throw new Exception("ͼƬ��ַ��ͼƬ���Ӳ���Ϊ��");
            }elseif(@$data['config']['style'] == 'flash' && empty($data['config']['link']))
            {
                throw new Exception("Flash��ַ����Ϊ��");
            }
            @$module['descrip'] = str_replace("\n",'<br />',$module['descrip']);
            foreach($data['config'] as $ks=>$vs)
            {
                $data['config'][$ks]=stripslashes($vs);
            }
            $config = addslashes(serialize($data['config']));   
            app_db::query("INSERT INTO ylmf_advert(varname,state,vieworder,title,config) VALUES('{$data['varname']}','1',
'{$data['vieworder']}','{$data['title']}','{$config}')");
            mod_advert::update_cache_main_advert();
            return true;
        }
    }

    /**
     * ɾ�����
     * @param <array> $data
     */
    public static function advise_index_delete($selid)
    {
        if(!is_array($selid))
        {
            throw new Exception("��ѡ��Ҫɾ��������.");
        }
        elseif(count($selid)<1)
        {
            throw new Exception("��ѡ��Ҫɾ��������.");
        }
        if($selid = checkselid($selid))
        {
            app_db::query("DELETE FROM ylmf_advert WHERE  id IN($selid)");
        }
        mod_advert::update_cache_main_advert();
        return true;
    }

    /**
     * ��ʾ���
     * @param <array> $data
     */
    public static function advise_index_display($applyid,$select_id_all)
    {
        $arr_applyid=$applyid;
        $arr_no_it=$select_id_all;
        if(!is_array($applyid))
        {
            throw new Exception("��ѡ��Ҫ���õ�����.");
        }

        //app_db::query("UPDATE ylmf_advert SET state=0 ");  ��ȡ�����ֶ�..
        $applyid = checkselid($applyid);
        $no_applyid=null;
        foreach($arr_no_it as $val)
        {
            if(!in_array($val, $arr_applyid))
            {
                $no_applyid.=(is_null($no_applyid))?$val:','.$val;
            }
        }
        if(strlen($applyid)>1)
        {
            app_db::query("UPDATE ylmf_advert SET state=1 WHERE id IN($applyid)");
        }
        if(strlen($no_applyid)>1)
        {
            app_db::query("UPDATE ylmf_advert SET state=0 WHERE id IN($no_applyid)");
        }
        mod_advert::update_cache_main_advert();
        return true;
    }

    /**
     * ��������
     * @param <array> $data
     */
    public static function advise_index_save($data,$type='select')
    {
        $data['step']=(empty($data['step']))?0:$data['step'];
        if ($data['step']=='2' && $type=='save')
        {
            if(empty($data['varname']))
            {
                throw new Exception("����ʶ������Ϊ��");
            }
            if(empty($data['title']))
            {
                throw new Exception("�����������Ϊ��");//�ȴ����.�޸�..
            }
            if(empty($data['config']['style']))
            {
                throw new Exception("��ѡ��չʾ��ʽ");
            }
            elseif(@$data['config']['style'] == 'code' && empty($data['config']['htmlcode']))
            {
                throw new Exception("���������ݲ���Ϊ��");
            }elseif(@$data['config']['style'] == 'txt' && (empty($data['config']['title']) || empty($data['config']['link'])))
            {
                throw new Exception("���ֱ�������Ӳ���Ϊ��");
            }elseif(@$data['config']['style'] == 'img' && (empty($data['config']['url']) || empty($data['config']['link'])))
            {
                throw new Exception("ͼƬ��ַ��ͼƬ���Ӳ���Ϊ��");
            }elseif(@$data['config']['style'] == 'flash' && empty($data['config']['link']))
            {
                throw new Exception("Flash��ַ����Ϊ��");
            }
            @$module['descrip'] = str_replace("\n",'<br />',$module['descrip']);            
            foreach($data['config'] as $ks=>$vs)
            {
                $data['config'][$ks]=stripslashes($vs);
            }
            $config = addslashes(serialize($data['config']));           
            app_db::query("UPDATE ylmf_advert SET varname='{$data['varname']}',vieworder='{$data['vieworder']}',
title='{$data['title']}',config='$config' WHERE id='{$data['id']}'");
            mod_advert::update_cache_main_advert();
            return true;
        }
        elseif($type=='select')
        {
            app_db::query("SELECT * FROM ylmf_advert WHERE id='{$data['id']}}'");
            $rt=app_db::fetch_one();
            if(!$rt)
            {
                throw new Exception("����Ϣ������.");
            }
            $config = unserialize($rt['config']);
            HtmlConvert($rt);
            HtmlConvert($config);   
            $rt['config']=$config;  //����html           
            return $rt;
        }
        else
        {
            throw new Exception("�Ƿ�����");
        }
    }

    public static function famous_nav_order($orderby)
    {
        if ($orderby)
        {
            foreach($orderby as $key =>$val)
            {
                $order=(int)$val;
                $id=intval($key);
                app_db::query("UPDATE ylmf_mingzhan SET displayorder='$order' WHERE id=$key");
            }
        }
    }




}
?>

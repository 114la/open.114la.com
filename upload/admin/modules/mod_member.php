<?php
/*
 * ����Ա��ز���
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_member
{
/**
 * �б�
 * @return <type>
 */
    public static function member_list()
    {
        $data=app_db::query("select name,level,lastvisit,lastip from ylmf_admin_user");
        $userlistdb=array();
        $userlistdb=array();
        while ($userlist=app_db::fetch_one())
        {
            $userlist['levelshow']=$userlist['level']==1?'��������Ա':'��ͨ����Ա';
            $userlistdb[]= $userlist;
//            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
//            $num = (empty($_GET['num'])) ? 20 : (int)$_GET['num'];
        }
        return $userlistdb;
    }

    /**
     * �༭��Ϣ
     * @param <type> $id
     */
    public static function member_edit($name)
    {
        if(empty($name))
        {
            throw new Exception("��������Ϊ��");
        }
        app_db::query("select * from ylmf_admin_user where name='{$name}' limit 1");
        return app_db::fetch_one();
    }

    /**
     * ����༭��Ϣ
     * @param <type> $name
     * @param <type> $auth_info
     */
    public static function member_save($name,$password,$rightdb)
    {
        app_db::query("SELECT name,adminright FROM ylmf_admin_user WHERE name='$name' AND level='0'  ");
        $how=app_db::num_rows();
        if($how==0)
        {
            throw new Exception("û������û�.");//�༭��������Ա,Ҳ����ʾ�Ĵ���.
        }
        $sqladd='';
        if ($password!='')
        {
            if(strlen($password)<6)
            {
                throw new Exception("���볤�Ȳ���,����6λ.");
            }
            $S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
            foreach($S_key as $value)
            {
                if (strpos($password,$value)!==false)
                {
                    throw new Exception("���벻�ܰ��������ַ�.");
                }
            }
            $password=md5($password);
            $sqladd.=", password='$password' ";
        }
        $rightdb=self::P_serialize($rightdb);
        app_db::query("UPDATE ylmf_admin_user SET adminright='$rightdb' $sqladd WHERE name='$name'");
        return true;
    }



    /**
     * �޸�����
     * @param <type> $name
     * @param <type> $password
     * @param <type> $type
     * @return <type>  2:��������Ա
     */
    public static function member_password($name,$password,$type=1)
    {
        $sql_add='';
        if($type==1)$sql_add=" AND level='0' ";
        if(USERNAME==$name)
        {
            $oldpassword=(empty($_POST['oldpassword']))?'':$_POST['oldpassword'];
            if(empty($oldpassword))
            {
                throw new Exception("������ԭʼ����.");
            }
            $oldpassword=md5($oldpassword);
            app_db::query("SELECT name,adminright FROM ylmf_admin_user WHERE name='$name' and password='$oldpassword' $sql_add  ");
            $how=app_db::num_rows();
            if($how==0)
            {
                throw new Exception("ԭʼ���벻��ȷ.");
            }
            //�޸��Լ�����
        }
        app_db::query("SELECT name,adminright FROM ylmf_admin_user WHERE name='$name' $sql_add  ");
        $how=app_db::num_rows();
        if($how==0)
        {
            throw new Exception("û������û�.");
        }
        
        
        if ($password!='')
        {
            if(strlen($password)<6)
            {
                throw new Exception("���볤�Ȳ���,����6λ.");
            }
            $S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
            foreach($S_key as $value)
            {
                if (strpos($password,$value)!==false)
                {
                    throw new Exception("���벻�ܰ��������ַ�.");
                }
            }
            $password=md5($password);
            app_db::query("UPDATE ylmf_admin_user SET password='$password' WHERE name='$name'");
            return true;
        }
        else
        {
            throw new Exception("������������.");
        }
    }
    /**
     * ����û�
     * @param <type> $name
     * @param <type> $password
     */
    public static function member_add($name,$password)
    {
        $name=trim($name);
        $password=trim($password);
        if(empty($name))
        {
            throw new Exception("�������û���.");
        }
        if(empty($password))
        {
            throw new Exception("����������.");
        }
        $S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
        foreach($S_key as $value)
        {
            if (strpos($name,$value)!==false)
            {
                throw new Exception("�û������зǷ��ַ�.");
            }

        }
        $data=app_db::query("SELECT count(*) AS sum FROM ylmf_admin_user WHERE name='$name' ");
        $rs=app_db::fetch_one();
        if ($rs['sum']>0)
        {
            throw new Exception("���û�������,�����������û���.");
        }
        $S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');// ������
        if(strlen($password)<6)
        {
            throw new Exception("���볤�Ȳ���,����6λ.");
        }
        foreach($S_key as $value)
        {
            if (strpos($password,$value)!==false)
            {
                throw new Exception("���벻�ܰ��������ַ�.");
            }
        }
        $password=md5($password);
        app_db::query("INSERT INTO ylmf_admin_user (name,password,level)VALUES('$name','$password','0') ");
        $userid=app_db::insert_id();
        //ʹ��message��ת
        return $name;
    }

    /**
     * ɾ��
     * @param <type> $name
     * @return <type>
     */
    public static function member_delete($name)
    {
        if(is_array($name))
        {
            $name=implode('\',\'',$name);
        }
        if(strlen($name)<2)
        {
            throw new Exception("û��ѡ���û�");
        }
        app_db::query("DELETE FROM ylmf_admin_user WHERE name in('$name') AND level='0' ");
        return true;
    }

    /**
     * ����Ȩ�޺���
     * @param <type> $array
     * @param <type> $ret
     * @param <type> $i
     * @return <type>
     */
    function P_serialize($array, $ret = '', $i = 1)
    {
        if(!is_array($array))
        {
            return null;
        }
        foreach($array as $k => $v)
        {
            if (is_array($v))
            {
                $next = $i + 1;
                $ret .= "$k\t";
                $ret = P_serialize($v, $ret, $next);
                $ret .= "\n$i\n";
            }
            else
            {
                $ret .= "$k\t$v\n$i\n";
            }
        }
        if (substr($ret, -3) == "\n$i\n")
        {
            $ret = substr($ret, 0, -3);
        }
        return $ret;
    }

    /**
     * ������,����������
     * @param <type> $str
     * @param <type> $array
     * @param <type> $i
     * @return <type>
     */
    function P_unserialize($str, $array = array(), $i = 1)
    {
        $str = explode("\n$i\n", $str);
        foreach ($str as $key => $value)
        {
            $k = substr($value, 0, strpos($value, "\t"));
            $v = substr($value, strpos($value, "\t") + 1);
            if (strpos($v, "\n") !== false)
            {
                $next = $i + 1;
                $array[$k] = P_unserialize($v, $array[$k], $next);
            } elseif (strpos($v, "\t") !== false)
            {
                $array[$k] = P_array($array[$k], $v);
            }
            else
            {
                $array[$k] = $v;
            }
        }
        return $array;
    }


    




}

?>

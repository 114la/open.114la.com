<?php
/**
 * 日志处理类
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_log
{

    public static function log_admin($type='admin')
    {
        $page=(empty($_GET['page']))?'':$_GET['page'];
        $search=(empty($_GET['search']))?'':$_GET['search'];//附加url  default: yes
        $keyword=(empty($_GET['keyword']))?'':$_GET['keyword'];
        $numofpage=$delete_filename=$url_add='';
        switch ($type)
        {
            case 'admin':
                $url_add='&a=log_admin';
                $delete_filename='admin_log.php';
                break;

            case 'php':
                $url_add='&a=log_php';
                $delete_filename='php_error.log';
                break;

            case 'mysql':
                $url_add='&a=log_mysql';
                $delete_filename='mysql_error.php';
                break;
        }
        //以上定义初始化
        $basename="?c=log".$url_add;
        $codename='后台日志管理';
        $adminlogfile=PATH_ADMIN."/data/log/".$delete_filename;
        if(file_exists($adminlogfile))
        {
            $logfiledata=readlog($adminlogfile);
        }
        else
        {
            $logfiledata=array();
        }

        $logfiledata=array_reverse($logfiledata);
        $count=count($logfiledata);
        $yl_perpage=50;//定义每页显示数目
        (!is_numeric($page) || $page < 1) && $page=1;
        if ($count%$yl_perpage==0)
        {
            $numofpage=floor($count/$yl_perpage);
        }
        else
        {
            $numofpage=floor($count/$yl_perpage)+1;
        }
        if ($page>$numofpage)
        {
            $page=$numofpage;
        }
        $pagemin=min(($page-1)*$yl_perpage , $count-1);
        $pagemax=min($pagemin+$yl_perpage-1, $count-1);
        $adlogfor='';

        if($search=='yes')//search
        
        {
            switch ($type)
            {
                case 'admin':
                    if(!$keyword)
                    {
                        throw new Exception("查询条件不能为空");
                    }
                    $num=0;
                    $start=($page-1)*$yl_perpage;
                    foreach($logfiledata as $value)
                    {
                        if(strpos($value,$keyword)!==false)
                        {
                            if($num >= $start && $num < $start+$yl_perpage)
                            {
                                $detail=explode("|",$value);
                                $winddate=date('Y-m-d h:i:s', $detail[5]);
                                $detail[2] && !If_manager && $detail[2]=substr_replace($detail[2],'***',1,-1);
                                $detail[6]=htmlspecialchars($detail[6]);
                                $adlogfor.="
<tr class=b align='center'>
	<td>$detail[1]></td>
	<td>$detail[2]</td>
	<td class='smalltxt'>$detail[3]</td>
	<td>$winddate   </td>
	<td class='smalltxt'>$detail[4]</td>
	<td class='smalltxt'>$detail[6]</td>
</tr>";
                            }
                            $num++;
                        }
                    }
                    $numofpage=ceil($num/$yl_perpage);
                    $pages=self::numofpage($num,$page,$numofpage,$basename."&search=yes&keyword=".rawurlencode($keyword)."&");
                    break;

                case 'php':
                    throw new Exception("PHP日志暂无查询功能");
                    break;

                case 'mysql':
                    if(!$keyword)
                    {
                        throw new Exception("查询条件不能为空");
                    }
                    $num = 0;
                    $start = ($page-1) * $yl_perpage;
                    foreach($logfiledata as $value)
                    {
                        if(strpos($value, $keyword) !== false)
                        {
                            if($num >= $start && $num < $start + $yl_perpage)
                            {
                                $detail = explode("|", $value);
                                $winddate = get_date($detail[5]);
                                $detail[2] && !If_manager && $detail[2] = substr_replace($detail[2], '***', 1, -1);
                                $detail[6] = htmlspecialchars($detail[6]);
                                $adlogfor .= "
<tr class=b align='center'>
	<td>$detail[1]</td>
	<td>$detail[2]</td>
	<td class='smalltxt'>$detail[3]</td>
	<td>$detail[4]</td>
	<td class='smalltxt'>$winddate</td>
	<td class='smalltxt'>$detail[6]</td>
</tr>";
                            }
                            $num++;
                        }
                    }
                    $numofpage = ceil($num / $yl_perpage);
                    $pages = self::numofpage($num, $page, $numofpage, $basename."&search=yes&keyword=".rawurlencode($keyword)."&");
                    break;
            }


        }
        else//get list

        {
            $pages=self::numofpage($count,$page,$numofpage,$basename);
            switch ($type)
            {
                case 'admin':
                    for($i=$pagemin; $i<=$pagemax; $i++)
                    {
                        $detail=explode("|",$logfiledata[$i]);
                        @$detail[1]=@$detail[1];
                        @$detail[2]=substr(@$detail[2], 0, 40);
                        @$detail[3]=@$detail[3];
                        @$detail[4]=@$detail[4];
                        @$detail[5]=@$detail[5];
                        $winddate=date('Y-m-d h:i:s', $detail[4]);
                        $detail[5]=htmlspecialchars($detail[5]);
                        $adlogfor.="
<tr class=b align='center'>
	<td>$detail[1]</td>
	<td><div stle='width:300px;' class='hideText'>$detail[2]</div></td>
	<td><div stle='width:300px;' class='hideText'>$winddate</div></td>
	<td class='smalltxt'><div stle='width:200px;' class='hideText'>$detail[3]</div></td>
    <td class='smalltxt'>$detail[5]</td>
</tr>";
                    }
                    break;

                case 'php':
//                    $adlogfor = ''; die; //日志 暂无..解析出问题.
                    $phplogfiledata=array();
                    if(file_exists($adminlogfile))
                    {
                        $phplogfiledata=self::readphplog($adminlogfile);// 获取错误日志 返回一个数组 $phplogfiledata


                    //                        unset($phplogfiledata[0]);
                    }
                    if($phplogfiledata)
                    {
                        $tmppath=str_replace('/','\\',PATH_ADMIN);
                        for($i=$pagemin; $i<=$pagemax; $i++)
                        {
                            $tmp=explode(" in ",$phplogfiledata[$i]); // tmp line1
                            $localfile=@explode(" on line ",$tmp[1]);  //  tmp line2
                            
                            if //(preg_match("/^\[([0-9]+\-[A-za-z]+\-[0-9]+\s[0-9]+:[0-9]+:[0-9]+)\]\sPHP\s(Warning|Fatal\serror)\:\s\s(.+)\sin\s([0-9a-zA-Z_\-\/\\\\]+)[\/\\\\]([0-9A-Za-z_\-]+)\.(php|htm)\son\sline\s([0-9]+)/", $phplogfiledata[$i], $matches)){
                            (preg_match("/^\[([0-9]+\-[A-za-z]+\-[0-9]+\s[0-9]+:[0-9]+:[0-9]+)\]\sPHP\s(Warning|Parse\serror|Fatal\serror)\:\s\s(.+)/", $tmp[0], $matches))
                            {

                                $winddate = $matches[1];
                                $error_type = $matches[2];
                                //$message = trim($matches[4]);
                                //preg_match("/(.+)in\s([0-9A-Za-z_-]+\.php)\son\sline\s([0-9]+)$/", trim($matches[3]), $err_arr);
                                if ($error_type == "Warning")
                                {
                                    $error_number = "WARNING";
                                }elseif ($error_type == "Fatal error" || $error_type == "Parse error")
                                {
                                    $error_number = "<b><font color=red>E_FATAL</font></b>";
                                }

                                $localfile[0]=str_replace($tmppath,'/',$localfile[0]);
                                $localfile[0]=str_replace('\\','/',$localfile[0]);
                                $adlogfor.="<tr class=b align='left'><TD class='smalltxt'>$error_number</TD>
<TD class='smalltxt' >$winddate</TD><TD class='smalltxt'>$matches[3]</TD>
<TD  class='smalltxt'>$localfile[0]</TD>
<TD class='smalltxt'>$localfile[1]</TD></tr>";
                            }

                        }
                       
                    }
                    break;

                case 'mysql':
                    for($i = $pagemin; $i <= $pagemax; $i++)
                    {
                        $detail = explode("|", $logfiledata[$i]);
                        $winddate = get_date($detail[5],"Y-m-d h:i:s");
                        $detail[7] = htmlspecialchars($detail[7]);
                        $adlogfor .= "
<tr class=b align='center'>
	<td >$detail[1]</td>
	<td class='smalltxt'>$detail[2]</td>
	<td class='smalltxt'>$detail[3]</td>
	<td class='smalltxt'>$detail[4]</td>
	<td class='smalltxt'>$winddate</td>
	<td class='smalltxt'>$detail[6]</td>

</tr>";
                    }
                    break;
            }

        }//this is for admin
       
       return array($adlogfor,$pages);

    }

    /**
     *
     * @param <type> $action
     * @param <type> $filename  公用的删除接口   admin / php / mysql
     * @return <type>
     */
    public static function log_admin_delete($action,$filename='admin')
    {
        $delete_file='';
        $delete_filename='';
        switch ($filename)
        {
            case 'admin':
                $delete_filename='admin_log.php';
                break;

            case 'php':
                $delete_filename='php_error.log';
                break;

            case 'mysql':
                $delete_filename='mysql_error.php';
                break;
        }
        if( 'yes'==$action and !empty($delete_filename) )
        {
        //PostCheck($verify); //取消判断
            if (1==If_manager)
            {
                $adminlogfile=PATH_ADMIN."/data/log/".$delete_filename;
                $logfiledata='';
                if(file_exists($adminlogfile))
                {
                    $logfiledata=readlog($adminlogfile);
                } else
                {
                    $logfiledata=array();
                }
                $logfiledata=array_reverse($logfiledata);
                $count=count($logfiledata);
                if($count>100)
                {
                    if(file_exists($adminlogfile))
                    {
                        $logfiledata=readlog($adminlogfile);
                    } else
                    {
                        $logfiledata=array();
                    }
                    $output=array_slice($logfiledata,0,100);
                    $output=array_reverse($output);
                    $output=implode("",$output);
                    writeover($adminlogfile,$output);
                    return true;
                }else
                {
                    throw new Exception("日志小于100条,无需删除.");
                }
            } else
            {
                throw new Exception("没有删除权限.");
            }
        }
        else
        {
            throw new Exception("删除参数错误.");
        }
    }

    /**
     * MYSQL日志列表
     */
    public static function log_mysql()
    {

    }

    /**
     * 删除mysql日志,保留100条.
     */
    public static function log_mysql_delete()
    {

    }

    /**
     * PHP日志列表
     */
    public static function log_php()
    {

    }

    /**
     * 删除php日志,保留100条.
     */
    public static function log_php_delete()
    {

    }


    public static function readphplog($filename,$offset=1024000)
    {
        $readb=array();
        if($fp=@fopen($filename,"rb"))
        {
            flock($fp,LOCK_SH);
            $size=filesize($filename);
            $size>$offset ? fseek($fp,-$offset,SEEK_END): $offset=$size;
            $readb=fread($fp,$offset);
            fclose($fp);
            //$readb=str_replace("\n","\n<:wind:>",$readb);
            $readb=explode("\n",$readb);
            //print_r($readb);
            $count=count($readb);
            if($readb[$count-1]==''||$readb[$count-1]=="\r")
            {unset($readb[$count-1]);}
            if(empty($readb))
            {$readb[0]="";}
        }
        return $readb;
    }

    public static function numofpage($count,$page,$numofpage,$url,$max=0)
    {
    //	global $tablecolor;
        $total=$numofpage;
        $max && $numofpage > $max && $numofpage=$max;
        if ($numofpage <= 1 || !is_numeric($page))
        {
            return ;
        }else
        {
            $pages="<a href=\"{$url}&page=1\"  class=\"nextprev\" >首页</a>";
            $flag=0;
            for($i=$page-5;$i<=$page-1;$i++)
            {
                if($i<1) continue;
                $pages.="<a href='{$url}&page=$i'>$i</a>";
            }
            $pages.="<span class=\"current\">$page</span>";
            if($page<$numofpage)
            {
                for($i=$page+1;$i<=$numofpage;$i++)
                {
                    $pages.="<a href='{$url}&page=$i'>$i</a>";
                    $flag++;
                    if($flag==5) break;
                }
            }
            $pages.="<a href=\"{$url}&page=$numofpage\" class=\"nextprev\">尾页</a>";
            //<input type='text' size='2' class='fenye' onkeydown=\"javascript: if(event.keyCode==13) location='{$url}&page='+this.value;\">
            return $pages;
        }
    }


    /**
     * MySQL 日志
     *
     * @param string $message
     * @param string $errno[optional]
     * @return void
     */
    public static function mysql_log($message, $sql_info='',$errno = 0)
    {
        $message = strtr($message, array($GLOBALS['database']['db_host'] => 'DB_HOST'));

        // mysql 日志记录 开始
        $_postdata	 = (!empty($_POST)) ? $_POST : 'NO_POSTDATA';
        $record_name = strtr(htmlspecialchars((defined('USERNAME')) && USERNAME , ENT_QUOTES), array('|' => '&#124;'));
        $record_URI = strtr(htmlspecialchars($_SERVER['PHP_SELF'] .'?' . $_SERVER['QUERY_STRING'], ENT_QUOTES), array('|' => '&#124;'));
        $timestamp = time();
        $onlineip = mod_defend::get_ip();
        $new_record = "<?die;?>|$record_name|$record_URI|$sql_info|{$errno}{$message}|$timestamp|$onlineip|$_postdata|\n";
        /*$new_record="<?die;?>|$record_name|$record_URI|$msg|$sqlerror|$timestamp|$onlineip|$_postdata|\n";*/
        $mysqllogfile = PATH_DATA . '/log/mysql_error.php';
        mod_file::write($mysqllogfile, $new_record, 'ab');
    }
}
?>

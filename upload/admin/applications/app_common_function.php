<?php
!defined('PATH_ADMIN') && exit('Forbidden');
/* 路径是否存在? */
function path_exists($path)
{
	$pathinfo = pathinfo ( $path . '/tmp.txt' );
	if (!empty($pathinfo ['dirname']))
	{
		if (file_exists( $pathinfo['dirname']) === false)
		{
			if (mkdir($pathinfo['dirname'], 0777, true) === false)
			{
				return false;
			}
		}
	}
	return $path;
}


/* 转义 */
function auto_addslashes(&$array)
{
	if ($array)
	{
		foreach ($array as $key => $value)
		{
			if (! is_array ( $value ))
			{
				$array [$key] = addslashes($value);
			}
			else
			{
				auto_addslashes($array [$key]);
			}
		}
	}
}


/* 反转义 */
function auto_stripslashes(&$array)
{
	if ($array)
	{
		foreach ($array as $key => $value)
		{
			if (!is_array($value))
			{
				$array[$key] = stripslashes($value);
			}
			else
			{
				auto_stripslashes($array[$key]);
			}
		}
	}
}


/**
 * 过滤字符串
 * 当 $editor 为 true 时，则不会转换 '<' 和 '>'
 *
 * @param $data data
 * @param $editor 是否使用了编辑器
 *
 */
function strip($data, $editor = false)
{
	$data = strtr($data, '`', '');

	if ($editor == true)
	{
		// 过滤 JavaScript
		$search = array ('#<script[^>]*?>.*?[</script>]*#si', '#<iframe[^>]*?>.*?[</iframe>]*#si', '#<input[^>]*?>#si', '#<button[^>]*?>.*?</button>#si', '#<form[^>]*?>#si', '#</form>#si',
		'#(<[\/\!]*?)?(\ class\=[\'|"].*?[\'|"])|(\ id\=[\'|"].*?[\'|"])([^<>]*?>)?#si');
		$replace = array('', '', '', '', '', '');
		$data = preg_replace($search, $replace, $data);
		if (get_magic_quotes_gpc())
		{
			$data = trim($data);
		}
		else
		{
			$data = addslashes(trim($data));
		}

	}
	else
	{
		if (get_magic_quotes_gpc())
		{
			$data = htmlspecialchars(trim(stripslashes($data)), ENT_QUOTES);
		}
		else
		{
			$data = htmlspecialchars(trim($data), ENT_QUOTES);
		}
	}
	return $data;
}


/*V1.11函数库
 *
 */
function Cookie($ck_Var,$ck_Value,$ck_Time='F'){
	global $cookietime;
	if($ck_Time=='F') $ck_Time = $cookietime;
	$S=$_SERVER['SERVER_PORT']=='443' ? 1:0;
	setCookie(CookiePre().'_'.$ck_Var,$ck_Value,$ck_Time,'/','',$S);
}
function GetCookie($Var){
	return $_COOKIE[CookiePre().'_'.$Var];
}
function CookiePre(){
	return substr(md5($GLOBALS['yl_hash']),0,5);
}
// addslashes 变量 可以是数组
function Add_S(&$array){
	if($array){
		foreach($array as $key=>$value){
			if(!is_array($value)){
				$array[$key]=addslashes($value);
			}else{
				Add_S($array[$key]);
			}
		}
	}
}
function HtmlConvert(&$array){
	if(is_array($array)){
		foreach($array as $key => $value){
			if(!is_array($value)){
				$array[$key]=htmlspecialchars($value);
			}else{
				HtmlConvert($array[$key]);
			}
		}
	} else{
		$array=htmlspecialchars($array);
	}
}
function substrs($content,$length,$yl_charset='gbk'){
	if($length && strlen($content)>$length){
		if($yl_charset!='utf-8'){
			$retstr='';
			for($i = 0; $i < $length - 2; $i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr.' ..';
		}else{
			return utf8_trim(substr($content,0,$length)).' ..';
		}
	}
	return $content;
}
function utf8_trim($str) {
	$len = strlen($str);
	for($i=strlen($str)-1;$i>=0;$i-=1){
		$hex .= ' '.ord($str[$i]);
		$ch   = ord($str[$i]);
		if(($ch & 128)==0)  return substr($str,0,$i);
		if(($ch & 192)==192)return substr($str,0,$i);
	}
	return($str.$hex);
}


function PwdCode($pwd){
	return md5($_SERVER["HTTP_USER_AGENT"].$pwd.$GLOBALS['yl_hash']);
}
function SafeCheck($CK,$PwdCode,$var='YlmfAdminUser',$expire=1800){// 验证密码
	global $timestamp;
	$t  = $timestamp - $CK[0];
	if($t > $expire || $CK[2] != md5($PwdCode.$CK[0])){
		Cookie($var,'',0);
		return false;
	}else{
		$CK[0] = $timestamp;
		$CK[2] = md5($PwdCode.$timestamp);
		$Value = implode("\t",$CK);
		$$var  = StrCode($Value);
		Cookie($var,StrCode($Value));
		return true;
	}
}
function StrCode($string,$action='ENCODE'){
	$key    = substr(md5($_SERVER["HTTP_USER_AGENT"].$GLOBALS['yl_hash']),8,18);
	$string = $action == 'ENCODE' ? $string : base64_decode($string);
	$len    = strlen($key);
	$code   = '';
	for($i=0; $i<strlen($string); $i++){
		$k      = $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}
function gets($filename,$value)
{
	if($handle=@fopen($filename,"rb")){
		flock($handle,LOCK_SH);
		$getcontent=fread($handle,$value);//fgets调试
		fclose($handle);
	}
	return $getcontent;
}
function P_unlink($filename){
	strpos($filename,'..')!==false && exit('Forbidden');
	return @unlink($filename);
}
function readover($filename,$method="rb"){
	strpos($filename,'..')!==false && exit('Forbidden');
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=@fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}
function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'..')!==false && exit('Forbidden');
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}
function openfile($filename,$style='Y')
{
	if($style=='Y'){
		$filedata=readover($filename);
		$filedata=str_replace("\n","\n<:wind:>",$filedata);
		$filedb=explode("<:wind:>",$filedata);
		//array_pop($filedb);
		$count=count($filedb);
		if($filedb[$count-1]==''||$filedb[$count-1]=="\r"){unset($filedb[$count-1]);}
		if(empty($filedb)){$filedb[0]="";}
		return $filedb;
	}else{
		$filedb=file($filename);
		return $filedb;
	}
}
function adminmsg($msg,$jumpurl='',$t=1)
{
	extract($GLOBALS, EXTR_SKIP);
	empty($basename) && $basename=$REQUEST_URI;
	if($jumpurl!=''){
		$ifjump="<META HTTP-EQUIV='Refresh' CONTENT='$t; URL=$jumpurl'>";
	}
	require_once GetLang('cpmsg');
	$lang[$msg] && $msg=$lang[$msg];
	include PrintEot('message');exit;
}
function Char_cv($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);#编辑时比较有效
	return $msg;
}
function ieconvert($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);#编辑时比较有效
	return $msg;
}
function Quot_cv($msg){
	$msg = str_replace('"','&quot;',$msg);
	return $msg;
}
//删除目录
function deldir($path){
	if (file_exists($path)){
		if(is_file($path)){
			P_unlink($path);
		} else{
			$handle = opendir($path);
			while ($file = readdir($handle)) {
				if (($file!=".") && ($file!="..") && ($file!="")){
					if (is_dir("$path/$file")){
						deldir("$path/$file");
					} else{
						P_unlink("$path/$file");
					}
				}
			}
			closedir($handle);
			rmdir($path);
		}
	}
}
// 表单单选框选择判断
function ifcheck($var,$out){
	global ${$out.'_Y'},${$out.'_N'};
	if($var) ${$out.'_Y'}="CHECKED"; else ${$out.'_N'}="CHECKED";

}
function F_L_count($filename,$offset)
{
	$count_F='';
	$onlineip=get_client_ip();
	$count=0;
	if($fp=@fopen($filename,"rb")){
		flock($fp,LOCK_SH);
		fseek($fp,-$offset,SEEK_END);
		$readb=fread($fp,$offset);
		fclose($fp);
		$readb=trim($readb);
		$readb=explode("\n",$readb);
		$count=count($readb);$count_F=0;
		for($i=$count-1;$i>0;$i--){
			if(strpos($readb[$i],"|Logging Failed|$onlineip|")===false){
				break;
			}
			$count_F++;
		}
	}
	return $count_F;
}
function get_date($timestamp,$timeformat=''){
	global $yl_datefm,$yl_timedf;
	$date_show=$timeformat ? $timeformat : $yl_datefm;
	$offset = $yl_timedf=='111' ? 0 : $yl_timedf;
	return gmdate($date_show,$timestamp+$offset*3600);
}
function GetLang($lang,$EXT="php"){
   $path= PATH_DATA . "/lang/cp_lang_$lang.$EXT";
	return $path;
}
function PrintEot($template,$EXT="htm")
{
	$path=PATH_TPLS_ADMIN."/admin_$template.$EXT";
	return $path;
}
function readlog($filename,$offset=1024000)
{
	$readb=array();
	if($fp=@fopen($filename,"rb")){
		flock($fp,LOCK_SH);
		$size=filesize($filename);
		$size>$offset ? fseek($fp,-$offset,SEEK_END): $offset=$size;
		$readb=fread($fp,$offset);
		fclose($fp);
		$readb=str_replace("\n","\n<:ylmf:>",$readb);
		$readb=explode("<:ylmf:>",$readb);
		$count=count($readb);
		if($readb[$count-1]==''||$readb[$count-1]=="\r"){unset($readb[$count-1]);}
		if(empty($readb)){$readb[0]="";}
	}
	return $readb;
}

function checkselid($selid){
	if(is_array($selid)){
		$ret='';
		foreach($selid as $key => $value){
			if(!is_numeric($value)){
				return false;
			}
			$ret .= $ret ? ','.$value : $value;
		}
		return $ret;
	} else{
		return '';
	}
}
function ObHeader($URL){
	echo "<meta http-equiv='refresh' content='0;url=$URL'>";exit;
}




function Iplimit(){
	global $yl_iplimit,$onlineip;
	if($yl_iplimit){
		$allowip=0;
		$ip_a=explode(",",$yl_iplimit);
		foreach($ip_a as $k=>$v){
			if(!$v)continue;
			$v=trim($v);
			if(strpos(','.$onlineip.'.',','.$v.'.')!==false){
				$allowip=1;
			}
		}
		!$allowip && adminmsg('ip_ban');
	}
}
function CheckVar($var){
	if(is_array($var)){
		foreach($var as $key=>$value){
			if(!in_array($key,array('module','advert'))){
				CheckVar($value);
			}
		}
	}else{
		$tar = array('<iframe','<meta','<script');
		foreach($tar as $k=>$v){
			if(strpos(strtolower($var),$v)!==false){
				global $basename;
				$basename="javascript:history.go(-1);";
				adminmsg('word_error');
			}
		}
	}
}
function PostLog($log){
	$data='';
	foreach($log as $key=>$val){
		if(is_array($val)){
			$data .= "$key=array(".PostLog($val).")";
		}else{
			$val = str_replace(array("\n","\r","|"),array('','','&#124;'),$val);
			if($key=='password' || $key=='check_pwd'){
				$data .= "$key=***, ";
			}else{
				$data .= "$key=$val, ";
			}
		}
	}
	return $data;
}



function randstr($lenth)
{
	mt_srand((double)microtime() * 1000000);
	$randval = '';
	for($i = 0; $i < $lenth; $i++)
	{
		$randval .= mt_rand(0, 9);
	}
	$randval = substr(md5($randval), mt_rand(0, 32 - $lenth), $lenth);
	return $randval;
}
function num_rand($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(1,9);
	}
	return $randval;
}
function PwStrtoTime($time){
	$yl_timedf=mod_config::get_one_config('yl_timedf');
	$time= function_exists('date_default_timezone_set') ? strtotime($time) - $yl_timedf*3600 : strtotime($time);
	$time<=0 && $time=0;
	return $time;
}
function EncodeUrl($url){
	global $yl_hash,$admin_name,$admin_gid;
	$url_a=substr($url,strrpos($url,'?')+1);
	substr($url,-1)=='&' && $url=substr($url,0,-1);
	parse_str($url_a,$url_a);
	$source='';
	foreach($url_a as $key=>$val){
		$source .= $key.$val;
	}
	$posthash=substr(md5($source.$admin_name.$admin_gid.$yl_hash),0,8);
	$url .= "&verify=$posthash";
	return $url;
}
function FormCheck($pre,$url,$add){
	$pre=stripslashes($pre);
	$add=stripslashes($add);
	return "<form{$pre} action=\"".EncodeUrl($url)."&\"{$add}>";
}
function PostCheck($verify){
	global $yl_hash,$admin_name,$admin_gid;
	$source='';
	foreach($_GET as $key=>$val){
		if($key!='verify'){
			$source .= $key.$val;
		}
	}
	if($verify!=substr(md5($source.$admin_name.$admin_gid.$yl_hash),0,8)){
		adminmsg('illegal_request');
	}else{
		return true;
	}
}

// 引用文件安全检查
function Pcv($filename,$ifcheck=1){
	strpos($filename,'http://')!==false && exit('Forbidden');
	strpos($filename,'https://')!==false && exit('Forbidden');
	strpos($filename,'ftp://')!==false && exit('Forbidden');
	strpos($filename,'ftps://')!==false && exit('Forbidden');
	strpos($filename,'php://')!==false && exit('Forbidden');
	$ifcheck && strpos($filename,'..')!==false && exit('Forbidden');
	return $filename;
}
// 计算文件大小
function bytes_to_string( $bytes )
{
	if (!preg_match("/^[0-9]+$/", $bytes)) return 0;
	$sizes = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
	$extension = $sizes[0];
	for( $i = 1; ( ( $i < count( $sizes ) ) && ( $bytes >= 1024 ) ); $i++ )
	{
		$bytes /= 1024;
		$extension = $sizes[$i];
	}

	return round( $bytes, 2 ) . ' ' . $extension;
}
//计算目录大小

function dirsize($dir) {
	$dh = opendir($dir);
	$size = 0;
	while($file = readdir($dh)) {
		if($file != '.' and $file != '..') {
			$path = $dir."/".$file;
			if(@is_dir($path)) {
				$size += dirsize($path);
			} else {
				$size += filesize($path);
			}
		}
	}
	@closedir($dh);
	return $size;
};

function PrintIndex($template,$EXT="htm"){
	if(!$template) $template=N;
	$path=Pcv(YLMF_ROOT."data/tpl/main/$template.$EXT");
	return $path;
}

function getstrstr($str, $str1, $str2, $type = 0)
{
	$len1 = strpos($str, $str1);
	$len2 = strpos($str, $str2);
	$str = substr($str, $len1 + strlen($str1), $len2 - $len1 - strlen($str1));
	if ($type == 0)
	{
		Return trim(strip_tags($str));
	}
	else
	{
		Return trim($str);
	}
}

function get_domain($url)
{
	$tmp = @parse_url($url);
	return (!empty($tmp['host'])) ? strtolower($tmp['host']) : false;
}



/* 判断数组是否存在某个值 */
function array_var (&$from, $name, $default = null, $and_unset = false)
{
	if (is_array($from))
	{
		if ($and_unset)
		{
			if (array_key_exists($name, $from))
			{
				$result = $from[$name];
				unset($from[$name]);
				return $result;
			} // if
		}
		else
		{
			return array_key_exists($name, $from) ? $from[$name] : $default;
		} // if
	} // if
	return $default;
}
/* 获得用户的真? IP 地址 */
function get_client_ip ()
{
	static $realip = NULL;
	if ($realip !== NULL)
	{
		return $realip;
	}
	if (isset($_SERVER))
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			/* 取X-Forwarded-For中第?个非unknown的有效IP字符? */
			foreach ($arr as $ip)
			{
				$ip = trim($ip);
				if ($ip != 'unknown')
				{
					$realip = $ip;
					break;
				}
			}
		}
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else
		{
			if (isset($_SERVER['REMOTE_ADDR']))
			{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
			else
			{
				$realip = '0.0.0.0';
			}
		}
	}
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_CLIENT_IP'))
		{
			$realip = getenv('HTTP_CLIENT_IP');
		}
		else
		{
			$realip = getenv('REMOTE_ADDR');
		}
	}
	preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	$realip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
	return $realip;
}

/**
 * 排序比较函数
 *
 * @param array $a 标签数组1
 * @param array $b 标签数组2
 * @return int
 */
function cmp($a, $b)
{
    if ($a['order'] == $b['order']) {
        return 0;
    }
    return ($a['order'] < $b['order']) ? -1 : 1;
}


if(!function_exists('json_encode'))
{
    ini_set('display_errors', 1);
    function json_encode($arr)
    {
        $json_str = "";
        if(is_array($arr))
        {
          $pure_array = true;
          $array_length = count($arr);
          for($i=0;$i<$array_length;$i++)
          {
            if(! isset($arr[$i]))
            {
              $pure_array = false;
              break;
            }
          }
          if($pure_array)
          {
            $json_str ="[";
            $temp = array();
            for($i=0;$i<$array_length;$i++)      
            {
              $temp[] = sprintf("%s", json_encode($arr[$i]));
            }
            $json_str .= implode(",",$temp);
            $json_str .="]";
          }
          else
          {
            $json_str ="{";
            $temp = array();
            foreach($arr as $key => $value)
            {
              $temp[] = sprintf("\"%s\":%s", $key, json_encode($value));
            }
            $json_str .= implode(",",$temp);
            $json_str .="}";
          }
        }
        else
        {
          if(is_string($arr))
          {
            $json_str = "\"". json_encode_string($arr) . "\"";
          }
          else if(is_numeric($arr))
          {
            $json_str = $arr;
          }
          else
          {
            $json_str = "\"". json_encode_string($arr) . "\"";
          }
        }
        return $json_str;
    } 


    function json_encode_string($in_str) 
    {
         mb_internal_encoding("UTF-8");
         $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
         $str = "";
         for ($i = mb_strlen($in_str)-1; $i>=0; $i--) 
         {
             $mb_char = mb_substr($in_str, $i, 1);
             if (mb_ereg("&#(\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) 
             {
                 $str = sprintf("\u%04x", $match[1]) . $str;
             } 
             else 
             {
                 $str = $mb_char . $str;
             }
         }
         return $str;
    }
}

/**
 * 取得参数值
 * @param string $keyName 参数名
 * @return bool
 */
function get_key($keyName)
{
    return do_command('sysctl', "-n $keyName");
}


/**
 * 查找执行文件位置
 * @param string $commandName 命令名
 * @return bool
 */
function find_command($commandName)
{
    $path = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');
    foreach($path as $p)
    {
        if (@is_executable("$p/$commandName")) return "$p/$commandName";
    }
    return false;
}

/*
 * 执行系统命令
 * @param string $commandName 命令名
 * @param string $args 参数
 * @return bool
 */
function do_command($commandName, $args)
{
    $buffer = "";
    if (false === ($command = find_command($commandName))) return false;
    if ($fp = @popen("$command $args", 'r'))
        {
            while (!@feof($fp))
            {
                $buffer .= @fgets($fp, 4096);
            }
            return trim($buffer);
        }
    return false;
}
?>

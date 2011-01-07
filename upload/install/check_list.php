<?php
$check_list = array(
    'dir_list' => array(
		'静态化根目录'=>YLMF_ROOT .  $staticfolder,
        'JS脚本缓存目录'=>YLMF_ROOT.'/static/js',
        '安装脚本目录'=>YLMF_ROOT.'/install',
		'动态数据目录'=>PATH_ADMIN.'data',
		'数据库备份目录'=>PATH_ADMIN.'data/backup',
		'缓存文件目录'=>PATH_ADMIN.'data/cache',
		'配置文件目录'=>PATH_ADMIN.'data/conf',
		'缓存数据目录'=>PATH_ADMIN.'data/db',
		'SESSION目录'=>PATH_ADMIN.'data/session',
		'语言包目录'=>PATH_ADMIN.'data/lang',
		'日志目录'=>PATH_ADMIN.'data/log',
		'计划任务目录'=>PATH_ADMIN.'data/plan',
		'在线升级缓存目录'=>PATH_ADMIN.'data/update',
		'模板缓存目录'=>PATH_ADMIN.'tpls/cache',
		'模板编译目录'=>PATH_ADMIN.'tpls/compile',
		'后台模板目录'=>PATH_ADMIN.'tpls/tpls/admin',
		'前台模板目录'=>PATH_ADMIN.'tpls/tpls/main',
    ),
    
    'file_list' => array(
		'数据库配置文件'=>PATH_ADMIN.'config/cfg_database.php',
        '首页文件index.html'=>YLMF_ROOT.'/index.html',
        '首页文件index.htm'=>YLMF_ROOT.'/index.htm',
     ),
);
?>

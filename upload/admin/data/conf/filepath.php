<?php
!defined('PATH_ADMIN') && exit('Forbidden');
// 文件属性检查范围
$filepath = array(
    PATH_DATA,
    PATH_DATA . '/log',
    PATH_DATA . '/backup',
    PATH_DATA . '/cache',
    PATH_DATA . '/conf',
    PATH_DATA . '/db',
    PATH_DATA . '/lang',
    PATH_DATA . '/plan',
    PATH_TPLS_CACHE,
    PATH_TPLS_COMPILE,
    PATH_TPLS . '/admin',
    PATH_TPLS . '/main',
    PATH_ROOT . '/static/js',
    PATH_HTML,
);

?>
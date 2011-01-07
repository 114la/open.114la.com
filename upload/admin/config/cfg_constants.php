<?php
!defined('PATH_ADMIN') &&exit('Forbidden');
defined('PATH_APPLICATION') || define('PATH_APPLICATION', PATH_ADMIN . '/applications');
defined('PATH_MODULE') || define('PATH_MODULE', PATH_ADMIN . '/modules');
defined('PATH_CONTROLLER') || define('PATH_CONTROLLER', PATH_ADMIN . '/controllers');
defined('PATH_CONFIG') || define('PATH_CONFIG', PATH_ADMIN . '/config');
defined('PATH_DATA') || define('PATH_DATA', PATH_ADMIN . '/data');

defined('PATH_TPLS') || define('PATH_TPLS', PATH_ADMIN . '/tpls/tpls');
defined('PATH_TPLS_COMPILE') || define('PATH_TPLS_COMPILE', PATH_ADMIN . '/tpls/compile');
defined('PATH_TPLS_CACHE') || define('PATH_TPLS_CACHE', PATH_ADMIN . '/tpls/cache');
defined('PATH_TPLS_ADMIN') || define('PATH_TPLS_ADMIN', PATH_TPLS . '/admin');
defined('PATH_TPLS_MAIN') || define('PATH_TPLS_MAIN', PATH_TPLS . '/main');
defined('TPLS_BACKUP_EXT') || define('TPLS_BACKUP_EXT', '.bak');

defined('CUR_VERSION') || define('CUR_VERSION', '1.14');
defined('SOURCE_URL') || define('SOURCE_URL', 'http://update.114la.com');

?>

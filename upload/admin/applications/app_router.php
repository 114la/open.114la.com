<?php
/**
 * 控制器载入
 *
 * @param $controller_name
 * @param $action
 * @return viod
 */
!defined('PATH_ADMIN') && exit('Forbidden');
function load_controller() {
    try {
        $controller = 'ctl_' . ((empty($_GET['c'])) ? 'login' : $_GET['c']);
        $action = (empty($_GET['a'])) ? 'index' : $_GET['a'];

        $path = PATH_CONTROLLER . '/' . $controller . '.php';

        if (file_exists($path))
		{
			require $path;
		}
		else
		{
			throw new Exception("控制器 {$controller} 不存在！", 1);
		}

        if (method_exists($controller, $action) === true)
		{
			$instance = new $controller();
            if (method_exists($controller, 'pre') === true)
            {
                $instance->pre();
            }
			$instance->$action();
            if (method_exists($controller, 'post') === true)
            {
                $instance->post();
            }
		}
		else
		{
			throw new Exception("方法 {$action} 不存在！", 2);
		}

    }
    catch (Exception $e)
	{
		if (DEBUG_LEVEL === true)
		{
			echo '<pre>';
			echo $e->getMessage() . $e->getTraceAsString();
			echo '</pre>';
			exit;
		}
		else
		{
			// 有404页面的时候，此处需要修改
			header("HTTP/1.1 404 Not Found");
			// header("location:404.html");
			exit;
		}
	}
}



/* 自动加载类库 */
if (!function_exists ( '__autoload' ))
{
	function __autoload($classname)
	{
		$classfile = $classname . '.php';
		try
		{
			if (!is_file(PATH_MODULE . '/' . $classfile) && ! class_exists($classname))
			{
				throw new Exception('找不到模型 ' . $classname);
			}
			else
			{
				require PATH_MODULE . '/' . $classfile;
			}
		}
		catch (Exception $e)
		{
    		if (DEBUG_LEVEL === true)
    		{
    			echo '<pre>';
    			echo $e->getMessage() . $e->getTraceAsString();
    			echo '</pre>';
    			exit();
    		}
    		else
    		{
    			// 有404页面的时候，此处需要修改
    			header("HTTP/1.1 404 Not Found");
    			// header("location:404.html");
    			exit;
    		}
		}
	}
}
?>

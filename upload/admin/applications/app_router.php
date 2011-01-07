<?php
/**
 * ����������
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
			throw new Exception("������ {$controller} �����ڣ�", 1);
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
			throw new Exception("���� {$action} �����ڣ�", 2);
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
			// ��404ҳ���ʱ�򣬴˴���Ҫ�޸�
			header("HTTP/1.1 404 Not Found");
			// header("location:404.html");
			exit;
		}
	}
}



/* �Զ�������� */
if (!function_exists ( '__autoload' ))
{
	function __autoload($classname)
	{
		$classfile = $classname . '.php';
		try
		{
			if (!is_file(PATH_MODULE . '/' . $classfile) && ! class_exists($classname))
			{
				throw new Exception('�Ҳ���ģ�� ' . $classname);
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
    			// ��404ҳ���ʱ�򣬴˴���Ҫ�޸�
    			header("HTTP/1.1 404 Not Found");
    			// header("location:404.html");
    			exit;
    		}
		}
	}
}
?>

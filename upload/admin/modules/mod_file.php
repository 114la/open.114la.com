<?php
/**
 * �ļ���д
 *
 * @copyright http://www.114la.com
 * @version    $Id: mod_file.php 400 2009-11-23 03:16:36Z liuzhenyu $
 */
!defined('PATH_ADMIN') && exit('Forbidden');
class mod_file
{
	/**
	 * д�ļ�
	 *
	 * @param string $filename
	 * @param string $data
	 * @param string $method
	 * @param int $iflock
	 * @param int $check
	 * @param int $chmod
	 * @return boolean
	 */
	public static function write($filename, $data, $method = 'wb+', $iflock = 1, $check = 1, $chmod = 1)
	{
		if (empty($filename))
		{
		    return false;
		}

		if ($check && strpos($filename, '..') !== false)
		{
			return false;
		}

        if (!is_dir(dirname($filename)) && !self::mkdir_recursive(dirname($filename), 0777))
        {
            return false;
        }
		if (false == ($handle = fopen($filename, $method)))
		{
			return false;
		}

		if($iflock)
		{
			flock($handle, LOCK_EX);
		}
		fwrite($handle, $data);
		touch($filename);

		if($method == "wb+")
		{
			ftruncate($handle, strlen($data));
		}
		fclose($handle);
		$chmod && @chmod($filename,0777);

		return true;
	}

	/**
	 * ���ļ�
	 *
	 * @param string $filename
	 * @param string $method
	 * @return string
	 */
	public static function read( $filename, $method = "rb" )
	{
		if (strpos( $filename, '..' ) !== false)
		{
			return false;
		}
		if( $handle = @fopen( $filename, $method ) )
		{
			flock( $handle, LOCK_SH );
			$filedata = @fread( $handle, filesize( $filename ) );
			fclose( $handle );
			return $filedata;
		}
		else
		{
			return false;
		}
	}


	/**
	 * ɾ���ļ�
	 *
	 * @param string $filename
	 * @return boolean
	 */
	public static function rm($filename)
	{
		if (strpos($filename, '..') !== false)
		{
			return false;
		}

		return @unlink($filename);
	}


	/**
	 * �õݹ鷽ʽ����Ŀ¼
	 *
	 * @param string $pathname
	 * @param $mode
	 * @return boolean
	 */
	public static function mkdir_recursive($pathname, $mode)
	{
		if (strpos( $pathname, '..' ) !== false)
		{
			return false;
		}
		$pathname = rtrim(preg_replace(array('/\\{1,}/', '/\/{2,}/'), '/', $pathname), '/');
        if (is_dir($pathname))
        {
            return true;
        }

		is_dir(dirname($pathname)) || self::mkdir_recursive(dirname($pathname), $mode);
		return is_dir($pathname) || @mkdir($pathname, $mode);
	}


	/**
	 * �õݹ鷽ʽɾ��Ŀ¼
	 *
	 * @param string $file
	 * @return boolean
	 */
	public static function rm_recurse($file)
	{
		if (strpos( $file, '..' ) !== false)
		{
			return false;
		}

		if (is_dir($file) && !is_link($file))
		{
			foreach(scandir($file) as $sf)
			{
			    if($sf === '..' || $sf === '.')
			    {
			        continue;
			    }
				if (!self::rm_recurse($file . '/' . $sf))
				{
					return false;
				}
			}
			return @rmdir($file);
		}
		else
		{
			return unlink($file);
		}
	}


	/**
	 * �����ļ���ȫ���
	 *
	 * @param string $filename
	 * @param int $ifcheck
	 * @return boolean
	 */
	public static function check_security($filename, $ifcheck=1)
	{
		if (strpos($filename, 'http://') !== false) return false;
		if (strpos($filename, 'https://') !== false) return false;
		if (strpos($filename, 'ftp://') !== false) return false;
		if (strpos($filename, 'ftps://') !== false) return false;
		if (strpos($filename, 'php://') !== false) return false;
		if (strpos($filename, '..') !== false) return false;

		return $filename;
	}

	/**
	 * �ļ��б�
	 *
	 * @param string $path //·��
	 * @param string $type[optional] //����:file �ļ���dir Ŀ¼, ȱʡ file+dir
	 * @return array
	 */
	public static function ls($path, $type = '')
	{
        if(!is_dir($path))
        {
            return false;
        }
        $files = scandir($path);
        array_shift($files);
        array_shift($files);
        if(!empty($type) && in_array($type, array('file', 'dir')))
        {
            $func = "is_" . $type;
            foreach($files as $k => $cur_file)
            {
                if(!$func($path . '/' . $cur_file) || $cur_file == '.svn')
                {
                    unset($files[$k]);
                }
            }
        }
        return $files;
    }
}

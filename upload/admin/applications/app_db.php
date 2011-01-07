<?php
/**
 * 数据库扩展
 *
 * @since 2009-6-29
 * @copyright http://www.114la.com
 */

!defined('PATH_ADMIN') && exit('Forbidden');
class app_db
{
    /**
     * 当前执行的SQL
     * @var string
     */
    protected static $sql = '';
    protected static $link_read = null;
    protected static $link_write = null;
    protected static $current_link = null; // 当前连接标识
    protected static $query;
    protected static $query_count = 0;

    /**
     * 连接数据库
     *
     * @return void
     */
    protected static function init_mysql ($is_read = true, $is_master = false)
    {
        if (empty(self::$$link))
        {
            try
            {
                $link = 'link_read';
                $host = $GLOBALS['database']['db_host'];
                self::$$link = @mysql_pconnect($host, $GLOBALS['database']['db_user'], $GLOBALS['database']['db_pass']);
                if (empty(self::$$link))
                {
                    throw new Exception(mysql_error(), 10);
                }
                else
                {
                    if (mysql_get_server_info() > '4.1')
                    {
                        $charset = str_replace('-', '', strtolower($GLOBALS['database']['db_charset']));
                        mysql_query("SET character_set_connection=" . $charset . ", character_set_results=" . $charset . ", character_set_client=binary");
                    }
                    if (mysql_get_server_info() > '5.0')
                    {
                        mysql_query("SET sql_mode=''");
                    }
                    if (@mysql_select_db($GLOBALS['database']['db_name']) === false)
                    {
                        throw new Exception(mysql_error(), 11);
                    }
                }
            }
            catch (Exception $e)
            {
                if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL)
                {
                    if ($e->getCode() == 10)
                    {
                        echo '数据库连接失败，可能是数据库服务器地址、账号或密码错误';
                    }
                    elseif($e->getCode() == 11)
                    {
                        echo '数据库' . $GLOBALS['database']['db_name'] . '不存在';
                    }
                    else
                    {
                        echo 'Can\'t connect to MySQL server';
                    }
                }
                else
                {
                    echo $e->getMessage(), '<br/>', '<pre>', $e->getTraceAsString(), '</pre>';
                }

                self::log($e->getMessage(),'初始化');
                exit;
            }
        }
        return self::$$link;
    }


    /**
     * (读 + 写)
     *
     * @param  string $sql
     * @return bool
     */
    public static function query ($sql, $is_master = false)
    {
        $sql = trim($sql);
        $GLOBALS ['database'] ['table_prefix'] == 'ylmf_' || $sql = str_replace('ylmf_', $GLOBALS ['database'] ['table_prefix'], $sql);

        self::$current_link = self::init_mysql(true, $is_master);
        try
        {
            self::$sql = $sql;
            self::$query = @mysql_query($sql, self::$current_link);
            if (self::$query === false)
            {
                throw new Exception(mysql_error());
            }
            else
            {
                self::$query_count ++;
                return self::$query;
            }
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else
            {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong> ' . $sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }


    /**
     * 取得最后一次插入记录的ID值
     *
     * @return int
     */
    public static function insert_id ()
    {
        return mysql_insert_id(self::$current_link);
    }


    /**
     * 返回受影响数目
     *
     * @return init
     */
    public static function affected_rows ()
    {
        return mysql_affected_rows(self::$current_link);
    }


    /**
     * 返回本次查询所得的总记录数...
     *
     * @return int
     */
    public static function num_rows ($query = false)
    {
        (empty($query)) && $query = self::$query;
        return mysql_num_rows($query);
    }


    /**
     * (读)返回单条记录数据
     *
     * @deprecated   MYSQL_ASSOC==1 MYSQL_NUM==2 MYSQL_BOTH==3
     * @param  int   $result_type
     * @return array
     */
    public static function fetch_one ($query = false)
    {
        (empty($query)) && $query = self::$query;
        return mysql_fetch_array($query, MYSQL_ASSOC);
    }


    /**
     * (读)返回多条记录数据
     *
     * @deprecated    MYSQL_ASSOC==1 MYSQL_NUM==2 MYSQL_BOTH==3
     * @param   int   $result_type
     * @return  array
     */
    public static function fetch_all ($query = false)
    {
        (empty($query)) && $query = self::$query;
        $row = $rows = array();
        while ($row = mysql_fetch_array($query, MYSQL_ASSOC))
        {
            $rows[] = $row;
        }
        return (empty($rows)) ? false : $rows;
    }


    /**
     * 查询数据库记录，以数组方式返回数据
     *
     * @param string $table
     * @param string $fields
     * @param string $condition
     * @return array
     */
    public static function select($table, $fields, $condition)
    {
        try
        {
            if (empty($table) || empty($fields) || empty($condition))
            {
                throw new Exception('查询数据的表名，字段，条件不能为空', 444);
            }

            self::$sql = "SELECT {$fields} FROM `{$table}` WHERE {$condition}";
            $result = self::query(self::$sql, false);

            return self::fetch_all();
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong>[select] ', (!empty(self::$sql)) && self::$sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }


    /**
     * 更新数据库记录 UPDATE，返回更新的记录数量
     *
     * @param string $table
     * @param string $data
     * @param string $condition
     * @return int
     */
    public static function update($table, $data, $condition)
    {
        try
        {
            if (empty($table) || empty($data) || empty($condition))
                throw new Exception('更新数据的表名，数据，条件不能为空', 444);

            if(!is_array($data))
                throw new Exception('更新数据必须是数组', 444);

            $set = '';
            foreach ($data as $k => $v)
                $set .= empty($set) ? ("`{$k}` = '{$v}'") : (", `{$k}` = '{$v}'");

            if (empty($set)) throw new Exception('更新数据格式化失败', 444);

            self::$sql = "UPDATE `{$table}` SET {$set} WHERE {$condition}";
            $result = self::query(self::$sql, true);

            // 返回影响行数
            return self::affected_rows();
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong>[update]' . (!empty(self::$sql)) && self::$sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }


    /**
     * 插入数据
     *
     * @param string $table
     * @param array $fields
     * @param array $data
     * @return boolean
     */
    public function insert($table, $fields, $data)
    {
        try
        {
            if (empty($table) || empty($fields) || empty($data)) {
                throw new Exception('插入数据的表名，字段、数据不能为空', 444);
            }

            if (!is_array($fields) || !is_array($data))
            {
                throw new Exception('插入数据的字段和数据必须是数组', 444);
            }

            // 格式化字段
            $_fields = '`' . implode('`, `', $fields) . '`';

            // 格式化需要插入的数据
            $_data = self::format_insert_data($data);

            if (empty($_fields) || empty($_data))
            {
                throw new Exception('插入数据的字段和数据必须是数组', 444);
            }

            self::$sql = "INSERT INTO `{$table}` ({$_fields}) VALUES {$_data}";
            $result = self::query(self::$sql, true);

            return self::affected_rows();
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else
            {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong>[insert] ' . (!empty(self::$sql)) && self::$sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }


    /**
     * 格式化 insert 数据，将数组（二维数组）转换成向数据库插入记录时接受的字符串
     *
     * @param array $data
     * @return string
     */
    protected static function format_insert_data($data)
    {
        if (!is_array($data) || empty($data))
        {
            throw new Exception('数据的类型不是数组', 445);
        }

        $output = '';
        foreach ($data as $value)
        {
            // 如果是二维数组
            if (is_array($value))
            {
                $tmp = '(\'' . implode("', '", $value) . '\')';
                $output .= !empty($output) ? ", {$tmp}" : $tmp;
                unset($tmp);
            }
            else
            {
                $output = '(\'' . implode("', '", $data) . '\')';
            }
        } //foreach

        return $output;
    }


    /**
     * 删除记录
     *
     * @param string $table
     * @param string $condition
     * @return num
     */
    public function delete($table, $condition)
    {
        try
        {
            if (empty($table) || empty($condition))
            {
                throw new Exception('表名和条件不能为空', 444);
            }

            self::$sql = "DELETE FROM `{$table}` WHERE {$condition}";
            $result = self::query(self::$sql, true);

            return self::affected_rows();
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else
            {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong>[delete] ' . (!empty(self::$sql)) && self::$sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }


    /**
     * 查询记录数
     *
     * @param string $table
     * @param string $condition
     * @return int
     */
    public static function get_rows_num($table, $condition)
    {
        try
        {
            if (empty($table) || empty($condition))
                throw new Exception('查询记录数的表名，字段，条件不能为空', 444);

            self::$sql = "SELECT count(*) AS total FROM {$table} WHERE {$condition}";
            $result = self::query(self::$sql);

            $tmp = self::fetch_one();
            return (empty($tmp)) ? false : $tmp['total'];
        }
        catch (Exception $e)
        {
            if (!defined('DEBUG_LEVEL') || !DEBUG_LEVEL) ;
            else
            {
                echo $e->getMessage(), '<br/>';
                echo '<pre>', $e->getTraceAsString(), '</pre>';
                echo '<strong>Query: </strong>[rows_num] ' . (!empty(self::$sql)) && self::$sql;
            }
            self::log($e->getMessage());
            exit;
        }
    }

    /**
     * 返回版本信息
     * @return <type>
     */
    public static function server_info()
    {
        return mysql_get_server_info();
    }

    /**
     * 选择数据库
     * @return <type>
     */
    public static function select_db($dbname)
    {
        return mysql_select_db($dbname);
    }

    /**
     * 获取当前执行的 SQL
	 *
     * @return string
     */
    public static function get_sql()
    {
        return self::$sql;
    }


    /**
     * 记录错误日志
     *
     * @return void
     */
    private static function log($message,$sql_info='')
    {
        if(empty($sql_info))$sql_info=self::$sql;
        mod_log::mysql_log($message,$sql_info, mysql_errno());
    }
}
?>

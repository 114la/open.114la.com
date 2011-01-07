<?php
/**
 * ���ݿ���չ
 *
 * @since 2009-6-29
 * @copyright http://www.114la.com
 */

!defined('PATH_ADMIN') && exit('Forbidden');
class app_db
{
    /**
     * ��ǰִ�е�SQL
     * @var string
     */
    protected static $sql = '';
    protected static $link_read = null;
    protected static $link_write = null;
    protected static $current_link = null; // ��ǰ���ӱ�ʶ
    protected static $query;
    protected static $query_count = 0;

    /**
     * �������ݿ�
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
                        echo '���ݿ�����ʧ�ܣ����������ݿ��������ַ���˺Ż��������';
                    }
                    elseif($e->getCode() == 11)
                    {
                        echo '���ݿ�' . $GLOBALS['database']['db_name'] . '������';
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

                self::log($e->getMessage(),'��ʼ��');
                exit;
            }
        }
        return self::$$link;
    }


    /**
     * (�� + д)
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
     * ȡ�����һ�β����¼��IDֵ
     *
     * @return int
     */
    public static function insert_id ()
    {
        return mysql_insert_id(self::$current_link);
    }


    /**
     * ������Ӱ����Ŀ
     *
     * @return init
     */
    public static function affected_rows ()
    {
        return mysql_affected_rows(self::$current_link);
    }


    /**
     * ���ر��β�ѯ���õ��ܼ�¼��...
     *
     * @return int
     */
    public static function num_rows ($query = false)
    {
        (empty($query)) && $query = self::$query;
        return mysql_num_rows($query);
    }


    /**
     * (��)���ص�����¼����
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
     * (��)���ض�����¼����
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
     * ��ѯ���ݿ��¼�������鷽ʽ��������
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
                throw new Exception('��ѯ���ݵı������ֶΣ���������Ϊ��', 444);
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
     * �������ݿ��¼ UPDATE�����ظ��µļ�¼����
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
                throw new Exception('�������ݵı��������ݣ���������Ϊ��', 444);

            if(!is_array($data))
                throw new Exception('�������ݱ���������', 444);

            $set = '';
            foreach ($data as $k => $v)
                $set .= empty($set) ? ("`{$k}` = '{$v}'") : (", `{$k}` = '{$v}'");

            if (empty($set)) throw new Exception('�������ݸ�ʽ��ʧ��', 444);

            self::$sql = "UPDATE `{$table}` SET {$set} WHERE {$condition}";
            $result = self::query(self::$sql, true);

            // ����Ӱ������
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
     * ��������
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
                throw new Exception('�������ݵı������ֶΡ����ݲ���Ϊ��', 444);
            }

            if (!is_array($fields) || !is_array($data))
            {
                throw new Exception('�������ݵ��ֶκ����ݱ���������', 444);
            }

            // ��ʽ���ֶ�
            $_fields = '`' . implode('`, `', $fields) . '`';

            // ��ʽ����Ҫ���������
            $_data = self::format_insert_data($data);

            if (empty($_fields) || empty($_data))
            {
                throw new Exception('�������ݵ��ֶκ����ݱ���������', 444);
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
     * ��ʽ�� insert ���ݣ������飨��ά���飩ת���������ݿ�����¼ʱ���ܵ��ַ���
     *
     * @param array $data
     * @return string
     */
    protected static function format_insert_data($data)
    {
        if (!is_array($data) || empty($data))
        {
            throw new Exception('���ݵ����Ͳ�������', 445);
        }

        $output = '';
        foreach ($data as $value)
        {
            // ����Ƕ�ά����
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
     * ɾ����¼
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
                throw new Exception('��������������Ϊ��', 444);
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
     * ��ѯ��¼��
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
                throw new Exception('��ѯ��¼���ı������ֶΣ���������Ϊ��', 444);

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
     * ���ذ汾��Ϣ
     * @return <type>
     */
    public static function server_info()
    {
        return mysql_get_server_info();
    }

    /**
     * ѡ�����ݿ�
     * @return <type>
     */
    public static function select_db($dbname)
    {
        return mysql_select_db($dbname);
    }

    /**
     * ��ȡ��ǰִ�е� SQL
	 *
     * @return string
     */
    public static function get_sql()
    {
        return self::$sql;
    }


    /**
     * ��¼������־
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

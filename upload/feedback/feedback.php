<?php
/**
 * Feedback
 * @copyright http://www.ylmf.com
 * @since 2009-06-19
 */
require '../init.php';

/* ÿ�� IP ÿ������ύ������� */
define('SUBMIT_ONE_DAY', 3);
$error_msg = '';

try
{
    $username = empty($_POST['username']) ? '' : strip_tags(iconv('UTF-8', 'GBK', $_POST['username']));
    $email = (isset($_POST['email'])) ? strip_tags(iconv('UTF-8', 'GBK', $_POST['email'])) : '';
    $content = (isset($_POST['content'])) ? trim(iconv('UTF-8', 'GBK', $_POST['content'])) : '';
    (empty($content)) && $error_msg .= '����������� ';

    if (!empty($error_msg))
    {
        throw new Exception($error_msg, 11);
    }

    $content = htmlspecialchars($content, ENT_QUOTES);
    if (strlen($content) > 600 || strlen($content) < 40)
    {
        throw new Exception('�뽫��������������  20 - 300 �֣��������������ִ��ύ��', 1);
    }

    // ��֤����
    $old_cookie = (isset($_COOKIE['fdnum'])) ? (int)$_COOKIE['fdnum'] : 0;
    if ($old_cookie >= SUBMIT_ONE_DAY)
    {
        throw new Exception('��Ǹ��24 Сʱ����ֻ���ύ  ' . SUBMIT_ONE_DAY . ' �η�����Ϣ��лл������', 2);
    }
    $old_cookie++;

    if (false === app_db::insert('ylmf_feedback', array('username', 'email', 'content', 'add_time'),
                                                 array($username, $email, $content, time())))
    {
        throw new Exception('��Ǹ����Ϣ�ύʧ�ܣ������ԡ�', 1);
    }
    else
    {
        // ��¼�ύ����
        if ($old_cookie > SUBMIT_ONE_DAY || !isset($_COOKIE['fdstime']) || $_COOKIE['fdstime'] < 1)
        {
            setcookie('dfstime', time(), time() + 86400);
            setcookie('fdnum', $old_cookie, time() + 86400);
        }
        else
        {
            setcookie('fdnum', $old_cookie, time() + 86400 - (time() - $_COOKIE['fdstime']));
        }


        throw new Exception('<div class="success">�ύ�ɹ�����л���ķ����� <a href="'. URL .'/">������ҳ</a></div>', 3);
        unset($username, $email, $content);
    }

    unset($headers, $body);
}
catch (Exception $e)
{
    $error_msg = $e->getMessage();
    if (!empty($error_msg) && $e->getCode() == 11)
    {
        $error_msg = '��Ǹ����Ϣ�ύʧ�ܣ������� ' . substr($error_msg, 2) . '��';
    }
    $output =  array(
        'code' => ($e->getCode() < 2) ? 1 : 3,
        'message' => iconv('GBK', 'UTF-8', $error_msg),
    );

    header("content-type:text/html; charset=GBK");
    echo json_encode($output);
}
?>
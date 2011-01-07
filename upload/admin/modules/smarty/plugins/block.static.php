<?php
!defined('PATH_ADMIN') && exit('Forbidden');
function smarty_block_static ($params, $content, &$smarty, &$repeat)
{
    cls_template::assign('STATIC', $content);
    return '';
}
?>
<?php
!defined('PATH_ADMIN') && exit('Forbidden');
/**
 * 
 *
 *
 */
function smarty_modifier_alexa($source)
{
	/*
	<img src="static/images/Down_arrow.gif"/>
	<img src="static/images/Up_arrow.gif"/>
	*/
	if($source == '-')
	{
		return '-';
	}
	$source = str_replace(array('-','+'),array('<image src="'.URL.'/static/images/Up_arrow.gif" />','<image src="'.URL.'/static/images/Down_arrow.gif" />'),$source);
	return $source;
}
?>

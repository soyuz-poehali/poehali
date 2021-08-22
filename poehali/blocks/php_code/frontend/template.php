<?php
defined('AUTH') or die('Restricted access');

function block_php_code($block)
{
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/frontend/files/'.$block['file_name'];
	$func = substr($block['file_name'], 0, strlen($block['file_name']) - 4);

	if (function_exists($func))
		$func_out = $func();
	else
		$func_out = '';

	return $func_out;
}
?>
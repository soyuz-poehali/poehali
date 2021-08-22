<?php
// DAN 2010
// Настройки сайта
defined('AUTH') or die('Restricted access');

	
// === Отправка на почту ==================================================
function mail_support($error)
{
	global $SITE;
	
	$to1 = 'info@63s.ru'; 
	$to2 = 'info@5za.ru';

	// SUBJECT тема
	$subject = "Ошибка с сайта www.".$SITE->domain." ";
	
	$site_code = '=?UTF-8?B?'.base64_encode($SITE->domain).'?=';
	
	// Для отправки HTML-почты Content-type. 
	$headers  = "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type: text/html; charset=UTF-8 \r\n";
	$headers .= "From: www.".$site_code." <".$to2."> \r\n"; 
	
	// = MAIL = 
	mail($to1, '=?UTF-8?B?'.base64_encode($subject).'?=', $error, $headers);
}

?>
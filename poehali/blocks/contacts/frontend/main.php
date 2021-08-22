<?php
defined('AUTH') or die('Restricted access');

$name = get_post('name');
$phone = get_post('phone');
$message = get_post('message');
$refer = get_post('refer');
$submit = get_post('submit');

$err = false;

// ======= СПАМ ФИЛЬТР =======
if($submit != 'Отправить') 
	$err = 'Блок "Контакты" - нет нажатия кнопки "submit"';
if(mb_strlen($message) < 10) 
	$err = 'Недопустимое сообщение "'.$message.'"';
if(mb_strlen($phone) < 7) 
	$err = 'Недопустимый телефон: "'.$phone.'"';
if(mb_strlen($name) < 3) 
	$err = 'Недопустимое имя: "'.$name.'"';

if ($err) {
	$SITE->errLog($err);
	exit;
}

if (!isset($_SESSION['contacts_time'])) 
	exit;

$delta_time = time() - $_SESSION['contacts_time'];

if ($delta_time < 3 || $delta_time > 3600)
	exit;

if ($delta_time < 3 || $delta_time > 3600)
	exit;
// ------- / спам фильтр -------

$dmn = empty($SITE->domain_idn) ? $SITE->domain : $SITE->domain_idn;


$from = 'no-replay@'.$SITE->domain;
$subject = 'Сообщение с сайта';
$content = 
	'<h3 style="margin:30px 0px 30px 0px; text-align:center; font-family:Arial; font-size:20px;">Сообщение с сайта</h3>'.
		'<div style="margin:0 auto; max-width:600px; text-align:center; font-family:Arial; font-size:16px;">'.
			'<div style="margin-bottom:30px;font-size:12px;text-align:center;">'.
			'<span style="color:#a5a5a5;">Отправлено со страницы:</span><br>'.
			'<a href="'.$SITE->getProtocol().'://'.$dmn.$refer.'" target="_blank">'.$SITE->getProtocol().'://'.$dmn.$refer.'</a>'.
		'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Имя:</span>'.$name.'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Телефон:</span>'.$phone.'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Сообщение:</span>'.$message.'</div>'.
	'</div>';

include $_SERVER['DOCUMENT_ROOT'].'/classes/Mail/Mail.php';

$MAIL = new Mail;
$MAIL->send($SITE->email, $from, $subject, $content);

// Лиды
$leads_title = mb_substr($name.' '.$phone, 0, 50);
$leads_message = 
	$content.
	'<div>&nbsp;</div>'.
	'<div>Отправлено со страницы: <a href="'.$_SERVER['HTTP_REFERER'].'" target="_blank">'.$_SERVER['HTTP_REFERER'].'</a></div>';	

echo
	'<!DOCTYPE html>'.
	'<html>'.
	'<head>'.
	'<meta http-equiv="content-type" content="text/html; charset=utf-8" />'.
	'<meta http-equiv="refresh" content="3;URL=//'.$SITE->domain.'">'.
	'<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">'.
	'<title>Ваше сообщение отправлено</title>'.
	'</head>'.
	'<body>'.
		'<h1 style="margin:100px 0px 30px 0px; text-align:center; font-family:Arial; font-size:28px;">Ваше сообщение отправлено</h1>'.
		$content.
	'</body>'.
	'</html>';


function get_post($name)
{
	$out = isset($_POST[$name]) ? trim(htmlspecialchars(strip_tags($_POST[$name]))) : '';
	return $out;
}
?>
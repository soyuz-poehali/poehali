<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Mail/Mail.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/classes/Block.php';
$BLOCK = new Block;

// ======= СПАМ ФИЛЬТР =======
if (!isset($_POST['submit'])) {
	$SITE->errLog('Блок "Контакты" - нет нажатия кнопки "submit"');
	exit;
}

if (!isset($_SESSION['form_time'])) 
	exit;

$delta_time = time() - $_SESSION['form_time'];

if ($delta_time < 3 || $delta_time > 3600)
	exit;
// ------- / спам фильтр -------


$id = intval($_POST['block_id']);
$fields_input_arr = $_POST['field'];
$refer = clear_post($_POST['refer']);

$protocol = $SITE->getProtocol();
$content = $BLOCK->getBlock($id)['content'];

$fields_arr = $content['fields'];

$out = '';
foreach ($fields_input_arr as $key => $value) {
	$out .= '<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">'.$fields_arr[$key]['text'].'</span>'.clear_post($value).'</div>';
}

$dmn = empty($SITE->domain_idn) ? $SITE->domain : $SITE->domain_idn;

$subject = 'Сообщение с сайта';
$html = 
	'<h3 style="margin:30px 0px 30px 0px; text-align:center; font-family:Arial; font-size:20px;">Сообщение с сайта</h3>'.
	'<div style="margin-bottom:30px;font-size:12px;text-align:center;">'.
		'<span style="color:#a5a5a5;">Отправлено со страницы:</span><br>'.
		'<a href="'.$protocol.'://'.$dmn.$refer.'" target="_blank">'.$protocol.'://'.$dmn.$refer.'</a>'.
	'</div>'.
	'<div style="margin:0 auto; max-width:600px; text-align:center; font-family:Arial; font-size:16px;">'.
		$out.
	'</div>';


$MAIL = new Mail;
$MAIL->send($SITE->email, $dmn, $subject, $html);

/*
// Лиды
$leads_title = mb_substr($out, 0, 50).'...';
$leads_message = 
	'<div>'.$out.'</div>'.
	'<div>&nbsp;</div>'.
	'<div>Отправлено со страницы: <a href="'.$protocol.'://'.$dmn.$refer.'" target="_blank">'.$protocol.'://'.$dmn.$refer.'</a></div>';
$utm = new UTM;
$utm->lead('Форма обратной связи', $leads_title, $leads_message);
*/

echo
	'<!DOCTYPE html>'.
	'<html>'.
	'<head>'.
	'<meta http-equiv="content-type" content="text/html; charset=utf-8" />'.
	'<meta http-equiv="refresh" content="3;URL='.$protocol.'://'.$dmn.$refer.'">'.
	'<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">'.
	'<title>Ваше сообщение отправлено</title>'.
	'</head>'.
	'<body>'.
		'<h1 style="margin:100px 0px 30px 0px; text-align:center; font-family:Arial; font-size:28px;">Ваше сообщение отправлено</h1>'.	
		$html.
	'</body>'.
	'</html>';


// Очищает данные, полученные методом post
function clear_post($value)
{
	return trim(htmlspecialchars(strip_tags($value)));
}
?>
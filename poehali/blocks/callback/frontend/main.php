<?php
defined('AUTH') or die('Restricted access');
include $_SERVER['DOCUMENT_ROOT'].'/classes/Mail/Mail.php';

$name = get_post('name');
$phone = get_post('phone');
$submit = get_post('submit');

$err = false;

// Проверка
if($submit != 'Заказать') $err = 'Обратный звонок - нет нажатия кнопки "submit"';
if(mb_strlen($phone) < 7) $err = 'Недопустимый телефон: "'.$phone.'"';
if(mb_strlen($name) < 3) $err = 'Недопустимое имя: "'.$name.'"';



$from = $SITE->domain;
$subject = 'Сообщение с сайта';
$content = 
	'<h3 style="margin:100px 0px 30px 0px; text-align:center; font-family:Arial; font-size:20px;">Обратный звонок с сайта</h3>'.
	'<div style="margin:0 auto; max-width:600px; text-align:center; font-family:Arial; font-size:16px;">'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Имя:</span>'.$name.'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Телефон:</span>'.$phone.'</div>'.
	'</div>';


$MAIL = new Mail;
$MAIL->send($SITE->email, $from, $subject, $content);

// Лиды
$leads_t = $name.' '.$phone;
$leads_message = 
	'<div>Имя :<b>'.$name.'</b></div>'.
	'<div>Телефон :<b>'.$phone.'</b></div>'.
	'<div>&nbsp;</div>'.
	'<div>Отправлено со страницы: <a href="'.$_SERVER['HTTP_REFERER'].'" target="_blank">'.$_SERVER['HTTP_REFERER'].'</a></div>';	


echo json_encode(array('answer' => 'success'));
exit;

function get_post($name)
{
	$out = isset($_POST[$name]) ? trim(htmlspecialchars(strip_tags($_POST[$name]))) : '';
	return $out;
}
?>
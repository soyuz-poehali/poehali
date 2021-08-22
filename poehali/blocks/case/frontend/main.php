<?php
defined('AUTH') or die('Restricted access');
include $_SERVER['DOCUMENT_ROOT'].'/classes/Mail.php';

$block_id = intval($_POST['id']);
$question = get_post('question');
$phone = get_post('phone');
$email = Settings::instance()->getValue('email');

$err = false;

// Проверка
if(mb_strlen($phone) < 7) $err = 'Недопустимый телефон: "'.$phone.'"';

$stmt = $db->prepare("SELECT settings FROM blocks WHERE id = :id");
$stmt->execute(array('id' => $block_id));
$s = $stmt->fetchColumn();
$block = unserialize($s);
$c = trim($block['text']);
$case = substr($c, 0, 200).'...';


$from = $SITE->domain;
$subject = 'Вопрос по кейсу';
$content = 
	'<h3 style="margin:100px 0px 30px 0px; text-align:center; font-family:Arial; font-size:20px;">Вопрос по кейсу</h3>'.
	'<div style="margin:0 auto; max-width:600px; text-align:center; font-family:Arial; font-size:16px;">'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Вопрос:</span>'.$question.'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Телефон:</span>'.$phone.'</div>'.
		'<div style="padding:5px 0px"><span style="color:#a5a5a5; padding-right:20px;">Кейс:</span>'.$case.'</div>'.
	'</div>';


$MAIL = new Mail;
$MAIL->send($email, $from, $subject, $content);

// Лиды
$leads_t = $question.' '.$phone;
$leads_message = 
	'<div>Вопрос: <b>'.$question.'</b></div>'.
	'<div>Телефон: <b>'.$phone.'</b></div>'.
	'<div>&nbsp;</div>'.
	'<div>Кейс: '.$case.'</div>'.
	'<div>&nbsp;</div>'.
	'<div>Отправлено со страницы: <a href="'.$_SERVER['HTTP_REFERER'].'" target="_blank">'.$_SERVER['HTTP_REFERER'].'</a></div>';	
$leads_title = mb_substr($leads_t, 0, 50).'...';
$utm = new UTM;
$utm->lead('Обратный звонок', $leads_title, $leads_message);


echo json_encode(array('answer' => 'success'));
exit;

function get_post($name)
{
	$out = isset($_POST[$name]) ? trim(htmlspecialchars(strip_tags($_POST[$name]))) : '';
	return $out;
}
?>
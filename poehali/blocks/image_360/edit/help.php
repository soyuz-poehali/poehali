<?php
defined('AUTH') or die('Restricted access');


$content =
'<div>'.
	'<h2>Помощь - "Изображение 360&deg"</h2>'.
	'<div><b>Принцип работы:</b></div>'.
	'<div>Изображение 360&deg получается путём смены кадров фрейма, где каждый новый кадр - изображение под новым углом съёмки</div>'.
	'<div>&nbsp;</div>'.
	'<div>Для вращения в одной плоскости - изображения должны иметь наименования от <b>0.jpg</b> до <b>n.jpg</b>, где <b>n</b> - номер последнего изображения. '.
	'Для вращения в 2 плоскостях - изображения должны иметь такую нумерацию от <b>0_0.jpg</b> до <b>n_m.jpg</b>, где <b>n, m</b> - номера последних изображений в соответстующих плоскостях</div>'.
	'<div>&nbsp;</div>'.	
	'<div>Постарайтесь, что бы размер изображений был от 400 до 1024 пикселей по ширине. Чем меньше количество изображений, размер отдельного изображения и сильнее сжатие - тем быстрее будет загружаться сайт и наоборот - качественные и большие изображения загружаются долго. Чем больше изображений, тем плавнее будет переход. Необходимо выбрать оптимальное соотношение исходя из Ваших требований.</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>
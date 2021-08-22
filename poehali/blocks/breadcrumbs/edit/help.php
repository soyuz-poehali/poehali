<?php
defined('AUTH') or die('Restricted access');


$content =
'<div>'.
	'<h2>Помощь - блок "Виртуальный тур"</h2>'.
	'<div>Загрузите панорамную фотографию и при необходимости заполните текстовое поле</div>'.
	'<div>Панорамные фотографии можно получить используя панорамные фото-камеры</div>'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>
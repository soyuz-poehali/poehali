<?php
defined('AUTH') or die('Restricted access');

$data['content']['style'] = '1';
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '60';
$data['content']['padding'] = '40';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#f5f5f5';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['wrap_bg_opacity'] = '1';
$data['content']['wrap_bg_color'] = '#eeeeee';
$data['content']['color'] = '#444444';
$data['content']['line_height'] = '1.2';
$data['content']['font_size'] = 28;
$data['content']['text'] = '<h2 style="text-align: center;color:var(--title-color);font-size:var(--title-size);">Оставить заявку</h2>';
$data['content']['button_text'] = 'Отправить';
$data['content']['button_color'] = '#ffffff';
$data['content']['button_bg_color'] = '#00BB06';

$data['content']['fields'] = array(
	array(
		'type' => 'text',
		'text' => 'Ваше имя',
		'required' => 0
	),

	array(
		'type' => 'text',
		'text' => 'Телефон',
		'required' => 1
	)
);

?>
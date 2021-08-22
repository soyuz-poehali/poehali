<?php
defined('AUTH') or die('Restricted access');

$data['content']['style'] = '1';
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '';
$data['content']['padding'] = '40';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['color'] = 'var(--font-color)';
$data['content']['font_size'] = '16';
$data['content']['line_height'] = '1.2';
$data['content']['wrap_bg_color'] = '';
$data['content']['wrap_bg_opacity'] = '';
$data['content']['sticky'] = '';
$data['content']['mark_type'] = 'islands#redBlue';

$data['content']['fields'] = array(
	array(
		'type' => 'html',
		'content' => '<h3>Контакты</h3><br>'		
	),
	
	array(
		'type' => 'address',
		'content' => 'г.Москва, ул.Главная, д.10, оф.12'		
	),

	array(
		'type' => 'phone',
		'content' => '+7 (777) 777 77 77'		
	),

	array(
		'type' => 'email',
		'content' => 'info@топ.сайт'		
	),
	
	array(
		'type' => 'mapyandex',
		'coordinate' => array(55.76, 37.64),
		'points' => false,
		'zoom' => 7
	)	
);

?>
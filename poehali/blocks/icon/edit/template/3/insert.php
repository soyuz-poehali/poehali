<?php
defined('AUTH') or die('Restricted access');

$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = 'cover';
$data['content']['wrap_bg_color'] = '';
$data['content']['wrap_bg_opacity'] = 1;
$data['content']['color'] = '#444444';
$data['content']['title_size'] = 24;
$data['content']['font_size'] = 16;
$data['content']['margin'] = 40;
$data['content']['padding'] = 10;
$data['content']['max_width'] = 1440;
$data['content']['line_height'] = 1.2;

$data['content']['style'] = 3;
$data['content']['icon_color'] = '#0080ff';
$data['content']['icon_size'] = 50;

$data['content']['icons'] = array(
	array(
		'icon' => 'im-key-thin',
		'text_1' => 'Заголовок 1',
		'text_2' => 'Описание 1'		
	),

	array(
		'icon' => 'im-clothing-12',
		'text_1' => 'Заголовок 2',
		'text_2' => 'Описание 2'		
	),

	array(
		'icon' => 'im-product-4',
		'text_1' => 'Заголовок 3',
		'text_2' => 'Описание 3'
	),

	array(
		'icon' => 'im-clothing-14',
		'text_1' => 'Заголовок 4',
		'text_2' => 'Описание 4'		
	)	
);


?>
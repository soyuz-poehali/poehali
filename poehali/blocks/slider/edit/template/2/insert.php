<?php
defined('AUTH') or die('Restricted access');

$data['content']['style'] = 2;
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '40';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#eeeeee';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['wrap_bg_opacity'] = '1';
$data['content']['wrap_bg_color'] = '#ffffff';
$data['content']['color'] = '#ffffff';
$data['content']['line_height'] = '1.2';
$data['content']['title_size'] = 5;
$data['content']['font_size'] = 3;
$data['content']['padding'] = 40;
$data['content']['dots'] = 1;
$data['content']['effect'] = 1;
$data['content']['fog_color'] = '#000000';
$data['content']['fog_opacity'] = 0.5;
$data['content']['ratio'] = 0.4;
$data['content']['interval'] = 3;
$data['content']['text_1_size'] = 5;
$data['content']['text_2_size'] = 3;

$data['content']['slides'] = array(
	array(
		'file' => '1.jpg',
		'text_1' => 'Крупный текст слайда 1',
		'text_2' => 'Обычный текст слайда 1',
		'link' => ''			
	),

	array(
		'file' => '2.jpg',
		'text_1' => 'Крупный текст слайда 2',
		'text_2' => 'Обычный текст слайда 2',
		'link' => ''		
	),

	array(
		'file' => '3.jpg',
		'text_1' => 'Крупный текст слайда 3',
		'text_2' => 'Обычный текст слайда 3',
		'link' => ''			
	)	
);

// КОПИРУЕМ ФАЙЛЫ
if(!is_dir($dir)) 
	mkdir($dir, 0755, true);
$dir_source = $_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/template/2';

$i = 0;
$arr = array();

foreach ($data['content']['slides'] as $slide) {
	$name_new = uniqid().'.jpg';
	copy($dir_source.'/'.($i + 1).'.jpg', $dir.'/'.$name_new);
	$data['content']['slides'][$i]['file'] = $name_new;
	$i++;
}

?>
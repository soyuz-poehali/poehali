<?php
defined('AUTH') or die('Restricted access');

$data['content']['style'] = '1';
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '40';
$data['content']['padding'] = '0';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#666666';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['wrap_bg_opacity'] = '0';
$data['content']['wrap_bg_color'] = '';
$data['content']['color'] = '#ffffff';
$data['content']['line_height'] = '1.2';
$data['content']['font_size'] = 3;
$data['content']['videos'] = array(
	array(
		'text' => 
			'<h2 style="text-align:center;color:#ffffff;">Видео 16 x 9</h2>',
		'url' => 'https://www.youtube.com/embed/vgSnGcH-DFw',
		'ratio' => 1,
		'button_1' => 
			array(
				'on' => 1,
				'text' => 'Подробнее',
				'link' => '',
				'bg_color' => '#0079ca',
				'text_color' => '#ffffff',
				'style' => 'solid',
				'radius' => '40',
			),
		'button_2' => 
			array(
				'on' => 1,
				'text' => 'Подробнее',
				'link' => '',
				'bg_color' => '#ff8040',
				'text_color' => '#ff8040',
				'style' => 'border',
				'radius' => '40',
			)
	)
);

?>
<?php
defined('AUTH') or die('Restricted access');

$data['content']['style'] = '2';
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '40';
$data['content']['padding'] = '40';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['wrap_bg_opacity'] = '0';
$data['content']['wrap_bg_color'] = '';
$data['content']['color'] = '#ffffff';
$data['content']['line_height'] = '1.2';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['videos'] = array(
	array(
		'text' => 
			'<p style="text-align:center"><h2 style="text-align: center;">Заголовок видео</h2></p>'.
			'<p style="text-align: center;">Текст блока. Выравнивание заголовка и текста блока – по центру. Размер, цвет шрифта - можно поменять в визуальном редакторе. Заголовок блока прописан тегом &lt;h2&gt;. Если данный заголовок должен быть главным заголовком страницы – в визуальном редакторе поменяйте тип на «Заголовок 1»</p>',
		'url' => 'https://www.youtube.com/embed/vgSnGcH-DFw',
		'ratio' => 1,
		'button_1' => 
			array(
				'on' => 1,
				'text' => 'Кнопка 1',
				'link' => '',
				'bg_color' => '#0079ca',
				'text_color' => '#ffffff',
				'style' => 'solid',
				'radius' => '40',
			),
		'button_2' => 
			array(
				'on' => 1,
				'text' => 'Кнопка 2',
				'link' => '',
				'bg_color' => '#0079ca',
				'text_color' => '#0079ca',
				'style' => 'border',
				'radius' => '40',
			)
	)
);

?>
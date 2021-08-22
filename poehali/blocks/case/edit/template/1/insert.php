<?php
defined('AUTH') or die('Restricted access');

$text =
	'<h2><span style="font-size:36px"><strong>Ремонт квартиры в Москве</strong></span></h2>'.
	'<p><span style="font-size:22px"><span style="color:#999999">Ремонт однокомнатной квартиры в Москве за 3 дня</span></span></p>'.
	'<p>&nbsp;</p>'.
	'<p><strong><span style="font-size:26px">299 000</span><span style="font-size:24px"> </span></strong><span style="font-size:24px">₽</span></p>'.
	'<p><span style="color:#999999"><span style="font-size:12px">Итоговая стоимость</span></span></p>'.
	'<p>&nbsp;</p>'.
	'<p><strong>Включено в стоимость:</strong></p>'.
	'<p>&nbsp;</p>'.
	'<table class="table_list">'.
		'<tbody>'.
			'<tr>'.
				'<td>Стойка для потолочного светильника</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Изготовление и окантовка отверстия</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Установка встраиваемого светильника</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Светильник H4 GX53 хром / Chrome</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Лампа GX53 8W 4100К 25000h Светодиодная-80WW</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Обработка угла</td>'.
				'<td>8 шт</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Профиль стеновой невидимый ПВХ</td>'.
				'<td>23 м</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Лента маскировочная универсальная белая</td>'.
				'<td>23 м</td>'.
			'</tr>'.
			'<tr>'.
				'<td>Выставление дополнительной конструкции под профиль</td>'.
				'<td>3 м</td>'.
			'</tr>'.
		'</tbody>'.
	'</table>';

$data['content']['style'] = '1';
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '60';
$data['content']['padding'] = '40';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = 'cover';
$data['content']['wrap_bg_opacity'] = '1';
$data['content']['wrap_bg_color'] = '#eeeeee';
$data['content']['color'] = '#fffffff';
$data['content']['line_height'] = '1.2';
$data['content']['font_size'] = '16';
$data['content']['images'] = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg');
$data['content']['text'] = $text;
$data['content']['button'] = array(
	'on' => 1,
	'text' => 'Задать вопрос',
	'bg_color' => '#0079ca',
	'text_color' => '#ffffff',
	'radius' => 40,
	'style' => 'solid',
);

?>
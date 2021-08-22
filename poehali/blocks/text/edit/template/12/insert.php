<?php
defined('AUTH') or die('Restricted access');

$data['content'] = [];
$data['content']['max_width'] = '600';
$data['content']['margin'] = '60';
$data['content']['padding'] = '0';
$data['content']['wrap_bg_opacity'] = 1;
$data['content']['wrap_bg_color'] = '';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['color'] = 'var(--font-color)';
$data['content']['line_height'] = '1';
$data['content']['text'] = 
'<h2>Таблица</h2>'.
'<p>Текст вверху таблицы.</p>'.
'<p>&nbsp;</p>'.
'<table class="dan_table_border">'.
	'<tbody>'.
		'<tr>'.
			'<th>Название услуги</th>'.
			'<th>Параметр 1</th>'.
			'<th>Параметр 2</th>'.
			'<th>Параметр 3</th>'.
		'</tr>'.
		'<tr>'.
			'<td>Строка 1</td>'.
			'<td>Параметр 1-1</td>'.
			'<td>Параметр 2-1</td>'.
			'<td>Параметр 3-1</td>'.
		'</tr>'.
		'<tr>'.
			'<td>Строка 2</td>'.
			'<td>Параметр 2-1</td>'.
			'<td>Параметр 2-2</td>'.
			'<td>Параметр 2-3</td>'.
		'</tr>'.
		'<tr>'.
			'<td>Строка 3</td>'.
			'<td>Параметр 3-1</td>'.
			'<td>Параметр 3-2</td>'.
			'<td>Параметр 3-3</td>'.
		'</tr>'.
	'</tbody>'.
'</table>'.
'<p>&nbsp;</p>'.
'<p>Текст внизу таблицы.</p>';
?>
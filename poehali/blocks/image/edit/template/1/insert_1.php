<?php
defined('AUTH') or die('Restricted access');

// --- КОПИРУЕМ ФАЙЛ ---
$source_path = $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/1/img_1.jpg';

$name_new = uniqid().'.jpg';
copy($source_path, $dir.'/'.$name_new);

$data = [];
$data['page_id'] = $page_id;
$data['type'] = 'image';
$data['ordering'] = $ordering;
$data['status'] = '1';
$data['content'] = [];
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '60';
$data['content']['padding'] = '40';
$data['content']['wrap_bg_opacity'] = '1';
$data['content']['wrap_bg_color'] = '#ffffff';
$data['content']['bg_type'] = '2';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['color'] = 'var(--color-1)';
$data['content']['line_height'] = '1.6';
$data['content']['style'] = '1';
$data['content']['image'] = $name_new;
$data['content']['alt'] = '';
$data['content']['text'] = 
	'<h2 style="color:var(--title-color);font-size:var(--title-size);">Заголовок блока</h2>'.
	'<p>Текст блока.'.
	'Размер, цвет шрифта - можно поменять в визуальном редакторе. '.
	'Заголовок блока прописан тегом &lt;h2&gt;. '.
	'Если данный заголовок должен быть главным заголовком страницы – в визуальном редакторе поменяйте тип на «Заголовок 1»</p>';
?>
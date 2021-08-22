<?php
defined('AUTH') or die('Restricted access');

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/text/background';
if (!is_dir($dir)) 
	mkdir($dir, 0755, true);

$source_path = $_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/template/10/bg.jpg';

$name_new = uniqid().'.jpg';
copy($source_path, $dir.'/'.$name_new);

$data['content'] = [];
$data['content']['max_width'] = '';
$data['content']['margin'] = '0';
$data['content']['padding'] = '80';
$data['content']['wrap_bg_opacity'] = 0.55;
$data['content']['wrap_bg_color'] = '#000000';
$data['content']['bg_type'] = 'i';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = $name_new;
$data['content']['bg_image_size'] = 'cover';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['color'] = '#ffffff';
$data['content']['line_height'] = '1.6';
$data['content']['text'] = 
'<h2 style="text-align: center;">Заголовок блока</h2>'.
'<p style="text-align: center;">Текст блока. Выравнивание заголовка и текста блока – по центру.</p>'.
'<p style="text-align: center;">Размер, цвет шрифта - можно поменять в визуальном редакторе.</p>'.
'<p style="text-align: center;">Фоновую картинку можно поменять в настройках блока</p>'.
'<p style="text-align: center;">Заголовок блока прописан тегом &lt;h2&gt;.</p>';

?>
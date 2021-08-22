
<?php
defined('AUTH') or die('Restricted access');

$data['content'] = [];
$data['content']['max_width'] = '800';
$data['content']['margin'] = '60';
$data['content']['padding'] = '20';
$data['content']['wrap_bg_opacity'] = 1;
$data['content']['wrap_bg_color'] = '';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['color'] = 'var(--font-color)';
$data['content']['line_height'] = '1.6';
$data['content']['text'] = 
'<h2>Заголовок блока</h2>'.
'<p style="text-align: left;font-size:16px;">Текст блока. Выравнивание заголовка и текста блока – по центру. '.
'Максимальная ширина блока - 800px '.
'Размер, цвет шрифта - можно поменять в визуальном редакторе. '.
'Заголовок блока прописан тегом &lt;h2&gt;. '.
'Если данный заголовок должен быть главным заголовком страницы – в визуальном редакторе поменяйте тип на «Заголовок 1»</p>';
?>
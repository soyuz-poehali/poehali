<?php
defined('AUTH') or die('Restricted access');

$data['content'] = [];
$data['content']['max_width'] = '800';
$data['content']['margin'] = '60';
$data['content']['padding'] = '60';
$data['content']['wrap_bg_opacity'] = 1;
$data['content']['wrap_bg_color'] = '#f5f5f5';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = '';
$data['content']['font_size'] = 'var(--font-size)';
$data['content']['color'] = 'var(--font-color)';
$data['content']['line_height'] = '1.6';
$data['content']['text'] = 
'<h2 style="text-align: center;">Заголовок блока</h2>'.
'<p style="text-align: center;">Текст блока. Выравнивание заголовка и текста блока – по левому краю. '.
'Все настройки блока, в том числе шрифты, отступы, цвета - стандартные. '.
'Максимальная ширина блока: 600px. '.
'Размер, цвет шрифта - можно поменять в визуальном редакторе. '.
'Заголовок блока прописан тегом &lt;h2&gt;. '.
'Если данный заголовок должен быть главным заголовком страницы – в визуальном редакторе поменяйте тип на «Заголовок 1»';
?>
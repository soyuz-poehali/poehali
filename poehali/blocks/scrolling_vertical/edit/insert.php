<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = 'scrolling_vertical';
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['status'] = '1';
$template_id = intval($_POST['style_id']);

// Начальная инициализация массива, ниже переопределяется в файле insert.php
$content = array(
	'style' => 1,
	'bg_type' => 'c',
	'bg_color' => '#ffffff',
	'bg_image' => '',
	'bg_image_size' => 'cover',
	'color' => '#444444',
	'font_size' => 16,
	'line_height' => 1.2,
	'max_width' => 1440,
	'height' => 400,
	'margin' => 60,
	'image' => '1.jpg',
	'text' => 
		'<h2 style="text-align:center"><span style="color:#000000">Заголовок блока</span></h2>'.
		'<p style="text-align:center">Текст блока.Размер, цвет шрифта - можно поменять в визуальном редакторе. '.
		'Заголовок блока прописан тегом &lt;h2&gt;. Если данный заголовок должен быть главным заголовком страницы '.
		'– в визуальном редакторе поменяйте тип на «Заголовок 1»</p>'
);

$data['content'] = $content;

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/scrolling_vertical';

if (!is_dir($dir))
	mkdir($dir, 0755, true);

copy($_SERVER['DOCUMENT_ROOT'].'/blocks/scrolling_vertical/edit/template/1/1.jpg', $dir.'/1.jpg');

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
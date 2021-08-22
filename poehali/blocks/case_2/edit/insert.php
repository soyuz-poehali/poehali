<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = 'case_2';
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
	'font_size' => 14,
	'line_height' => 1.2,
	'max_width' => 1440,
	'margin' => 60,
	'padding' => 5,
	'items_bg_color' => '#e7e7e7',
	'items' => array(
		array(
			'link' => '',
			'images' => array('1_1.jpg', '1_2.jpg', '1_3.jpg', '1_4.jpg', '1_5.jpg'),
			'icons' => array(
				array('ico' => 'im-construction-40', 'text' => 'Текст 1'),
				array('ico' => 'im-construction-31', 'text' => 'Текст 2'),
				array('ico' => 'im-construction-33', 'text' => 'Текст 3'),
				array('ico' => 'im-construction-38', 'text' => 'Текст 4'),
			),
			'text' => 'Заголовок 1',
		),
		array(
			'link' => 'https://топ.сайт',
			'images' => array('2_1.jpg', '2_2.jpg', '2_3.jpg', '2_4.jpg', '2_5.jpg'),
			'icons' => array(
				array('ico' => 'im-construction-40', 'text' => 'Текст 1'),
				array('ico' => 'im-construction-31', 'text' => 'Текст 2'),
				array('ico' => 'im-construction-33', 'text' => 'Текст 3'),
				array('ico' => 'im-construction-38', 'text' => 'Текст 4'),
			),
			'text' => 'Заголовок 2',
		),
		array(
			'link' => '',
			'images' => array('3_1.jpg', '3_2.jpg', '3_3.jpg', '3_4.jpg', '3_5.jpg'),
			'icons' => array(
				array('ico' => 'im-construction-40', 'text' => 'Текст 1'),
				array('ico' => 'im-construction-31', 'text' => 'Текст 2'),
				array('ico' => 'im-construction-33', 'text' => 'Текст 3'),
				array('ico' => 'im-construction-38', 'text' => 'Текст 4'),
			),
			'text' => 'Заголовок 3',
		),
	),

);

$data['content'] = $content;

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/case_2';

if (!is_dir($dir))
	mkdir($dir, 0755, true);

// Копирование файлов
for ($i = 0; $i < 3; $i++) {
	for ($j = 0; $j < 5; $j++) {
		$name_new = uniqid().'.jpg';
		$data['content']['items'][$i]['images'][$j] = $name_new;
		copy($_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/edit/template/1/'.($j + 1).'.jpg', $dir.'/'.$name_new);
	}
}

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
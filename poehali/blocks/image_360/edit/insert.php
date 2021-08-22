<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = 'image_360';
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['status'] = '1';
$template_id = intval($_POST['style_id']);

// Проверка размещения блока на странице
if ($BLOCK_E->getBlockCount($data) > 0) {
	echo json_encode(array('answer' => 'message', 'text' => 'Блок уже размещён ранее.<br>Допустимо размещение только одного блока на странице'));
	exit;
}

// Начальная инициализация массива, ниже переопределяется в файле insert.php
$data['content'] = array(
	'style' => 1,
	'bg_type' => 'c',
	'bg_color' => '#ffffff',
	'bg_image' => '',
	'bg_image_size' => 'cover',
	'max_width' => '1440',
	'max_width_360' => '600',
	'margin' => '60',
	'color' => '#444444',
	'font_size' => '16',
	'line_height' => '1.2',
	'height' => '400',
	'direction' => 'x-reverse',
	'n' => '9',
	'm' => '18',
	'items' => array(
		array(
			'text' => 'Текст 1',
			'folder' => '1'
		)
	)
);


$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360';
if (!is_dir($dir))
	mkdir($dir, 0755, true);

foreach ($data['content']['items'] as $item) {
	$item_dir = $dir.'/'.$item['folder'];

	if (!is_dir($item_dir))
		mkdir($item_dir, 0755, true);

	for ($n = 0; $n < $data['content']['n']; $n++) { 
		for ($m = 0; $m < $data['content']['m']; $m++) { 
			copy($_SERVER['DOCUMENT_ROOT'].'/blocks/image_360/edit/template/images/'.$n.'_'.$m.'.jpg', $item_dir.'/'.$n.'_'.$m.'.jpg');
		}
	}
}


$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
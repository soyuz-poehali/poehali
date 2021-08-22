<?php
defined('AUTH') or die('Restricted access');
include_once $dir['classes'].'/BlockEdit.php';
$block_e = new BlockEdit;

// Копирование файлов
$images_arr = [];
for ($i = 0; $i < 5; $i++) {
	$name_new = uniqid().'.jpg';
	$images_arr[] = $name_new;
	copy($dir['block_a_path'].'/edit/template/1/'.($i + 1).'.jpg', $dir['page_a_path'].'/case_2/'.$name_new);
}

$block['items'][] = array(
	'link' => '',
	'images' => $images_arr,
	'icons' => array(
		array('ico' => 'im-construction-40', 'text' => 'Текст 1'),
		array('ico' => 'im-construction-31', 'text' => 'Текст 2'),
		array('ico' => 'im-construction-33', 'text' => 'Текст 3'),
		array('ico' => 'im-construction-38', 'text' => 'Текст 4'),
	),
	'text' => '<div><span style="font-size:18px">Новый кейс</span></div><div>Текст, текст, текст, текст.</div>',
);

$settings = serialize($block);

$data['id'] = $block_id;
$data['settings'] = $settings;

$block_e->updateBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
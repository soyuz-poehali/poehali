<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];


// Копирование файлов
$images_arr = [];
for ($i = 0; $i < 5; $i++) {
	$name_new = uniqid().'.jpg';
	$images_arr[] = $name_new;
	copy($_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/edit/template/1/'.($i + 1).'.jpg', $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case_2/'.$name_new);
}

$content['items'][] = array(
	'link' => '',
	'images' => $images_arr,
	'icons' => array(
		array('ico' => 'im-construction-40', 'text' => 'Текст 1'),
		array('ico' => 'im-construction-31', 'text' => 'Текст 2'),
		array('ico' => 'im-construction-33', 'text' => 'Текст 3'),
		array('ico' => 'im-construction-38', 'text' => 'Текст 4'),
	),
	'text' => 'НОВЫЙ КЕЙС',
);


$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>
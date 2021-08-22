<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$photo_num = isset($_POST['photo_num']) ? intval($_POST['photo_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

if (count($content['photos']) < 2) {
	echo json_encode(array('answer' => 'error', 'message' => 'Последнее изображение нельзя удалить. Фотогалерея не может быть без изображений. Не нужна фотогалерея - удалите фотогалерею.'));
	exit;	
}

// ДИРЕКТОРИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/photogallery';
if(!is_dir($dir)) 
	mkdir($dir, 0755);

if(is_file($dir.'/'.$content['photos'][$photo_num - 1]['file'])) 
	unlink($dir.'/'.$content['photos'][$photo_num - 1]['file']);

unset($content['photos'][$photo_num - 1]);

// УДАЛЯЕМ ДЫРКИ ИЗ МАССИВА
$arr = $content['photos'];
$arr_new = array();
foreach ($arr as $item) {
	$arr_new[] = $item;
}
$content['photos'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;

?>
<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$image_num = intval($_POST['image_num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

// Удаляем файл
$image = $content['items'][($num-1)]['images'][($image_num-1)];
$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/case_2/'.$image;

if (is_file($file))
	unlink($file);	

// Удаляем изображение из блока
unset($content['items'][($num-1)]['images'][($image_num-1)]);

// Удаляем дырки из массива - пересобираем массив
$arr = $content['items'][($num-1)]['images'];
$arr_new = array();

foreach ($arr as $item){
	$arr_new[] = $item;
} 

$content['items'][($num-1)]['images'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));

?>
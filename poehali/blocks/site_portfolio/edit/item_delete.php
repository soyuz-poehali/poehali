<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

// Удаляем файл
$image = $content['items'][($num-1)]['image'][($num-1)];
$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/site_portfolio/'.$image;

if (is_file($file))
	unlink($file);	

unset($content['items'][$num - 1]);

// Удаляем дырки из массива - пересобираем массив
$arr_new = array();
foreach ($content['items'] as $item){
	$arr_new[] = $item;
} 

$content['items'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));

?>
<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/text/';

// Копируем изображение фона
if ($data['content']['bg_type'] == 'i') {
	$path_source = $dir.'background/'.$data['content']['bg_image'];

	$file_name_arr = explode('.', $data['content']['bg_image']);
	$ext = array_pop($file_name_arr);
	$file_new = uniqid().'.'.$ext;
	$path_new = $dir.'background/'.$file_new;

	if (copy($path_source, $path_new));
	else $SITE->errLog('Не удалось скопировать файл фон блока. Из '.$path_source.' В '.$path_new);

	$data['content']['bg_image'] = $file_new;
}

$id_new = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $id_new));
exit;
?>
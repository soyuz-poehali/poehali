<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));
$file = isset($_FILES) && array_key_exists('file', $_FILES) ? $_FILES['file'] : false;

$data = $BLOCK_E->getBlock($id);
$content = $BLOCK_E->getBlock($id)['content'];

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/virtual_tour';

if (!is_dir($dir)) 
	mkdir($dir, 0755, true);

// Работа с изображениями
if ($file) {
	$check_file = new CheckImageFile($file);
	if (!$check_file) {
		echo json_encode(array('answer' => 'success', 'message' => 'Некорректный файл (тип, размер)'));
		exit;	
	}

	$u = uniqid();
	$file_new = $u.'.jpg';
	$path_new = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/virtual_tour/'.$file_new;
	move_uploaded_file($file['tmp_name'], $path_new);
}

// Обновляем данные
if (array_key_exists('num', $_POST)) {
	// Если найден номер - обновляем сцену
	$num = intval($_POST['num']);
	if ($file) {
		$file_old = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/virtual_tour/'.$content['items'][$num-1]['image'];
		if(is_file($file_old))
			unlink($file_old);
		$content['items'][$num-1]['image'] = $file_new;
	}
	$content['items'][$num-1]['text'] = $text;
} else {
	// Не найден номер - добавляем сцену
	if (!$file) {
		echo json_encode(array('answer' => 'error', 'message' => 'Файл не найден. Необходимо выбрать файл.'));
		exit;		
	}
	$content['items'][] = array('image' => $file_new, 'text' => $text);
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>
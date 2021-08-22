<?php
# АЛГОРИТМ РАБОТЫ
# Если есть файлы - получаем их поодиночке.
# Если есть num - кладём в папку модели - если нет - складываем во временную папку
# После получения последнего файла - получаем текст и в случае отсутствия num - переименовываем временную папку
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = array_key_exists('num', $_POST) ? trim(htmlspecialchars(strip_tags($_POST['num']))) : false;
$text = array_key_exists('text', $_POST) ? trim($_POST['text']) : false;
$file = isset($_FILES) && array_key_exists('file', $_FILES) ? $_FILES['file'] : false;

$data = $BLOCK_E->getBlock($id);
$content = $BLOCK_E->getBlock($id)['content'];

// Работа с изображениями
if ($file) {
	$check = new CheckImageFile($file);
	if (!$check) {
		echo json_encode(array('answer' => 'error', 'message' => 'Недопустимый формат файла'));
		exit;
	}

	if ($num) {
		// Обновляем файл в старой папке
		$folder = $content['items'][$num-1]['folder'];
		$path = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/'.$folder.'/'.$file['name'];
	} else {
		// Добавляем файл в тестовую папку
		$temp_path = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/temp';
		if (!is_dir($temp_path))
			mkdir($temp_path, 0755, true);
		$path = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/temp/'.$file['name'];
	}

	move_uploaded_file($file['tmp_name'], $path);
	echo json_encode(array('answer' => 'success', 'id' => $id));
	exit;
}


// Шаг 1. Если есть текст - обновляем текст
if ($text) {
	if (array_key_exists('num', $_POST)) {
		// Обновляем модель
		$num = intval($_POST['num']);
		$content['items'][$num-1]['text'] = $text;
	} else {
		// Добавляем модель
		$folder_name_new = uniqid();
		$content['items'][] = array(
			'text' => $text,
			'folder' => $folder_name_new
		);
		// Если изображения добавлены раньше - то есть временная папке, если её нет - выходим без обновления
		if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/temp'))	{
			echo json_encode(array('answer' => 'success', 'id' => $block_id, 'message' => 'Не выбраны файлы'));
			exit;		
		}	

		// Переименовываем временную директорию
		rename($_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/temp', $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/'.$folder_name_new);
	}

	$BLOCK_E->updateBlockContent($id, $content);
}


echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>
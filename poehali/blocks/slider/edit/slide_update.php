<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$slide_num = isset($_POST['slide_num']) ? intval($_POST['slide_num']) : false;
$text_1 = trim(strip_tags(htmlspecialchars($_POST['text_1'])));
$text_2 = trim(strip_tags(htmlspecialchars($_POST['text_2'])));
$link = trim(strip_tags(htmlspecialchars($_POST['link'])));

$content = $BLOCK_E->getBlock($id)['content'];

// ДИРЕКТОРИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/slider';

if (!$slide_num && !isset($_FILES['file'])) {
	echo json_encode(array('answer' => 'error', $content = 'Не прикреплён файл изображения'));
	exit;
}	

// ФАЙЛ
if (isset($_FILES['file'])) {
	$file = $_FILES['file'];

	// Проверка
	// --- Проверяем тип файла ---
	$size = getimagesize($file['tmp_name']); // Получим размер изображения и его тип
	$type = $size[2];

	if (!($type == 1 || $type == 2 || $type == 3)) {
		$act = 'error';
		$SITE->errLog('Неправильный тип файла - '.$type);
		echo json_encode(array('answer' => 'error', 'content' => 'Файлы такого типа <b>'.$file['name'].'</b> запрещено загружать на сервер.'));
		exit;
	}

	$file_name_arr = explode('.', $file['name']);
	$count = count($file_name_arr);
	$ext = mb_strtolower($file_name_arr[$count - 1]);
	$allowed = array('jpg', 'jpeg');
	if (($count) < 2 || !in_array($ext, $allowed)) {
		$SITE->errLog('Файлы такого типа '.$file_new['name'].' запрещено загружать на сервер.');
		echo json_encode(array('answer' => 'error', 'content' => 'Файлы такого типа <b>'.$file['name'].'</b> запрещено загружать на сервер.'));
		exit;
	}

	if (!is_dir($dir)) 
		mkdir($dir, 0755, true);
	$file_new = uniqid().'.jpg';
	$path_new = $dir.'/'.$file_new;

	move_uploaded_file($file['tmp_name'], $path_new);
}


// ДОБАВИТЬ / ОБНОВИТЬ СЛАЙД
if (!$slide_num) { 
	// Добавить
	$arr['file'] = $file_new;	
	$arr['text_1'] = $text_1;
	$arr['text_2'] = $text_2;
	$arr['link'] = $link;
	$content['slides'][] = $arr;
} else {
	// Обновить
	if (isset($file_new)) {
		$patch = $dir.'/'.$content['slides'][$slide_num - 1]['file'];
		if(is_file($patch)) unlink($patch);		
		$content['slides'][$slide_num - 1]['file'] = $file_new;		
	}	
	$content['slides'][$slide_num - 1]['text_1'] = $text_1;
	$content['slides'][$slide_num - 1]['text_2'] = $text_2;
	$content['slides'][$slide_num - 1]['link'] = $link;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;

?>
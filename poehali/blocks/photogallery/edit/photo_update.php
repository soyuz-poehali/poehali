<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

// Настройки изображения
$settings_1 = 800;
$settings_2 = 600;
$settings_3 = 450;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$photo_num = isset($_POST['photo_num']) ? intval($_POST['photo_num']) : false;
$text_1 = trim(strip_tags(htmlspecialchars($_POST['text_1'])));
$text_2 = trim(htmlspecialchars($_POST['text_2']));
//$link = trim(strip_tags(htmlspecialchars($_POST['link'])));
$link = '';

$text_2 = nl2br($text_2);

$content = $BLOCK_E->getBlock($id)['content'];

if ($content['format'] == 1) {
	$photo_settings['x_small'] = $settings_1;
	$photo_settings['y_small'] = $settings_1;
}

if ($content['format'] == 2) {
	$photo_settings['x_small'] = $settings_1;
	$photo_settings['y_small'] = $settings_2;
}

if ($content['format'] == 3) {
	$photo_settings['x_small'] = $settings_1;
	$photo_settings['y_small'] = $settings_3;
}

if ($content['format'] == 4) {
	$photo_settings['x_small'] = $settings_2;
	$photo_settings['y_small'] = $settings_1;
}

if ($content['format'] == 5)
{
	$photo_settings['x_small'] = $settings_3;
	$photo_settings['y_small'] = $settings_1;
}

if (!$photo_num && !isset($_FILES['file'])) {
	echo json_encode(array('answer' => 'error', $content = 'Не прикреплён файл изображения'));
	exit;
}	


// ДИРЕКТОРИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/photogallery';
if (!is_dir($dir)) 
	mkdir($dir, 0755);


if (isset($_FILES['file'])) {
	$file = $_FILES['file'];

	// Проверка
	// --- Проверяем тип файла ---
	$size = getimagesize($file['tmp_name']); // Получим размер изображения и его тип
	$type = $size[2];

	$file_name_arr = explode('.', $file['name']);
	$count = count($file_name_arr);
	$ext = mb_strtolower($file_name_arr[$count - 1]);
	$allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
	if ($count < 2 || !in_array($ext, $allowed)) {
		$SITE->errLog('Файлы такого типа '.$file['name'].' запрещено загружать на сервер.');
		echo json_encode(array('answer' => 'error', 'content' => 'Файлы такого типа <b>'.$file['name'].'</b> запрещено загружать на сервер.'));
		exit;
	}

	if (!is_dir($dir)) 
		mkdir($dir, 0755, true);

	$u = uniqid();

	// Малое изображение
	$file_new = $u.'.webp';
	$path_new = $dir.'/'.$file_new;

	include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeCutting.php";
	$img_small = new ImageResizeCutting($file['tmp_name'], $path_new, $photo_settings['x_small'], $photo_settings['y_small'], 'webp');
	$img_small->run();
}
// ___ файл ___



if (!$photo_num) { // Добавить фото
	$arr['file'] = $file_new;	
	$arr['text_1'] = $text_1;
	$arr['text_2'] = $text_2;
	$arr['link'] = $link;
	
	$content['photos'][] = $arr;
} else {
	// Обновить фото	
	if (isset($file_new)) {
		$file = $dir.'/'.$content['photos'][$photo_num - 1]['file'];
		if(is_file($file)) 
			unlink($file);		
		$content['photos'][$photo_num - 1]['file'] = $file_new;		
	}	
	$content['photos'][$photo_num - 1]['text_1'] = $text_1;
	$content['photos'][$photo_num - 1]['text_2'] = $text_2;
	$content['photos'][$photo_num - 1]['link'] = $link;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success'));
exit;

?>
<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
$BLOCK_E = new BlockEdit;

$max_width = 200;
$max_height = 120;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];
$content['logo']['pub'] = intval($_POST['pub']);


// --- ФАЙЛ ---
if (isset($_FILES['file'])) {
	$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/0/menu';	
	$file = $_FILES['file'];

	if (!is_dir($dir)) 
		mkdir($dir, 0755, true);

	if (isset($_FILES['file'])) {
		$file = $_FILES['file'];
	} else {
		echo json_encode(array('answer' => 'success', 'message' => 'Файл не выбран'));
		exit;
	}

	$check_file = new CheckImageFile($file);
	if (!$check_file) {  // Проверка расширения и мим типа файла изображения
		echo json_encode(array('answer' => 'success', 'message' => 'Файлы такого типа нельзя загружать на сервер'));
		exit;	
	}

	$size = getimagesize($file['tmp_name']);

	$file_name_arr = explode('.', $file['name']);
	$count = count($file_name_arr);
	$ext = $file_name_arr[$count-1];  // Расширение

	$file_name = 'logo.'.$ext;
	$path_new = $dir.'/'.$file_name;

	if ($max_width > $size[0] && $max_height > $size[1]) {
		move_uploaded_file($file['tmp_name'], $path_new);
	} else {
		include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResize.php";
		$file_name = 'logo.webp';
		$path_new = $dir.'/'.$file_name;
		$img_new = new ImageResize($file['tmp_name'], $path_new, $max_width, $max_height,'webp');
		$img_new->run();
	}

	$content['logo']['logo'] = $file_name;
}
// ___ файл ___


$BLOCK_E->updateBlockContent($id, $content);
echo json_encode(array('answer' => 'reload', 'id' => $id));

?>
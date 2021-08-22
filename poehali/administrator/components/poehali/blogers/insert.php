<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$image_file = $_FILES['image'];
$img_name = '';

// Изображение
if ($image_file['tmp_name'] != '') {
	$img_name = uniqid().'.webp';
	$path = $_SERVER['DOCUMENT_ROOT'].'/files/poehali/blogers/'.$img_name;
	include_once($_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeCutting.php");
	$img = new ImageResizeCutting ($image_file['tmp_name'], $path, 500, 500, 'webp');
	$img->run();
}

$data_arr['sn_url'] = $_POST['sn_url'];

$themes_arr = isset($_POST['themes']) ? implode(',', $_POST['themes']) : [];
$sn_arr = isset($_POST['sn_active']) ? implode(',', $_POST['sn_active']) : [];

$arr = array(
	'fio' => f_input('fio'),
	'image' => $img_name,
	'email' => f_input('email'),
	'text' => $_POST['editor1'],
	'themes' => $themes_arr,
	'sn' => $sn_arr,
	'date_birth' => $_POST['date_birth'],
	'data' => $data_arr,
	'status' => intval($_POST['status']),
	'ordering' => intval($_POST['ordering'])
);

$POEHALI->blogerInsert($arr);

// ======= ФУНКЦИИ =======
function f_input($name){
	$post_data = isset($_POST[$name]) ? $_POST[$name] : '';
	return trim(htmlspecialchars(strip_tags($post_data)));
}


header ('location: /admin/com/poehali/blogers/');	
exit;		
?>
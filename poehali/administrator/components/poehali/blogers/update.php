<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$id = $SITE->url_arr[5];
$bloger = $POEHALI->blogerGet($id);

$data_arr['sn_url'] = $_POST['sn_url'];

$themes_arr = isset($_POST['themes']) ? implode(',', $_POST['themes']) : [];
$sn_arr = isset($_POST['sn_active']) ? implode(',', $_POST['sn_active']) : [];

$bloger['id'] = $id;
$bloger['fio'] = f_input('fio');
$bloger['text'] = $_POST['editor1'];
$bloger['themes'] = $themes_arr;
$bloger['sn'] = $sn_arr;
$bloger['date_birth'] = $_POST['date_birth'];
$bloger['data'] = $data_arr;
$bloger['status'] = intval($_POST['status']);
$bloger['ordering'] = intval($_POST['ordering']);

// Изображение
$image_file = $_FILES['image'];
if ($image_file['tmp_name'] != '') {
	$img_name = uniqid().'.webp';
	$bloger['image'] = $img_name;
	$path = $_SERVER['DOCUMENT_ROOT'].'/files/poehali/blogers/'.$img_name;
	include_once($_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeCutting.php");
	$img = new ImageResizeCutting ($image_file['tmp_name'], $path, 500, 500, 'webp');
	$img->run();
}

$POEHALI->blogerUpdate($bloger);

// ======= ФУНКЦИИ =======
function f_input($name){
	$post_data = isset($_POST[$name]) ? $_POST[$name] : '';
	return trim(htmlspecialchars(strip_tags($post_data)));
}

header ('location: /admin/com/poehali/blogers/');	
exit;		
?>
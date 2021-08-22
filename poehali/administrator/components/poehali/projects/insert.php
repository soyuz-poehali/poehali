<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$date_arr = [];

$arr = array(
	'name' => f_input('name'),
	'text' => $_POST['editor1'],
	'themes' => implode(',', $_POST['themes']),
	'coordinates' => f_input('coordinates'),
	'date' => $_POST['date'],
	'data' => $date_arr,
	'status' => intval($_POST['status']),
	'ordering' => intval($_POST['ordering'])
);

$POEHALI->projectInsert($arr);

// ======= ФУНКЦИИ =======
function f_input($name){
	$post_data = isset($_POST[$name]) ? $_POST[$name] : '';
	return trim(htmlspecialchars(strip_tags($post_data)));
}


header ('location: /admin/com/poehali/projects');	
exit;		
?>
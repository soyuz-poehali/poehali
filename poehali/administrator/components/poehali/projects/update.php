<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$id = $SITE->url_arr[5];
$project = $POEHALI->projectGet($id);
$project['name'] = f_input('name');
$project['text'] = $_POST['editor1'];
$project['themes'] = implode(',', $_POST['themes']);
$project['coordinates'] = f_input('coordinates');
$project['date'] = $_POST['date'];
$project['status'] = intval($_POST['status']);
$project['ordering'] = intval($_POST['ordering']);
$project['id'] = $id;

$POEHALI->projectUpdate($project);

// ======= ФУНКЦИИ =======
function f_input($name){
	$post_data = isset($_POST[$name]) ? $_POST[$name] : '';
	return trim(htmlspecialchars(strip_tags($post_data)));
}

header ('location: /admin/com/poehali/projects');	
exit;		
?>
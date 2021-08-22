<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$project_id = $_POST['project_id'];
$bloger_id = $_POST['bloger_id'];

$bloger = $POEHALI->blogerGet($bloger_id);
$arr = array(
	'project_id' => $project_id, 
	'bloger_id' => $bloger_id,
	'data' => []
);
$POEHALI->projectBlogerInsert($arr);

$html = 
'<div class="poehali_blogers_list_wrap drag_drop_ico" data-id="'.$bloger['id'].'" data-class="poehali_blogers_list_wrap" data-f="ADMIN.poehali.projects.ordering">'.
	'<img src="/files/poehali/blogers/'.$bloger['image'].'">'.
	'<div class="poehali_blogers_list_fio">'.$bloger['fio'].'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit();
<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$blogers_arr = $POEHALI->blogerGetBlogers();

$html = '';
if ($blogers_arr) {
	foreach ($blogers_arr as $bloger) {
		$html .= 
		'<div class="poehali_blogers_list_wrap" data-id="'.$bloger['id'].'">'.
			'<img src="/files/poehali/blogers/'.$bloger['image'].'">'.
			'<div class="poehali_blogers_list_fio">'.$bloger['fio'].'</div>'.
		'</div>';
	}			
} 

$html = '<div class="dan_flex_row">'.$html.'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit();
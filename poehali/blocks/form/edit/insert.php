<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'form';
$data['status'] = '1';

// СТИЛЬ
if($template_id > 0 && $template_id < 8) 
	include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/template/'.$template_id.'/insert.php');
else 
	exit;

$block_id = $BLOCK_E->insertBlock($data);

// Вызываем блок вывода
echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
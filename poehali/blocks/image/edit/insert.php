<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;


$page_id = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$ordering = $BLOCK_E->getMaxOrdering($page_id) + 1;

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/image';
if(!is_dir($dir)) 
	mkdir($dir, 0755, true);


switch ($template_id) {
	case '1':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/1/insert_1.php';
		break;
	case '2':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/2/insert_2.php';
		break;
	case '3':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/1/insert_3.php';
		break;
	case '4':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/2/insert_4.php';
		break;
	default:
		exit;
}

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));

?>
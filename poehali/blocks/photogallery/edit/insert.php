<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'photogallery';
$data['status'] = '1';

// ТИП
if($template_id > 0 && $template_id < 4) 
	include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/template/'.$template_id.'/insert.php');
else 
	exit;


// ДИРЕКТОРИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/photogallery';
if(!is_dir($dir)) 
	mkdir($dir, 0755, true);

$dir_source = $_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/template/'.$template_id;

$i = 0;
$arr = array();
foreach ($data['content']['photos'] as $photo) {
	$name_new = uniqid().'.jpg';
	copy($dir_source.'/'.($i+1).'.jpg', $dir.'/'.$name_new);
	$data['content']['photos'][$i]['file'] = $name_new;
	$i++;
}

$block_id = $BLOCK_E->insertBlock($data);

// Вызываем блок вывода
echo json_encode(array('answer' => 'reload', 'id' => $block_id));

?>
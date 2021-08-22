<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'case';
$data['status'] = '1';

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/case';

if (!is_dir($dir))
	mkdir($dir, 0755, true);

// Стиль
if ($template_id > 0 && $template_id < 8) 
	include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/template/'.$template_id.'/insert.php');
else 
	exit;

// Копирование файлов
$dir_source = $_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/template/'.$template_id;

if (!is_dir($dir))
	mkdir($dir, 0755);

for ($i = 1; $i <= 5; $i++) {
	$name_new = uniqid().'.jpg';
	$data['content']['images'][$i - 1] = $name_new;
	copy($dir_source.'/'.$i.'.jpg', $dir.'/'.$name_new);
}

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = 'php_code';
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['status'] = '1';
$code = trim($_POST['code']);
$data['content']['file_name'] = trim(htmlspecialchars(strip_tags($_POST['file_name'])));

if (!preg_match("/[a-z]{1}[a-z0-9_\-]{1,30}.php/", $data['content']['file_name']))
	exit;

$file_name = $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/frontend/files/'.$data['content']['file_name'];

if (file_exists($file_name )) {
	echo json_encode(array('answer' => 'success', 'message' => 'Файл '.$data['content']['file_name'].' уже существует'));
	exit;
}

$f_hdl = @fopen($file_name, 'w');
fwrite($f_hdl, $code);
fclose($f_hdl);

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>
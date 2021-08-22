<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);

$php_file = $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/frontend/files/'.$data['content']['file_name'];

if (!file_exists($php_file)) {
	echo json_encode(array('answer' => 'success', 'file_name' => '<div style="color:#ff0000;">Файл '.$data['content']['file_name'].' не существует!</div>', 'code' => ''));
	exit;
}

$f = fopen($php_file, 'r');
$code = fread($f, filesize ($php_file));
fclose ($f);

echo json_encode(array('answer' => 'success', 'file_name' => $data['content']['file_name'], 'code' => $code));
exit;
?>
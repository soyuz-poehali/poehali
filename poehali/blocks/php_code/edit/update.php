<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$code = trim($_POST['code']);

$content = $BLOCK_E->getBlock($id)['content'];

$file_name = $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/frontend/files/'.$content['file_name'];

$f_hdl = @fopen($file_name, 'w');
fwrite($f_hdl, $code);
fclose($f_hdl);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>
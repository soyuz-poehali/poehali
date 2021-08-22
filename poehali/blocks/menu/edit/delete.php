<?php
defined('AUTH') or die('Restricted access');

$page_id = intval($_POST['p']);
$block_id = intval($_POST['id']);

$stmt = $db->prepare("SELECT content FROM blocks WHERE id = :id AND page_id = 0 AND type = 'menu'");
$stmt->execute(array('id' => $block_id));
if($stmt->rowCount() == 0) {
	echo json_encode(array('answer' => 'error'));
	exit;	
}
$s = $stmt->fetchColumn();

$content = unserialize($s);

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/0/menu';

// УДАЛЯЕМ ФОН
if($content['bg_image'] == 'i') {
	$file_old = $dir.'/background/'.$content['bg_image'];
	if(is_file($file_old)) 
		unlink($file_old);
}

// УДАЛЯЕМ ЛОГО
$file_old = $dir.'/logo/logo.png';
if(is_file($file_old)) 
	unlink($file_old);


$stmt_delete = $db->prepare("DELETE FROM blocks WHERE id = :id AND type = 'menu'");
$stmt_delete->execute(array('id' => $block_id));

echo json_encode(array('answer' => 'success'));
exit;

?>
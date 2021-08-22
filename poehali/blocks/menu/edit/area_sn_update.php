<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$pub = intval($_POST['pub']);
$vk = trim(htmlspecialchars(strip_tags($_POST['vk'])));
$fb = trim(htmlspecialchars(strip_tags($_POST['fb'])));
$youtube = trim(htmlspecialchars(strip_tags($_POST['youtube'])));
$instagramm = trim(htmlspecialchars(strip_tags($_POST['instagramm'])));

$content = $BLOCK_E->getBlock($id)['content'];

if ($vk.$fb.$youtube.$instagramm == '')
	$pub = 0;

$content['sn']['pub'] = $pub;
$content['sn']['vk'] = $vk;
$content['sn']['fb'] = $fb;
$content['sn']['youtube'] = $youtube;
$content['sn']['instagramm'] = $instagramm;

$BLOCK_E->updateBlockContent($id, $content);
echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>
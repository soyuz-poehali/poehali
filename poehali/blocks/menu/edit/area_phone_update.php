<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$type = intval($_POST['type']);
$pub = intval($_POST['pub']);
$phone = trim(htmlspecialchars(strip_tags($_POST['phone'])));
$color = $_POST['color'];
$whatsapp = intval($_POST['whatsapp']);
$viber = intval($_POST['viber']);

$content = $BLOCK_E->getBlock($id)['content'];

$phone_arr = $type == 1 ? $content['phone_1'] : $content['phone_2'];

if ($phone == '')
	$pub = 0;

$phone_arr['pub'] = $pub;
$phone_arr['phone'] = $phone;
$phone_arr['color'] = $color;
$phone_arr['whatsapp'] = $whatsapp;
$phone_arr['viber'] = $viber;

if ($type == 1) 
	$content['phone_1'] = $phone_arr;
if ($type == 2) 
	$content['phone_2'] = $phone_arr;

$BLOCK_E->updateBlockContent($id, $content);
echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>
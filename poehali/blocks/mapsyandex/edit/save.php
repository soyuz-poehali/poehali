<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$map = json_decode($_POST['map']);
$content['zoom'] = intval($_POST['zoom']);
$points = json_decode($_POST['points']);

$coord[0] = ($map[1][0] + $map[0][0])/2;
$coord[1] = ($map[1][1] + $map[0][1])/2;

$content['coordinate'] = $coord;

if (count($points) > 0) 
	$content['points'] = $points;
else 
	$content['points'] = false;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'content' => '<h2>Карта сохранена</h2><div style="text-align:center;"><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Ок."></div>'));
exit;
?>
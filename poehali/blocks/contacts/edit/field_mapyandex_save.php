<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$map = json_decode($_POST['map']);
$zoom = intval($_POST['zoom']);
$points = json_decode($_POST['points']);

$content = $BLOCK_E->getBlock($id)['content'];

$coord[0] = ($map[1][0] + $map[0][0])/2;
$coord[1] = ($map[1][1] + $map[0][1])/2;

$i = 0;
foreach ($content['fields'] as $field) {
	if ($field['type'] == 'mapyandex') {
		$content['fields'][$i]['coordinate'] = $coord;
		$content['fields'][$i]['zoom'] = $zoom;
		if (count($points) > 0) 
			$content['fields'][$i]['points'] = $points;		
		continue;
	}
	$i++;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'content' => '<h2>Карта сохранена</h2><div style="text-align:center;"><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Ок."></div>'));
exit;
?>
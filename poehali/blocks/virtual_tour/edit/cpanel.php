<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="virtual_tour" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/virtual_tour/edit/template/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Панорама 360&deg;</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>
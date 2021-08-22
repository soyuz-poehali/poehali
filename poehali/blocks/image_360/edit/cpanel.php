<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="image_360" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/image_360/edit/template/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Изображение 360&deg;</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>
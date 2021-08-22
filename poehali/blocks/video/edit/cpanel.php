<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="video" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/video/edit/template/1/preview.png"></div>'.	
'</div>'.
'<div class="e_cpanel_additional_items" data-type="video" data-style="2">'.
		'<div class="e_cpanel_additional_wrap"><img src="/blocks/video/edit/template/2/preview.png"></div>'.	
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>
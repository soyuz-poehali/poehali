<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="scrolling_vertical" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/scrolling_vertical/edit/template/1/preview.png"></div>'.	
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>
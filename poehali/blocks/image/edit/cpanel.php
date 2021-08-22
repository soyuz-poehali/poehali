<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="image" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/image/edit/template/1/preview_1.png"></div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="image" data-style="2">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/image/edit/template/2/preview_2.png"></div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="image" data-style="3">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/image/edit/template/1/preview_3.png"></div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="image" data-style="4">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/image/edit/template/2/preview_4.png"></div>'.
'</div>';
echo json_encode(array('answer' => 'success', 'content' => $content));

?>
<?php
defined('AUTH') or die('Restricted access');

$html = 
'<div class="e_cpanel_additional_items" data-type="case_2" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/case_2/edit/template/1/preview.png"></div>'.	
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));

?>
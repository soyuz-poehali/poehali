<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="text" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/1/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по левому краю</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="2">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/2/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="3">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/3/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="4">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/4/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="5">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/5/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="6">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/6/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="7">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/7/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="8">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/8/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="9">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/9/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="10">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/10/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="11">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/11/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="text" data-style="12">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/text/edit/template/12/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Текст с заголовком по центру</div>'.
'</div>';



echo json_encode(array('answer' => 'success', 'content' => $content));

?>
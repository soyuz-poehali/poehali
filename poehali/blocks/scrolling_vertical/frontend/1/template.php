<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/scrolling_vertical/frontend/1/BLOCK.scrolling_vertical_1.css');
$SITE->setHeadFile('/blocks/scrolling_vertical/frontend/1/BLOCK.scrolling_vertical_1.js');

function block_scrolling_vertical_1($data)
{
	global $SITE;
	$content = $data['content'];

	$text_wtap_class = $content['max_width'] != 100 ? 'block_scrolling_vertical_text_wrap' : 'block_scrolling_vertical_text_wrap_100';

	$out = 
		'<div class="'.$text_wtap_class.'">'.$content['text'].'</div>'.
		'<div class="block_scrolling_vertical_image_wrap" style="height:'.$content['height'].'px;">'.
			'<img class="block_scrolling_vertical_image" src="/files/pages/'.$data['page_id'].'/scrolling_vertical/'.$content['image'].'">'.
		'</div>';

	return $out;
}

?>
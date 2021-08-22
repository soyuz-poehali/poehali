<?php
defined('AUTH') or die('Restricted access');

function block_video_1($data)
{
	$content = $data['content'];
	$video_out = '';

	$i = 1;
	foreach ($content['videos'] as $video) {
		if ($video['ratio'] == 2) 
			$youtube_ratio_padding = 'style="padding-bottom:75%;"';
		else  
			$youtube_ratio_padding = '';

		if (!empty($content['padding'])) 
			$youtube_padding = 'padding:'.$content['padding'].'px;';
		else 
			$youtube_padding = '';

		if (!empty($youtube_padding)) 
			$youtube_style = 'style="'.$youtube_padding.'"';
		else 
			$youtube_style = '';

		$block_youtube_wrap = empty($video['text']) ? '' : '<div class="block_video_text">'.$video['text'].'</div>';

		$video_out .= 
		'<div class="dan_flex_grow_1 e_block_item" '.$youtube_style.'>'.
			$block_youtube_wrap.
			'<div class="block_youtube_wrap">'.
				'<div class="dan_youtube" '.$youtube_ratio_padding.'><iframe style="width:560px; height:315px;" src="'.$video['url'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'</div>'.
		'</div>';
		$i++;
	}

	return $video_out;
}

?>
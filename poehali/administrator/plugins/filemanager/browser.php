<?php
defined("AUTH") or die("Restricted access");
$head = '<script type="text/javascript">var v = "'.$vl_r.'"; var d="'.encode($dir).'"; '.$sort_js.';</script>';

$p_arr = explode('/', $dir);
$p = ''; // путь
$p_up = ''; // директория наверх 
$path = ''; // breadcrumbs
$count = count($p_arr);
$i = 0;

// foreach почемуто влияет на openssl_encrypt, его нельзя использовать тут
for ($i = 0; $i < $count; $i++) {
	$p = $p == '' ? $p_arr[$i] : '/'.$p_arr[$i];

	$path .= '<svg class="path_s"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#arrow"></use></svg><a href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($p).$sort.'">'.$p_arr[$i].'</a>';	
	if($i == ($count - 2))  // директория в кнопке наверх
		$p_up = $p;
}

// Разделяем внутренние папки слешами.
$dir_p = $dir != '' ? '/'.$dir : '';

$ico_big_folder = $ico_big_file = '';


// Папки внутри директории
if (is_dir($root.$dir_p)) {
	if ($count > 0)	{  // Выводим стрелку наверх, если это не последний раздел
		$path_name = $count > 1 ? $p_arr[$count - 2] : '';
		
		$ico_big_folder = '<div class="ico_container_up"><div class="ico_i"><a class="ico_a_folder" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($p_up).$sort.$cke_rq.'"><svg class="ico_big_up"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#up"></use></svg></a></div><div class="ico_big_text"><a class="ico_a_folder" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($p_up).$sort.$cke_rq.'">'.$path_name.'</a></div></div>';			
	}

	$file_arr = scandir($root.$dir_p);

	// --- Сортировка по дате ---
	if ($s == 'd') {
		$folder_a_dt = array();
		$file_a_dt = array();

		foreach ($file_arr as $file) {		
			if (!($file == '.' || $file == '..')) {
				$dt = filemtime($root.$dir_p.'/'.$file);
				// В качестве ключа указываем имя файла - оно уникально, а время может быть не уникальным.
				if (is_dir($root.$dir_p.'/'.$file)) 
					$folder_a_dt[$file] = $dt;
				else 
					$file_a_dt[$file] = $dt;		
			}
		}

		asort($folder_a_dt);
		asort($file_a_dt);

		// Теперь нам надо сделать значением имя файла вместо даты
		// Папки
		$folder_arr_dt = array();
		foreach ($folder_a_dt as $key => $value) {
			$folder_arr_dt[] = $key;
		}

		// Файлы
		$file_arr_dt = array();
		foreach ($file_a_dt as $key => $value) {
			$file_arr_dt[] = $key;
		}

		$file_arr = array_merge($folder_arr_dt, $file_arr_dt);
	}


	foreach($file_arr as $file) {
    	if ($file != '.' && $file != '..' && $file != '.htaccess') {
			if (is_dir($root.$dir_p.'/'.$file)) {
				$ico_big_folder .= '<div class="ico_container" data-type="d" data-name="'.$file.'"><div class="ico_i"><a class="ico_a_folder" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($dir.'/'.$file).$sort.$cke_rq.'"><svg class="ico_big_folder"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#folder"></use></svg></a></div><div class="ico_big_text"><a class="ico_a_folder" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($dir.'/'.$file).$sort.$cke_rq.'">'.$file.'</a></div></div>';				
			} else {
				// Разбиваем на расширения	
				$file_l = strtolower($file); // переводим в нижний регистр
				$file_arr = preg_split('/\./', $file_l, -1 , PREG_SPLIT_NO_EMPTY); 

				$file_char = '';

				if(isset($file_arr[1])) {
					switch ($file_arr[1]) {
						case 'jpg': case 'jpeg': case 'gif': case 'png': case 'webp';
							$img_arr = getimagesize($root.$dir_p.'/'.$file);
							$file_char = $img_arr[0].' х '.$img_arr[1].'px<br>';
							$file_ico = '<img class="ico_img" src="/files/'.$dir_p.'/'.$file.'">';
							break;

						case 'doc': case 'docx': case 'rtf': case 'odt':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#text"></use></svg>';
							break;

						case 'text':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#text"></use></svg>';
							break;

						case 'xls': case 'xlsx': case 'csv':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#text"></use></svg>';
							break;

						case 'pdf':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#pdf"></use></svg>';
							break;

						case 'rar': case 'zip': case '7z':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#zip"></use></svg>';
							break;

						case 'mp3': case 'wav':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#audio"></use></svg>';
							break;
							
						case 'avi': case 'mpg': case 'mpeg': case 'webm': case 'mp4': case 'ogg': case 'ogm':
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#video"></use></svg>';
							break;

						default:
							$file_ico = '<svg class="ico_big_file"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#default"></use></svg>';
							break;
					}
				}

				$file_char .= intval((filesize($root.$dir_p.'/'.$file)/1000)).' КБ<br>';
				$file_char .= date ("d-m-Y", filemtime($root.$dir_p.'/'.$file)).'<br>'.date ("H:i:s", filemtime($root.$dir_p.'/'.$file));	

				$ico_big_file .= '<div class="ico_container"  data-type="f" data-name="'.$file.'"><div class="ico_i"><a class="ico_a_file" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($dir.'/'.$file).'&a=e'.$cke_rq.'">'.$file_ico.'</a></div><div class="ico_big_text"><a class="ico_a_file" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($dir.'/'.$file).'&a=e'.$cke_rq.'">'.$file.'</a><br><span class="ico_files_char">'.$file_char.'</span></div></div>';					
			}
		}
	}
} else {
	$ico_big = 'Нет такой директории';
}

$ico_big = $ico_big_folder.$ico_big_file;

$_out = '';
$tree_out = tree('', 0, $cke_rq);


// Дерево папок слева
function tree($_dir, $_level, $cke_rq)
{
	global $root, $FM_dir, $vl_r, $p_arr, $sort, $_out;
	
	if (is_dir($root.'/'.$_dir)) {
		$file_arr = scandir($root.'/'.$_dir);

		foreach ($file_arr as $file) {
			if ($file != '.' && $file != '..') {
				
				if($_dir != '') 
					$_dir = $_dir.'/';
				
				$path = $_dir.$file;
				$path = preg_replace('/(\/){2,}/','/',$path); // удаляем двойные слеши
				
				if (is_dir($root.'/'.$path)) { 
					if(isset($p_arr[$_level]) && $p_arr[$_level] == $file) 
						$ico_folder = '<svg class="tree_ico"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#folder_open"></use></svg>'; 
					else 
						$ico_folder = '<svg class="tree_ico"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'.$FM_dir.'tmp/sprite.svg#folder"></use></svg>';

					$_out .= '<div class="tree_container" data-l="'.$_level.'" data-n="'.$file.'"><a class="level_'.$_level.'" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($path).$sort.$cke_rq.'">'.$ico_folder.'</a><a class="tree_a_text" href="'.$FM_dir.'index.php?v='.$vl_r.'&d='.encode($path).$sort.$cke_rq.'">'.$file.'</a></div>';	
					$_level++;		
					tree($path, $_level, $cke_rq);
					$_level--;
				}
			}
		}
	}
	return $_out;
}

include($_SERVER['DOCUMENT_ROOT'].''.$FM_dir.'tmp/tmp_browser.php');
?>
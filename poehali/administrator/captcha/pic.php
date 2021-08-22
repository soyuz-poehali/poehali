<?

define("code_dir", "../captcha/codegen/");

// создание кода, отправка данных в сессию ========================================================


function generate_code()
{
	$cde = rand(1000, 1999);

	session_start();
	$_SESSION['code'] = $cde;

	return $cde;
} 

// ================================================================================================

function img_code()
{
	// Что бы не кэшировалась картинка
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
	header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");  // 1 января 1970
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);  // Еще раз, для надежности
	header("Pragma: no-cache");  // HTTP/1.0
	header("Content-Type:image/png");
	 
	$linenum = 5; // Число линий (для шума в картинке)
	$img_arr = array( // Массив с именами файлов-фонов
	                 "codegen.png",
	                 "codegen0.png"
	                );
	$font_arr = array(); // Массив со шрифтами
	$font_arr[0]["fname"] = "1.ttf";
	$font_arr[0]["size"] = 18;
	$font_arr[1]["fname"] = "2.ttf";
	$font_arr[1]["size"] = 28;
	$font_arr[2]["fname"] = "3.ttf";
	$font_arr[2]["size"] = 24;
	$font_arr[3]["fname"] = "4.ttf";
	$font_arr[3]["size"] = 24;
	$font_arr[4]["fname"] = "5.ttf";
	$font_arr[4]["size"] = 40;
	 
	$n = rand(0,sizeof($font_arr)-1); // Выбираем шрифт
	$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)]; // Выбираем фон
	 
	$im = imagecreatefrompng(code_dir . $img_fn); // Загружаем фон
	
	// Шум в виде линий
	for ($i=0; $i<$linenum; $i++) {
	    $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
	    imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
	}
	 
	$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // Цвет текста
	imagettftext ($im, $font_arr[$n]["size"], rand(-4, 4), rand(3, 10), rand(25, 30), $color, code_dir.$font_arr[$n]["fname"], generate_code()); // Сам текст в пределах картинки
	 
	ImagePNG ($im); // Вывод изображения
	ImageDestroy ($im); // Освобождаем память
} 

img_code();
?>
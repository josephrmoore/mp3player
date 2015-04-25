<?php

require_once('getid3/getid3.php');

$file = $_GET['song'];
$filename = explode(".", $file);
$json = getcwd() . "/json/" . $filename[0] . ".json";
$string = @file_get_contents($json);
$obj = json_decode($string, true);
$has_image = false;
$has_css = false;
$image_type = false;

$image_file_jpg_path = getcwd() . "/../images/singlepages/" . $filename[0] . ".jpg";
$image_file_png_path = getcwd() . "/../images/singlepages/" . $filename[0] . ".png";
$image_file_gif_path = getcwd() . "/../images/singlepages/" . $filename[0] . ".gif";
$css_file_path = getcwd() . "/../css/singlepages/" . $filename[0] . ".css";

$image_jpg = @file_get_contents($image_file_jpg_path);
$image_png = @file_get_contents($image_file_png_path);
$image_gif = @file_get_contents($image_file_gif_path);
$css = @file_get_contents($css_file_path);

if(is_string($css)){
	$has_css = true;
}

if(is_string($image_jpg) || is_string($image_png) || is_string($image_gif)){
	$has_image = true;
	if(is_string($image_jpg)){
		$image_type = "jpg";
	}
	if(is_string($image_png)){
		$image_type = "png";
	}
	if(is_string($image_gif)){
		$image_type = "gif";
	}
}


?>

<html charset="utf-8">
<head>
	<title><?=$obj["title"]?></title>
	<?php if($has_css) { ?>
	<link rel="stylesheet" href="../player/css/singlepages/<?=$filename[0]?>.css" type="text/css" media="all" />
	<?php } ?>
</head>

<body>
	<div id="wrapper">
		<h1><?=$obj["title"]?></h1>
		<span>By</span>
		<h2><?=$obj["artist"]?></h2>
		<span>From</span>
		<h3><?=$obj["album"]?></h3>
		<?php if($has_image) { ?>
		<img src="../player/images/singlepages/<?=$filename[0].'.'.$image_type?>" alt="Image for <?=$obj["title"]?>" />
		<?php } ?>
		<p><?=$obj["comments"]?></p>
		<audio controls id="mp3Player-player">
			<source id="mp3Player-mp3" src="../../<?=$obj["folder"]?>/<? echo $file ?>" />
			<p class="no-html5">Your browser doesn\'t support HTML5 audio</p>
		</audio>
	</div>
</body>
</html>
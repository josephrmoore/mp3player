<?php

require_once('getid3/getid3.php');

$file = $_GET['song'];
$filename = explode(".", $file);
$json = getcwd() . "/songPages/" . $filename[0] . ".json";
$string = file_get_contents($json);
$obj = json_decode($string, true);
$folder = '../../../' . $_GET['folder'];

?>

<h1><?=$obj["title"]?></h1>
<h2><?=$obj["artist"]?></h2>
<img src="<?=$obj["image"]?>" alt="Image for <?=$obj["title"]?>" />

<audio controls id="mp3Player-player">
	<source id="mp3Player-mp3" src="<? echo $folder ?>/<? echo $file ?>" />
	<p class="no-html5">Your browser doesn\'t support HTML5 audio</p>
</audio>

<?php if(count($obj["links"]) > 0){ ?>
<ul>
<?php foreach($obj["links"] as $link){ ?>
	<li><a href="<?=$link?>"><?=$link?></a></li>
<?php } ?>
</ul>
<?php } ?>
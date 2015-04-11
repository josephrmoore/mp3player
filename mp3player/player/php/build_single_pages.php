<ul>

<?php 
	
$folder = $_GET['mp3Player-folder'];
$DirectoryToScan = '../../../' . $folder;
if($folder){
$files = scandir($DirectoryToScan);
foreach($files as $file){ 
	$pos = strrpos($file, '.') + 1;
	$ext = strtolower(substr($file, $pos));
	$file_root = substr($file, 0, count($file)-5);
	if($file !="." && $file != ".."){
		$json_str = @file_get_contents('songPages/'.$file_root.'.json');
		$json = json_decode($json_str, true);
		if(count($json) == 5){
?>

<li class="song">
	<ul class="field">
		<li class="title">
			<h1 contenteditable="true"><?=$json["title"]?></h1>
		</li>
		<li class="artist">
			<h2 contenteditable="true"><?=$json["artist"]?></h2>
		</li>
		<li class="css">
			<span contenteditable="true"><?=$json["css"]?></span>
		</li>
		<li class="image">
			<img src="<?=$json["image"]?>" alt="Image at: <?=$json["image"]?>" />
			<span contenteditable="true"><?=$json["image"]?></span>
		</li>
		<li class="links">
			<ul>
				<?php for($i=0; $i<count($json["links"]);$i++){ ?>
				<li class="link">
					<a contenteditable="true" href="<?=$json["links"][$i]?>">Link <?=$i?>: <?=$json["links"][$i]?></a>
				</li>
				<?php } ?>
			</ul>
		</li>
	</ul>
</li>
<?php } else {?>

<li class="song">
	<ul class="field">
		<li class="title">
			<textarea></textarea>
		</li>
		<li class="artist">
			<textarea></textarea>			
		</li>
		<li class="css">
			<textarea></textarea>			
		</li>
		<li class="image">
			<textarea></textarea>
		</li>
		<li class="links">
			<ul>
				<li class="link">
					<textarea></textarea>
				</li>
			</ul>
			<button class="new_link">New Link</button>
		</li>
	</ul>
</li>

<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>

</ul>
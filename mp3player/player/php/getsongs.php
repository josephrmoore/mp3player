<?php

require_once('getid3/getid3.php');

$folder = $_GET['mp3Player-folder'];
$DirectoryToScan = '../../../' . $folder;
$audioType = $_GET['mp3Player-audioType'];

$artist = $_GET['mp3Player-artist'];
$album = $_GET['mp3Player-album'];
$title = $_GET['mp3Player-title'];
$track = $_GET['mp3Player-track'];
$length = $_GET['mp3Player-length'];
$genre = $_GET['mp3Player-genre'];
$year = $_GET['mp3Player-year'];
$comments = $_GET['mp3Player-comments'];

$download = $_GET['mp3Player-flag-download'];
$singlePageBool = $_GET['mp3Player-flag-singlePage-isSinglePage'];
$singlePageUrl = $_GET['mp3Player-flag-singlePage-url'];

$totalCols = 0;

?>

<audio id="mp3Player-player">
	<source id="mp3Player-mp3" src="" />
	<p class="no-html5">Your browser doesn\'t support HTML5 audio</p>
</audio>

<div id="mp3Player-controls" class="mp3Player-group playerControls">
	<div id="mp3Player-buttons-container">
		<button id="mp3Player-prev" class="mp3controls disabled">Prev</button>
		<div id="mp3Player-play-pause">
			<button id="mp3Player-play" class="mp3controls">Play</button>
			<button id="mp3Player-pause" class="mp3controls display-off">Pause</button>
		</div>
		<button id="mp3Player-next" class="mp3controls disabled">Next</button>
	</div>

	<div id="mp3Player-progress-container" class="mp3Player-group progressContainer">
		<span id="mp3Player-currentTime"></span>
		<div id="mp3Player-progress" class="loaded"></div>
		<span id="mp3Player-remainingTime"></span>
	</div>

	<div id="mp3Player-volume-container" class="mp3Player-group">
		<span id="mp3Player-min-volume"></span>
		<div id="mp3Player-volume"></div>
		<span id="mp3Player-max-volume"></span>
	</div>
</div>

<table class="sortable" id="mp3Player-table">
	<colgroup>
	<?php if($title == 'true'){ $totalCols++; ?>
		<col class="title" />
	<?php } ?>
	<?php if($artist == 'true'){ $totalCols++; ?>
		<col class="artist" />
	<?php } ?>
	<?php if($album == 'true'){ $totalCols++; ?>
		<col class="album" />
	<?php } ?>
	<?php if($length == 'true'){ $totalCols++; ?>
		<col class="play-time" />
	<?php } ?>
	<?php if($track == 'true'){ $totalCols++; ?>
		<col class="track" />
	<?php } ?>
	<?php if($genre == 'true'){ $totalCols++; ?>
		<col class="genre" />
	<?php } ?>
	<?php if($year == 'true'){ $totalCols++; ?>
		<col class="year" />
	<?php } ?>
	</colgroup>
	<thead>
		<tr class="heading">
			<?php if($title == 'true'){ ?>
				<th>Title</th>
			<?php } ?>
			<?php if($artist == 'true'){ ?>
				<th>Artist</th>
			<?php } ?>
			<?php if($album == 'true'){ ?>
				<th>Album</th>
			<?php } ?>
			<?php if($length == 'true'){ ?>
				<th>Length</th>
			<?php } ?>
			<?php if($track == 'true'){ ?>
				<th>Track</th>
			<?php } ?>
			<?php if($genre == 'true'){ ?>
				<th>Genre</th>
			<?php } ?>
			<?php if($year == 'true'){ ?>
				<th>Year</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
<?php
	
	$getID3 = new getID3;
	
	$files = scandir($DirectoryToScan);
	$totalAudio = 0;
	foreach($files as $file){
		$pos = strrpos($file, '.') + 1;
		$ext = strtolower(substr($file, $pos));
		$file_root = substr($file, 0, count($file)-5);
		if(($file !="." && $file != "..") && $ext==$audioType){
			$totalAudio++;
			$FullFileName = realpath($DirectoryToScan.'/'.$file);
			$json_str = @file_get_contents('songPages/'.$file_root.'.json');
			$json = json_decode($json_str, true);
			if (is_file($FullFileName)) {
				set_time_limit(30);
				$ThisFileInfo = $getID3->analyze($FullFileName);
				getid3_lib::CopyTagsToComments($ThisFileInfo);
				echo '<tr data-file="'.$ThisFileInfo['filename'].'">';
				if($title == 'true'){
					if($audioType == "mp3"){
						if($ThisFileInfo['comments_html']['title']){
							echo '<td class="title">'.$ThisFileInfo['comments_html']['title'][(count($ThisFileInfo['comments_html']['title'])-1)].'</td>';
						} else {
							echo '<td class="title">Unknown Song</td>';
						}
					} else {
						echo '<td class="title">'.$ThisFileInfo['filename'].'</td>';
					}
				}
				if($artist == 'true'){
					if($ThisFileInfo['comments_html']['artist']){
						echo '<td class="artist">'.$ThisFileInfo['comments_html']['artist'][(count($ThisFileInfo['comments_html']['artist'])-1)].'</td>';
					} else {
						echo '<td class="artist">Unknown Artist</td>';
					}
				}
				if($album == 'true'){	
					if($ThisFileInfo['comments_html']['album']){
						echo '<td class="album">'.$ThisFileInfo['comments_html']['album'][(count($ThisFileInfo['comments_html']['album'])-1)].'</td>';
					} else {
						echo '<td class="album">Unknown Album</td>';
					}
				}
				if($length == 'true'){
					echo '<td class="length">'.$ThisFileInfo['playtime_string'].'</td>';
				}
				if($track == 'true'){
					if($ThisFileInfo['comments_html']['track']){
						echo '<td class="track">'.$ThisFileInfo['comments_html']['track'][(count($ThisFileInfo['comments_html']['track'])-1)].'</td>';
					} else {
						echo '<td class="track"></td>';
					}
				}
				if($genre == 'true'){				
					if($ThisFileInfo['comments_html']['genre']){
						echo '<td class="genre">'.$ThisFileInfo['comments_html']['genre'][(count($ThisFileInfo['comments_html']['genre'])-1)].'</td>';
					} else {
						echo '<td class="genre"></td>';
					}
				}
				if($year == 'true'){				
					if($ThisFileInfo['comments_html']['year']){
						echo '<td class="year">'.$ThisFileInfo['comments_html']['year'][(count($ThisFileInfo['comments_html']['year'])-1)].'</td>';
					} else {
						echo '<td class="year"></td>';
					}
				}
				if($download == 'true'){				
					echo '<td class="download"><a href="#">Download</a></td>';	
				}
				if(count($json) > 0){				
					echo '<td class="singlePage"><a target="_blank" href="#">Go to the Song Page</a></td>';	
				}
				echo '</tr>';
			}
			
		}
	}
	
	if($totalAudio == 0){
		if($audioType == "mp3"){
			echo '<tr class="no-mp3s"><td colspan="' . $totalCols . '">Your browser doesn\'t support OGG audio files, and all the songs for this player are OGGs. Perhaps one day browser-makers will stop being stupid and support all common audio formats, making this message unnecessary. In the meantime, you can use Firefox or Opera to listen to this content.</td></tr>';
		} else {
			echo '<tr class="no-oggs"><td colspan="' . $totalCols . '">Your browser doesn\'t support MP3 audio files, and all the songs for this player are MP3s. Perhaps one day browser-makers will stop being stupid and support all common audio formats, making this message unnecessary. In the meantime, you can use Chrome or Safari to listen to this content.</td></tr>';
		}
	}
		
?>
	</tbody>
</table>
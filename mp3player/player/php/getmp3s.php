<audio id="mp3Player-player">
	<source id="mp3Player-mp3" src="" />
	<p class="no-html5">Your browser doesn\'t support HTML5 audio</p>
</audio>

<div id="mp3Player-controls" class="mp3Player-group">
	<div id="mp3Player-buttons-container">
		<button id="mp3Player-prev" class="mp3controls disabled">Prev</button>
		<div id="mp3Player-play-pause">
			<button id="mp3Player-play" class="mp3controls">Play</button>
			<button id="mp3Player-pause" class="mp3controls display-off">Pause</button>
		</div>
		<button id="mp3Player-next" class="mp3controls disabled">Next</button>
	</div>

	<div id="mp3Player-progress-container" class="mp3Player-group">
		<span id="mp3Player-currentTime"></span>
		<div id="mp3Player-progress"></div>
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
		<col class="artist" />
		<col class="title" />
		<col class="album" />
		<col class="play-time" />
	</colgroup>
	<thead>
		<tr class="heading">
			<th>Artist</th>
			<th>Title</th>
			<th>Album</th>
			<th>Length</th>
		</tr>
	</thead>
	<tbody>
<?php

	require_once('getid3/getid3.php');
	require_once('musicfolderpath.php');
	
	$getID3 = new getID3;
	$dir = opendir($DirectoryToScan);
	
	while (($file = readdir($dir)) !== false) {
		$pos = strrpos($file, '.') + 1;
		$ext = strtolower(substr($file, $pos));
		$title = substr($file, 0, $pos-1);
		
		if(($file !="." && $file != "..") && $ext=="mp3"){
			$FullFileName = realpath($DirectoryToScan.'/'.$file);
			
			if (is_file($FullFileName)) {
				set_time_limit(30);
				$ThisFileInfo = $getID3->analyze($FullFileName);
				getid3_lib::CopyTagsToComments($ThisFileInfo);
				echo '<tr data-file="'.$ThisFileInfo['filename'].'">';
				if($ThisFileInfo['comments_html']['artist']){
					echo '<td class="artist">'.implode($ThisFileInfo['comments_html']['artist']).'</td>';
				} else {
					echo '<td class="artist">Unknown Artist</td>';
				}
				if($ThisFileInfo['comments_html']['title']){
					echo '<td class="title">'.implode($ThisFileInfo['comments_html']['title']).'</td>';
				} else {
					echo '<td class="title">Unknown Song</td>';
				}
				if($ThisFileInfo['comments_html']['album']){
					echo '<td class="album">'.implode($ThisFileInfo['comments_html']['album']).'</td>';
				} else {
					echo '<td class="album">Unknown Album</td>';
				}
				echo '<td class="length">'.$ThisFileInfo['playtime_string'].'</td>';
				echo '</tr>';
			}
			
		}
		
	}
	
?>
	</tbody>
</table>
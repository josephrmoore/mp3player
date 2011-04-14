<audio id="player"><source id="mp3" src="" /><p class="no-html5">Your browser doesn\'t support HTML5 audio</p></audio>
<button id="play">Play</button>
<button id="pause">Pause</button>
<button id="next">Next</button>
<button id="prev">Prev</button>
<span id="currentTime"></span>
<span id="remainingTime"></span>
<div id="volume"></div>
<div id="progress"></div>

<table class="sortable" id="sortabletable">
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
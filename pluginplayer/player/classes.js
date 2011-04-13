function Playlist(table){
	console.log('New playlist created');
	this.table = table;
	this.rows = table.find('tbody tr');
	var songs = [];

	for (i=0;i<this.rows.length;i++){
		var song = new Song(this.rows[i]);
		songs.push(song);
	}
	
	this.songs = songs;
}


function Song(row){
	console.log('New song created');
	this.file = $(row).attr('data-file');
	this.title = $(row).find('td.title').text();
	this.album = $(row).find('td.album').text();
	this.artist = $(row).find('td.artist').text();
	this.songLength = $(row).find('td.length').text();
}

function Player(rows){
	console.log('New player created');
	this.totalSongs = rows.length;
	this.currentSong = 0;
	this.object = $('#player');
	this.playSong = playSong;
	this.pauseSong = pauseSong;
	this.loadSong = loadSong;
	this.nextSong = nextSong;
	this.prevSong = prevSong;
}



var playlist;
var player;
var currentSong = 0;

function resetOrder(){
	var table = playlist.table;
	playlist = new Playlist(table);
	player = new Player(playlist.rows);
}

function selectSong(index){
	currentSong = index;
	player.loadSong();
	player.playSong();
}

function nextSong(){
	if(currentSong != (player.totalSongs - 1)){
		++currentSong;
		selectSong(currentSong);
	}
}

function prevSong(){
	if(currentSong != 0){
		--currentSong;
		selectSong(currentSong);
	}
}

function loadSong(){
	var src = 'pluginplayer/music/' + playlist.songs[currentSong].file;
	$('#mp3').attr('src', src).appendTo(player.object);
	this.object[0].load();
}

function playSong(){
	this.object[0].play();
}

function pauseSong(){
	this.object[0].pause();
}

function initButtons(){
	$('#play').click(function(){
		player.playSong();
	});

	$('#pause').click(function(){
		player.pauseSong();
	});

	$('#next').click(function(){
		player.nextSong();
	});

	$('#prev').click(function(){
		player.prevSong();
	});
}	


// next/prev 1 behind when you manually click
// on end go to next song
// scrubber, time, and volume
// allow admin to fill in blanks in ID3s
// style
// clean up / wrap globals
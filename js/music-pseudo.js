function Playlist(table){
	console.log('New playlist created');
	this.rows = table.find('tbody tr');
	
	var songs = [];

	for (i=0;i<this.rows.length;i++){
		var song = new Song(this.row[i]);
		songs.push(song);
	}
	
	this.songs = songs;
	this.player = new Player(rows);
	
}


function Song(row){
	console.log('New song created');
	this.file = row.attr('data-file');
	this.title = row.find('td.title').text();
	this.album = row.find('td.album').text();
	this.artist = row.find('td.artist').text();
	this.length = row.find('td.length').text();
}

function Player(){
	console.log('New player created');
	this.totalSongs = rows.length;
}

var playlist = new Playlist($('#sortabletable'));

// Player.prototype.currentRow = 0; // Default starting current song
// Player.prototype.object = "Player object";
// Player.prototype.mp3 = "Source for mp3 file"
// Player.prototype.sourceTag = "Source tag for the player's song";
// Player.prototype.currentSong = "Player's current song";
// Player.prototype.currentTime = "Player's current time in the song";
// Player.prototype.status = "Paused";
// 
// Player.prototype.play = function(){
// 	this.object.play();
// }
// Player.prototype.pause = function(){
// 	this.object.pause();
// }
// Player.prototype.next = function(){
// 	
// }
// Player.prototype.prev = function(){
// 	
// }
jQuery(document).ready(function($){	
	var playlist;
	var player;
	var currentSong = 0;
	
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
		this.loadSong = function(){
			var src = 'pluginplayer/music/' + playlist.songs[currentSong].file;
			$('#mp3').attr('src', src).appendTo(player.object);
			this.object[0].load();
			playlist.rows.removeClass('current');
			$(playlist.rows[currentSong]).addClass('current');
		}
		this.playSong = function(){
			this.object[0].play();
		};
		this.pauseSong = function(){
			this.object[0].pause();
		};
		this.nextSong = function(){
			if(currentSong != (player.totalSongs - 1)){
				++currentSong;
				selectSong(currentSong);
			}
		};
		this.prevSong = function(){
			if(currentSong != 0){
				--currentSong;
				selectSong(currentSong);
			}
		};
	}

	$('#sortabletable th a').click(function(){
		return true;
	}, function(){
		var table = playlist.table;
		playlist = new Playlist(table);
		player = new Player(playlist.rows);
		playlist.rows.each(function(){
			if($(this).hasClass('current')){
				currentSong = $(this).index();
			}
		});
	});

	function selectSong(index){
		currentSong = index;
		player.loadSong();
		player.playSong();
	}


	function init(rows){

		var current = $('#currentTime');
		var remaining = $('#remainingTime');
		var volumeslider = $('#volume');
		var progress = $('#progress');

		// set clickable on songs
		rows.each(function(){
			$(this).click(function(){
				selectSong($(this).index());
			});
		});

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

		// go to next song 
		player.object[0].addEventListener("ended", function() {										  
			player.nextSong();
		}, true);

		// update time/slider
		player.object[0].addEventListener("timeupdate", function() {
			s=player.object[0].currentTime;
			d=player.object[0].duration;
			var n=(d-s);
			if (s===0){
				current.html("-:--:--");
				remaining.html("-:--:--");
			} else {
				current.html(formatTime(s));
				remaining.html('-' + formatTime(n));
				progress.slider('option', 'value', (Math.floor(((s/d)*1000))/10));
			}		

		}, true);

		// create volume slider
			volumeslider.slider({
				min:0, 
				max:1, 
				step:.1, 
				value:1, 
		//		orientation:'vertical', 
				slide:function(e, ui){
		// on slide, update audio volume value
					player.object[0].volume=ui.value;
				}
			});

		// create progress slider						   
			progress.slider({
				min:0, 
				max:100, 
				step:.1, 
				value:0, 
				slide:function(e, ui){
		// on slide, update current time to slider position
					player.object[0].currentTime = (ui.value/100)*(player.object[0].duration);
				}
			});

		// format time in seconds to the 0:00:00 format needed to display
		function formatTime(s){
			var h=Math.floor(s/3600);
			s=s%3600;
			var m=Math.floor(s/60);
			s=Math.floor(s%60);
			/* pad the minute and second strings to two digits */
			if (s.toString().length < 2) s="0"+s;
			if (m.toString().length < 2) m="0"+m;

			var time = h+":"+m+":"+s;
			return time;
		}
	}
		
	$.ajax({
		url: 'pluginplayer/player/getmp3s.php',
		success: function(data) {
			$('#mp3Player').html(data);
			
			sortables_init();
			
			playlist = new Playlist($('#sortabletable'));
			player = new Player(playlist.rows);
			
			init(playlist.rows);			
			
		}
	});
	
});



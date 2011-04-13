jQuery(document).ready(function($){	
		
	$.ajax({
		url: 'pluginplayer/player/getmp3s.php',
		success: function(data) {
			$('#mp3Player').html(data);
			sortables_init();
			playlist = new Playlist($('#sortabletable'));
			player = new Player(playlist.rows);
			playlist.rows.each(function(){
				$(this).click(function(){
					selectSong($(this).index());
				});
			});
			initButtons();
		}
	});
	
});



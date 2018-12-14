// Get the Wistia Player
window._wq = window._wq || [];

// Apply to all Wistia Videos
_wq.push({ id: "_all", onReady: function( video ) {

	// Get speed from local storage
	var localStorePlayerSpeed = JSON.parse( localStorage.getItem( 'video_speed' ) );

	// If local storage speed exisits, set player speed
	if ( localStorePlayerSpeed !== null ) {
		video.playbackRate( localStorePlayerSpeed );
	}

	// Listen for changes in player speed
	video.bind("playbackratechange", function( playerSpeed ) {

		// Save the updated player speed to local storage
	  	localStorage.setItem( 'video_speed', JSON.stringify( playerSpeed ) );

	});
}});

function initMap() {
       // The function which called by API inside the html to embed living map
	   
	   var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 18,
			  center: {lat:43.25733, lng:-79.9275809}
			});
		var marker =new google.maps.Marker({ // marker for results, color is red 
						  position: {lat:43.25733, lng:-79.9275809},
						  map: map, 
						  title:"Restaurant" // restaurant result title
						});
		var getCurrent_Center = map.getCenter();// get the current center of the map
			google.maps.event.addDomListener(window, 'resize', function() { // resize the map and keep lock the map at the center when the container is resizing
				map.setCenter(getCurrent_Center);
			});		
      }
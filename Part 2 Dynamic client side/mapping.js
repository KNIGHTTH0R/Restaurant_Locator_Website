var locations = []; // prepare a locations array to contain one or more coordinates.
var contents = []; // array for infowindow
var hasUserLocation; // boolean, define whether user location information exist 
function initMap() {
		

			checkCurrentLocation();// check if necessary to draw user location on map 

			locations.push({lat:43.25733, lng:-79.9275809}); // insert sample's coordinates
			/*
			Create Map, center is the user location, and zoom level is 14, can see the street
			*/
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 14,
			  center: locations[0] // if user location exist, center the user location, if no user location exist, center the first result
			});  
		
			
			var sample1_content = '<div id = "content">' +
					'<h1> Mr.Gao Restaurant </h1>' +
					'<p> rate: +1024 </p>'+
					'<p> <a href="individual_sample.html">See more details by clicking here</a> </p>' +
					'</div>'; // sample's information
			contents.push(sample1_content); // insert into content array
			var infowindow = new google.maps.InfoWindow(); // create infowindow
			var marker; // create marker variable
			for (var i=0;i<locations.length;i++){ // create all markers in a loop
				if (i==0 && hasUserLocation){ // user information if need
						  marker = new google.maps.Marker({
						  position: locations[i],
						  map: map,
						  icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png', // blue marker for user 
						  title:"Your Location" // title of user marker
						});
						
						
				}else{
						marker = new google.maps.Marker({ // marker for results, color is red 
						  position: locations[i],
						  map: map, 
						  title:"Restaurant" // restaurant result title
						});
				}
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
						  infowindow.setContent(contents[i]); // set the information of infowindow
						  infowindow.open(map, marker); // connect infowindow to marker
						}
					  })(marker, i));
			}
			var getCurrent_Center = map.getCenter();// get the current center of the map
			google.maps.event.addDomListener(window, 'resize', function() { // resize the map and keep lock the map at the center when the container is resizing
				map.setCenter(getCurrent_Center);
			});					
}

function checkCurrentLocation(){


	if (JSON.parse(sessionStorage.bool)){			
				hasUserLocation =true;
				var user_lat = JSON.parse(sessionStorage.lat); // take the user lat
				var user_lng = JSON.parse(sessionStorage.lng); // take the user lng
				var coordinate = {lat:user_lat, lng:user_lng}; // current location coordinates
				locations.push(coordinate); // insert user location into location array
				var user_location_content = '<div id = "content">' +
					'<h1> Your Location </h1>' +
					'<p> This is your location </p>' +
					'</div>'; // user's current location information
				contents.push(user_location_content);// insert into content array
	}else{
		hasUserLocation =false;
	}
}
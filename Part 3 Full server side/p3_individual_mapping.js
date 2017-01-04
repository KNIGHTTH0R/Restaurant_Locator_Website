var havedate =false;
var slat;
var slng;
function initMap() {
       // The function which called by API inside the html to embed living map
       if (!havedate){// data data isn't exist
       		getdata();//call function to get data
       }
       else{// data exist, continue the map
       	var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 18,
			  center: {lat:slat, lng:slng}
			});
		var marker =new google.maps.Marker({ // marker for results, color is red 
						  position: {lat:slat, lng:slng},
						  map: map, 
						  title:"Restaurant" // restaurant result title
						});
		var getCurrent_Center = map.getCenter();// get the current center of the map
			google.maps.event.addDomListener(window, 'resize', function() { // resize the map and keep lock the map at the center when the container is resizing
				map.setCenter(getCurrent_Center);
			});	
       }
	   
	   	
      }

function getdata(){// get the data which is saved individual_sample.php
	//separate the location string, get latitude, longtitude
	slat = Number(locationFromPhp.split(",")[0].trim());
	slng = Number(locationFromPhp.split(",")[1].trim());
	havedate =true;
	initMap();// continue to generate the map
}


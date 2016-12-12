function load() {

	//Création Google Maps
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(42.3094, 9.1490),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.TERRAIN
      });
      var directionsService = new google.maps.DirectionsService();
      var directionsDisplay = new google.maps.DirectionsRenderer();
      directionsDisplay.setMap(map);

	//Function d'affichage des marqueurs sur la google maps
      function locationsMarkers() {

	   google.maps.Map.prototype.clearMarkers = function() {
          for(var i=0; i < this.markers.length; i++){
            this.markers[i].setMap(null);
          }
          this.markers = new Array();
        };

        $.ajax({
              url: 'get-locations.php',
              success:function(data){
                  //Loop through each location.
                  $.each(data, function(){
                      //Plot the location as a marker
                      var pos = new google.maps.LatLng(this.latitude, this.longitude); 
                      new google.maps.Marker({
                          position: pos,
                          map: map
                      });
                  });
              }
          });
      }
 
      locationsMarkers();

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        console.log(waypts);
        $.ajax({
              url: 'get-locations.php',
              success:function(data){
                  //Loop through each location.
                  $.each(data, function(){
                      //Plot the location as a waypoint
                      var pos = new google.maps.LatLng(this.latitude, this.longitude); 
                      waypts.push({
                        location: pos,
                        stopover: true
                      });
                  });
              }
          });
         console.log(waypts.length);
         console.log(waypts);
        /*directionsService.route({
          origin: waypts[0],
          destination: waypts[waypts.length-1],
          waypoints: waypts,
          travelMode: 'WALKING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });*/
      }

      calculateAndDisplayRoute(directionsService, directionsDisplay);

	//Fonction permettant l'affichage des informations sur l'objet
      function showDevices() {
    	document.getElementById("txtHint").innerHTML = "";
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","locations.php",true);
        xmlhttp.send();
    }

    showDevices();
  }

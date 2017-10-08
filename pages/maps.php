
<?php session_start(); include ('head.php'); ?>

<?php 
$ul_index = ""; $ul_maps = "active";
include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>




                               



    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>



function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: 8.0189375, lng: 124.2884561},
    mapTypeId: 'terrain'
  });

  // Define the LatLng coordinates for the polygon's path.
  var triangleCoords = [
    

    {lat: 7.984264, lng: 124.239535},
    {lat: 8.065855, lng:  124.304766},
    {lat:  8.023701, lng: 124.355749},
    {lat:  7.982224, lng:  124.270434}
  ];

  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
  bermudaTriangle.setMap(map);
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0cHhd095UrYXZJU4qD6N0lQ2nkpT_Qz4&callback=initMap"
    async defer></script>





    </div>
</div>
</div>
</div>






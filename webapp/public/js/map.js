window.onload = function () {
    var map = L.map("map").setView([51.505, -0.09], 5);

// Add a tile layer to the map
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var inputLAT = document.getElementById("lat");
    var inputLNG =  document.getElementById("lng");
    var marker = null;

// Wait for the map to be fully loaded before interacting with it
    map.on("click", function(event) {
        // Get the coordinates of the clicked location
        var lat = event.latlng.lat;
        var lng = event.latlng.lng;

        // If there is already a marker, remove it from the map
        if (marker) {
            map.removeLayer(marker);
        }

        // Do something with the coordinates (e.g., display them in an alert)
        marker = L.marker([lat, lng]).addTo(map);
        inputLAT.value = lat
        inputLNG.value = lng
    });
}


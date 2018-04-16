/*getCoordinates permet de récupérer la latitude et la longitude du pays choisi pour que la carte soit
 centré sur le pays dès le chargement de la page */


function getCoordinates(geocoder,addresse,callback){
    var coordinates;
    geocoder.geocode({'address': addresse}, function (results,status) {
        coords_obj=results[0].geometry.location;
        coordinates=[coords_obj.lat(),coords_obj.lng()];
        callback(coordinates);
    })

}

var map;

function initMap() {

    var adresse = document.getElementById("adresse").value;
    var pays = document.getElementById("pays").value;
    var ville = document.getElementById("ville").value;
    var mapCanvas = document.getElementById("map");
    var geocoder = new google.maps.Geocoder;

    if(adresse)
    {
    if (adresse==ville) {
        getCoordinates(geocoder, adresse, function (coords) {
            //options de la carte : zoom et centre
            var mapOptions = {
                zoom: 11,
                center: new google.maps.LatLng(coords[0], coords[1])
            };
            map = new google.maps.Map(mapCanvas, mapOptions);

        });
    }

    if (adresse==pays)
    {
        if(adresse=="Canada"||adresse=="États-Unis"||adresse=="Brésil"||adresse=="Argentine")
        {
            getCoordinates(geocoder, adresse, function (coords) {
                //options de la carte : zoom et centre
                var mapOptions = {
                    zoom: 3,
                    center: new google.maps.LatLng(coords[0], coords[1])
                };
                map = new google.maps.Map(mapCanvas, mapOptions);

            });
        }
        else if(adresse=="Chine"||adresse=="Inde"||adresse=="Australie"||adresse=="Algérie")
        {
            getCoordinates(geocoder, adresse, function (coords) {
                //options de la carte : zoom et centre
                var mapOptions = {
                    zoom: 4,
                    center: new google.maps.LatLng(coords[0], coords[1])
                };
                map = new google.maps.Map(mapCanvas, mapOptions);

            });
        }

        else if(adresse=="Russie")
        {
            getCoordinates(geocoder, adresse, function (coords) {
                //options de la carte : zoom et centre
                var mapOptions = {
                    zoom: 2,
                    center: new google.maps.LatLng(coords[0], coords[1])
                };
                map = new google.maps.Map(mapCanvas, mapOptions);

            });
        }

        else
        {
            getCoordinates(geocoder, adresse, function (coords) {
                //options de la carte : zoom et centre
                var mapOptions = {
                    zoom: 5,
                    center: new google.maps.LatLng(coords[0], coords[1])
                };
                map = new google.maps.Map(mapCanvas, mapOptions);

            });
        }

    }
    }

    else {

        //options de la carte : zoom et centre
        var mapOptions = {
            center: new google.maps.LatLng(51.5, -0.2),
            zoom: 1

        };
        map = new google.maps.Map(mapCanvas, mapOptions);

    }


}
google.maps.event.addDomListener( window, 'load', initMap());







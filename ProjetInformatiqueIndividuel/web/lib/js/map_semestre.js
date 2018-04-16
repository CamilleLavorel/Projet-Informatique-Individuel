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
    var mapCanvas = document.getElementById("map");
    var ville = document.getElementById("ville").value;
    var geocoder = new google.maps.Geocoder;
    var universite = document.getElementById("universite").value;
    var nom_universite= document.getElementById("nom_universite").value;
    var logement=document.getElementById("logement").value;

    if(ville =="Quebec" || ville=="Québec")
    {
        console.log(ville);
        ville='Ville de Québec';
    }

    /*Récupére la latitude et la longitude de la ville où a été effectué le stage
     et centre la carte sur cette ville dès le chargement de la page */
    getCoordinates(geocoder,ville, function (coords) {
        //options de la carte : zoom et centre
        var mapOptions = {
            zoom: 11,
            center: new google.maps.LatLng(coords[0], coords[1])
        };

        map = new google.maps.Map(mapCanvas, mapOptions);
    });

    /* AJOUT DUN MARQUEUR POUR L'ENTREPRISE */
    /*Récupére la latitude et la longitude de l'université associée au semestre pour créer un marqueur
     sur la carte à cet endroit dès le chargement de la page */
    getCoordinates(geocoder,universite,function (coords){

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(coords[0], coords[1]),
            map: map,
            title:nom_universite,
            label:'U'

        });

        /*Lors du clic sur le markeur, zoom sur l'adresse de l'université + fenetre avec le nom de l'université */
        google.maps.event.addListener(marker,'click',function() {
            var infowindow = new google.maps.InfoWindow({
                content:"Université : " + nom_universite
            });
            var pos = map.getZoom();
            map.setZoom(15);
            map.setCenter(marker.getPosition());
            window.setTimeout(function() {map.setZoom(pos);},3000);
            infowindow.open(map,marker);
        });
    });


    /* AJOUT DUN MARQUEUR POUR LE LOGEMENT */
    /*Récupére la latitude et la longitude du logement associée au semestre pour créer un marqueur
     sur la carte à cet endroit dès le chargement de la page */
    getCoordinates(geocoder,logement,function (coords){

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(coords[0], coords[1]),
            map: map,
            title:'logement',
            label:'L'

        });

        /*Lors du clic sur le markeur, zoom sur l'adresse du logement */
        google.maps.event.addListener(marker,'click',function() {
            var infowindow = new google.maps.InfoWindow({
                content:"Logement"
            });
            var pos = map.getZoom();
            map.setZoom(15);
            map.setCenter(marker.getPosition());
            window.setTimeout(function() {map.setZoom(pos);},3000);
            infowindow.open(map,marker);
        });
    });
}

google.maps.event.addDomListener( window, 'load', initMap());



function initializeAutocomplete(id) {
    var element = document.getElementById(id);
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}


function onPlaceChanged() {
    var place = this.getPlace();

    var type_element_ville = document.getElementById("stage_entreprise_ville" );
    var type_element_pays = document.getElementById("stage_entreprise_pays" );

    type_element_ville.value = null;
    type_element_pays.value = null;

    for (var i in place.address_components) {
        var component = place.address_components[i];
        for (var j in component.types) {

            if(component.types[j]=='locality')
            {
                type_element_ville.value = component.long_name;
            }
            if(component.types[j]=='country')
            {
                type_element_pays.value = component.long_name;
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete("stage_entreprise_adresse");
});
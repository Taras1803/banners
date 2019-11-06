ymaps.ready(init);

var contactsMap;

function init(){
    
    /*contactsMap = new ymaps.Map("map", {
        center: [55.704691, 37.624918],
        zoom: 15,
        controls: []
    });*/
    contactsMap = new ymaps.Map("map", {
        center: [55.7915529,37.5148146],
        zoom: 15,
        controls: []
    });
    
    contactsMap.behaviors.disable('scrollZoom');
    contactsMap.behaviors.disable('multiTouch');
    
    contactsMap.controls.add(new ymaps.control.ZoomControl({options: { position: { right: 30, top: 30 }}}));
    
    var office = new ymaps.Placemark([55.7915529,37.5148146], {}, {
        iconLayout: 'default#image',
        iconImageHref: '/template/public/img/marker-yellow.png',
        iconImageSize: [54, 54],
        iconImageOffset: [-27, -27]
    });

    contactsMap.geoObjects.add(office);
    
    var warehouse = new ymaps.Placemark([55.543802, 37.761379], {}, {
        iconLayout: 'default#image',
        iconImageHref: '/template/public/img/marker-orange.png',
        iconImageSize: [54, 54],
        iconImageOffset: [-27, -27]
    });

    contactsMap.geoObjects.add(warehouse);
    
    $('.addresses').scroll(function(e){
        
        var scrollLeft = $(this).scrollLeft();
        
        if( scrollLeft > 50 ){
            
            contactsMap.setCenter([55.546668, 37.750775]);
            
        }
        
        if( scrollLeft == 0 ){
            
            contactsMap.setCenter([55.7915529,37.5148146]);
            
        }
        
    });
    
}

function setMapCenter( $coords ){
    
    if( typeof(contactsMap) != 'undefined' ){
        
        contactsMap.setCenter($coords);
        
    }
    
}
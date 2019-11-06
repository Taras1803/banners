ymaps.ready(init);

var map;

function init(){
    
    var coors = coordinates.split(',');
    
    map = new ymaps.Map("ymap", {
        center: coors,
        zoom: 17,
        controls: []
    });
    
    map.behaviors.disable('scrollZoom');
    map.behaviors.disable('multiTouch');
    
    map.controls.add(new ymaps.control.ZoomControl({options: { position: { right: 30, top: 30 }}}));
    
    
    var varyaLayout = ymaps.templateLayoutFactory.createClass(
        
        '<div class="placemark-layout">'+
            '<div class="radio" style="color: $[properties.color]">'+
                '<div class="inner"></div>'+
            '</div>'+
            '<div class="board-id">$[properties.id]</div>'+
        '</div>'
    );
    
    var object = new ymaps.Placemark(coors, {
    
        id: GID,
        color: marker_color
    
    }, {
        
        iconLayout: varyaLayout,
        
        iconOffset: [-13, -13],

    });

    map.geoObjects.add(object);
    
    
}


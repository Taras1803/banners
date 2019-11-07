ymaps.ready(init);

var map,
    z = parseInt(findGetParameter('z'));

function init(){

    map = new ymaps.Map("map", {
        center: [55.753215, 37.622504],
        zoom: 8,
        controls: []
    });

    map.controls.add(new ymaps.control.ZoomControl({options: { position: { right: 30, bottom: 250 }}}));

    updateMap(boards);
}


function updateMap(objects){

    if (!objects.length) {
        map.geoObjects.removeAll();
        $('#empty-map').fadeIn(300);
        return;
    }
    $('#empty-map').fadeOut(300);
    
    var placemarks = [];

    var total = objects.length;
    
    var clusterLayout = ymaps.templateLayoutFactory.createClass('<div class="cluster-layout">{{ properties.geoObjects.length }}</div>');

    var markerLayout  = ymaps.templateLayoutFactory.createClass(

        '<div class="placemark-layout">' +
            '<div class="radio" style="color: $[properties.color]">' +
                '<div class="inner"></div>' +
            '</div>' +
            '<div class="board-id">$[properties.GID]</div>' +
        '</div>'
    );

    var balloonLayout = ymaps.templateLayoutFactory.createClass(

        '<div class="balloon-layout hidden">' +
            '<div class="content">' +
                '<a target="_blank" href="/boards/detail/$[properties.GID]/"><div class="name"></div></a>' +
                '<div id="ballon-img-wrap"></div>'+
                '<div class="sides"></div>' +
                '<div class="yellow-btn" id="addfavorite">В избранное</div>' +
                '<div class="detail"><a target="_blank" href="/boards/detail/$[properties.GID]/">Подробнее</a></div>' +
            '</div>' +
            '<div class="close-balloon">&times;</div>' +
        '</div>', {

        build: function(){

            var id = this.getData().properties.get('id');

            this.constructor.superclass.build.call(this);

            //подгружаем стороны через ajax, это быстрее чем перебирать все конструкции и делать кучу запросов

            $.getJSON('/boards/getForMap/' + id, function(r){
                var sides = $('.balloon-layout .sides');
                var imgWrap = $('.balloon-layout #ballon-img-wrap');
                var hasSlider = false;

                $('.balloon-layout .name').html(r.board.address);

                r.sides.forEach(function(i,n){
                    // Слайды картинок
                    var sliderHtml = (i.extra_imgs.length) ? '<div class="owl-carousel owl-theme">' : '<div>';
                    sliderHtml += '<a href="'+i['original']+'" data-lightbox="slide'+n+'"> <img src="'+i['small']+'"> </a>';

                    i.extra_imgs.forEach(function(img){
                        sliderHtml += '<a href="'+img['original']+'" data-lightbox="slide'+n+'"> <img src="'+img['small']+'"> </a>';
                    });

                    sliderHtml += '</div>';

                    imgWrap.append(sliderHtml);

                    if (i.extra_imgs.length) hasSlider = true;

                    // Переключатель сторон
                    var sidesHtml = '<div class="side" side-id="' + i.id + '">';
                    sidesHtml += '<div class="checkbox checked"></div>';
                    sidesHtml += 'Сторона ' + i.code + '</div>';

                    sides.append(sidesHtml)
                });


                sides.find('>div')
                .click(function(){
                    $(this).toggleClass('checked');
                })
                .mouseenter(function(){
                    imgWrap.find('> div').eq($(this).index()).css('display', 'block').siblings().css('display', 'none');
                });


                // Делаем поп-ап видимым
                if (hasSlider) {
                    imgWrap.find('.owl-carousel').on('initialize.owl.carousel', function(){
                        $('.balloon-layout').removeClass('hidden');
                    }).owlCarousel({ nav:false, items: 1, dots: true});
                } else {
                    $('.balloon-layout').removeClass('hidden');
                }
            });

            $('#addfavorite').click(function(){

                var sides = [];

                $('.balloon-layout').find('.side.checked').each(function(i, el){

                    sides.push($(el).attr('side-id'));

                });

                addFavorite(sides);

            });

            $('.close-balloon').click(function(){

                map.balloon.close();

            });

        }

    });

    for(var i = 0; i < total; i++){

        var item = objects[i];
        
        if( item.coordinates ){

            var coors = item.coordinates.split(',');

            var placemark = new ymaps.Placemark(coors, {
                id:  item.id,
                GID: item.GID,
                color: item.color,
                address: item.address
            }, {
                iconLayout: markerLayout,
                iconOffset: [-13, -13],
                hideIconOnBalloonOpen: false,
                balloonLayout: balloonLayout,
                iconShape: {
                    type: 'Rectangle',
                    coordinates: [
                        [-26, -26], [70, 70]
                    ]
                }
            });

            placemarks.push(placemark);
        }

    }
    
    map.geoObjects.removeAll();

    var clusterer = new ymaps.Clusterer({ 

        clusterDisableClickZoom: false, 
        clusterIconLayout: clusterLayout,
        clusterShape: {
                type: 'Rectangle',
                coordinates: [
                    [-50, -50], [50, 50]
                ]
            }

    });

    clusterer.add(placemarks);

    map.setBounds(clusterer.getBounds(), { checkZoomRange:true, zoomMargin: 10}).then(function(){
        if (z && !isNaN(z) && map.getZoom() > z)
            map.setZoom(z);
    });

    map.geoObjects.add(clusterer);
}
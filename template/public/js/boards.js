ymaps.ready(init);

var map,
    z = parseInt(findGetParameter('z'));

function init(){

    map = new ymaps.Map("map", {
        center: [55.753215, 37.622504],
        zoom: 8,
        controls: []
    });

    //map.behaviors.disable('scrollZoom');
    //map.behaviors.disable('multiTouch');

    map.controls.add(new ymaps.control.ZoomControl({options: { position: { right: 30, bottom: 250 }}}));


    if (location.search || location.hash) {

        setCheckboxByUrl();

        applyFilters(true);

    } else {

        $.post('/boards/get/', function(r){

            updateMap(r.boards);

        }, 'json');

    }
    
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


                sides.find('>div').click(function(){
                    $(this).toggleClass('checked');
                }).mouseenter(function(){
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
    //console.log('try to remove');

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

    //console.log(placemarks);

    map.setBounds(clusterer.getBounds(), {checkZoomRange:true}).then(function(){
        if (z && !isNaN(z) && map.getZoom() > z)
            map.setZoom(z);
    });

    map.geoObjects.add(clusterer);
    
}


//обновление фильтров и карты

function applyFilters(dontPushHistory){
    
    $('.filters-tabs .tab').each(function(index, tab){
        
        var selected = $(tab).find('.selected').length;
        
        var quantity = $(tab).children('.tab-title').find('.quantity');
        
        if( selected ){
        
            quantity.removeClass('hidden');
            
            quantity.find('.num').html(selected);
            
        } else {
         
            quantity.addClass('hidden');
            
        }
        
    });
    
    var filters = $('#filters-form').serialize();
    
    $('.yandex-map').addClass('loading');


    $.post('/boards/get/', filters, function(r){
       /* console.log(r.boards);
        r.boards.forEach(function(br){
            console.log(br.GID);
        });*/
        updateMap(r.boards);

        if (!dontPushHistory) setSeo(r.seo);

        if (!dontPushHistory) pushStateByFilter(filters);

        $('.yandex-map').removeClass('loading');

    }, 'json');
    
}
//обновление фильтров и карты

function applyFiltersGID(dontPushHistory){
    
    $('.filters-tabs .tab').each(function(index, tab){
        
        var selected = $(tab).find('.selected').length;
        
        var quantity = $(tab).children('.tab-title').find('.quantity');
        
        if( selected ){
        
            quantity.removeClass('hidden');
            
            quantity.find('.num').html(selected);
            
        } else {
         
            quantity.addClass('hidden');
            
        }
        
    });
    
    var filters = $('#filters-form').serializeArray();
 //   console.log(filters[0].value);
    
    $('.yandex-map').addClass('loading');


    $.post('/boards/get/',  function(r){
     //   console.log(r.boards);
        r.boards.forEach(function(br){
            if(br.GID==filters[0].value) {
            	
            	var coors = br.coordinates.split(',');
            //	console.log(coors);
	            	map.setCenter([coors[0],coors[1]], 20, {
	                checkZoomRange: true
	            	});
            }
        });
        //updateMap(r.boards);

        if (!dontPushHistory) setSeo(r.seo);

        if (!dontPushHistory) pushStateByFilter(filters);

        $('.yandex-map').removeClass('loading');

    }, 'json');
    
}



window.onpopstate = function(e){
    setCheckboxByUrl();
    applyFilters(true);
};


// Установить состояние чекбоксов исходя из данных в GET параметрах
function setCheckboxByUrl(){

    var url = location.search,
        hash = location.hash, // Тоже содержит данные
        values = [];

    if (!url && !hash) {

        $('#filters-form input[type=checkbox]').prop('checked', false).prop('checked');
        $('#filters-form label').removeClass('selected');

        return;
    }

    url.split('&').forEach(function(param){
        var param = param.split('='),
            type = param[0].replace('?', '');

        values[type] = [param[1]];
        /* Теперь игнорируем множественные параметры в урле, учитываем только в хеше
        values[type] = [];
        param[1].split(',').forEach(function(value){
            values[type].push(value);
        });
        */
    });

    // Если есть хеш - учитываем из него параметры
    if (hash) {
        hash.substr(1).split('&').forEach(function (param) {
            var param = param.split('='),
                type = param[0].replace('#', '');

            if (values[type] || !param[1]) return; // Если параметр уже взят из url-адреса то не учитываем параметр из хеша

            values[type] = [];
            param[1].split(',').forEach(function (value) {
                values[type].push(value);
            });
        });
    }

    if (!values || !Object.keys(values).length) return;

    $('form input[type="checkbox"]').each(function(){
        var name = $(this).attr('name').replace('[]', '');

        if (values[name] && values[name].indexOf($(this).val()) !== -1) {
            $(this).prop('checked',true);
            $(this).closest('label').addClass('selected');
        } else {
            $(this).prop('checked', false).prop('checked');
            $(this).closest('label').removeClass('selected');
        }
    });
}


// Записываем фильтры в историю
function pushStateByFilter(filters){

    var temp = [];

    filters = filters.replace(/(.+)?keyword.+?&?/g, '').replace(/(%5B%5D|\[\])/g, '');

    if (filters && filters.length) {
        var url = '?',
            hash = '#';

        // Разбираем строку фильтров на понятный массив
        filters.split('&').forEach(function(item){
            item = item.split('=');
            temp[item[0]] ?  temp[item[0]].push(item[1]) : temp[item[0]] = [item[1]];
        });

        // Строим URL по массиву в след. формате - ?type=Schit_3x6&road=A-107#town=Balashiha,Pushkino
        for (var param in temp) {
            if (temp[param].length === 1)
                url += param + '=' + temp[param][0] + '&';
            else
                hash += param + '=' + temp[param].join(',') + '&';
        }

        // Убираем последний символ &
        url = url.substr(0,url.length-1);
        hash = hash.substr(0,hash.length-1);

        // Пушим в историю
        history.pushState(false,null,location.pathname + url + hash);

    } else {
        history.pushState(false,null,location.pathname);
    }
}


function clearSearch(){
    var search = $('.search-field');

    search.find('#keyword').val('');
    search.find('#map-search').val('');
    search.find('#hints').html('');
}


function setSeo(seo){
    // Set SEO text
    document.title = seo.title ? seo.title : 'Карта рекламных конструкций';
    $('.map-wrap h1').text(seo.h1 ? seo.h1 : 'Адресная программа');
    $('#map-seo-text').html((seo.text && seo.text.length > 20) ? '<div>'+seo.text+'</div>' : '');


    // Set SEO links
    var checked = $('.filters-tabs input[type=checkbox]:checked'),
        text = checked.closest('label').text(),
        wrap = $('#extra-links'),
        type = '', html = '';

    if (checked.length != 1 || checked.attr('name') == 'type[]') {
        wrap.html('');
        return;
    }

    type = checked.attr('name').replace('[]', '');

    // Генерация HTML ссылок
    html += '<div class="row">';

    $('.filters-tabs input[name="type[]"]').each(function(){
        var type_name = $(this).parent().find('.name').text();

        html += '<div class="col-md-4">';
            html += '<a href="/boards/?type='+$(this).val()+'&'+type+'='+checked.val()+'" class="extra-link">';
            html += type_name + ' - ' + text;
            html += '</a>';
        html += '</div>';
    });

    html += '</div>';

    wrap.html(html);
}





$('#filters-form').submit(function(e){
    
    e.preventDefault();
    
});


$('.filters-tabs .option input').change(function(){

    $(this).parent().toggleClass('selected');

    clearSearch();

    applyFilters();

});

$('.clear-all').click(function(){

    $('.boards-filters input:checked').prop('checked', false).parent().removeClass('selected');

    clearSearch();

    applyFilters();

});

$('.filters-tabs .select-all').click(function(){

    var tab = $(this).closest('.tab');

    tab.find('input').prop('checked', true).parent().addClass('selected');

    applyFilters();

});



// Вывод подсказок для поиска
var t;
$('#map-search').keyup(function(){
    if (t) clearTimeout(t);

    var inp = $(this),
        val = inp.val(),
        hints = $('#filters-form #hints');
        
        // $.get( "https://search-maps.yandex.ru/v1/?apikey=6aafb34d-6b40-4756-851f-6f4803a1401b&text=ул. Крылатские холмы&results=10&lang=ru_RU", function( data ) {


    t = setTimeout(function(){

        // Если текст, то делаем запрос при 2+ символах, если цифры, то при 1+ символах
        if (isNaN(val) && val.length >= 2 || !isNaN(val) && val.length) {
var html = '';
            $.post('/boards/getSearchHints/', {str: inp.val()}, function (res) {
                
                //console.log( res );
                res = JSON.parse(res);
                hints.html('');

                res.forEach(function(item){

                    var name = (isNaN(item['name'])) ? item['name'] : '# '+item['name'];
                    html += '<li data-keyword="'+item['name']+'">'+name+'</li>';

                });

                hints.html(html);
                $('.search-field .clear-search').fadeIn(300);
            });
            // Только при 2+ символах,
            if (isNaN(val) && val.length >= 2){
                $.get( "https://search-maps.yandex.ru/v1/?apikey=6aafb34d-6b40-4756-851f-6f4803a1401b&ll=37.380035,55.815796&spn=5.060749,2.702728&rspn=1&type=geo&text="+val+"&results=10&lang=ru_RU", function( data ) {
                    //if(!html) { var html = ''; }
                   // console.log(data);
                    res = data.features;
                    res.forEach(function(item){
                        var descr = item.properties.description.split(',');
                        //console.log( item.properties.description );
                        html += '<li data-location="'+item.geometry.coordinates+'">'+item.properties.name+'<span class="map-find-sub">'+descr[0]+'</span></li>';
                    });
                    hints.html(html);
              //  console.log( data.features );
                });
            }

        } else {
            hints.html('');
            $('.search-field .clear-search').fadeOut(300);
        }


         

    },300);
});


// Выбор одной из подсказок для поиска
$(document).on('click', '#hints li', function(){

var loc = $(this).data('location');
$(this).find("span").remove();
var loc_name = $(this).html();
//loc_name = loc_name.find("span").remove();

    var data = $(this).data('keyword'),
        wrap = $(this).parents('.search-field');

        /* центрирование по улице*/
        if( loc ){
        	//console.log(loc_name);
        	//wrap = $(this).parents('.search-field');
             $('.yandex-map').addClass('loading');
            var coors = loc.split(',');
            //console.log([coors[0],coors[1]]);
            map.setCenter([coors[1],coors[0]], 15, {
                checkZoomRange: true
            });
            $('.yandex-map').removeClass('loading');

           wrap.find('#map-search').val(loc_name);
           wrap.find('#hints').html('');

        return false;
        }

//console.log(loc);
    wrap.find('#keyword').val(data);
    wrap.find('#map-search').val(data);
    wrap.find('#hints').html('');

    $('.boards-filters input:checked').prop('checked', false).parent().removeClass('selected');

   applyFiltersGID(true);
});



$('.quantity').click(function(e){

    e.stopPropagation();

    var tab = $(this).closest('.tab');

    tab.find('input').prop('checked', false).parent().removeClass('selected');

    applyFilters();

});

$('.show_filters').click(function(){
    
    $('.boards-filters').css('display', 'block');
        
    $('.modal-bg').removeClass('hidden');
    
    fixSite(1);
    
});

$('.boards-filters .close').click(function(){
    
    $('.boards-filters').css('display', 'none');
    
    $('.modal-bg').addClass('hidden');

    fixSite(0);
    
});


$('.filters-tabs .tab-title').click(function(){
    
    var parent = $(this).parent('.tab');
    
    $(parent).closest('.filters-tabs').children('.tab').not(parent).removeClass('active');
    
    $(parent).toggleClass('active');
    
});

if ($(window).width() >= 1100)
    $('.first-tab').addClass('active');

/*
$(window).resize(function(){

    if( $(window).width() < 992 ){
        
        $('.boards-filters').css('display', 'none');
        
        if(!modalOpen){
    
            $('.modal-bg').addClass('hidden'); 
            
        }
        
    } else {
        
        $('.boards-filters').css('display', 'block');
        
    }

});*/
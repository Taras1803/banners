ymaps.ready(init);

var buildLocationMap, buildPlacemark, inputCoors;

function init() {

    var ymap = document.getElementById('ymap');

    if ( !ymap ) return false;

    var inputCoors = $('#mapcoors');

    $coors = inputCoors.val().split(',');

    if ($coors.length == 1)
        $coors = ['55.74242','37.61798'];
    buildLocationMap = new ymaps.Map(ymap, {
        center: [$coors[0], $coors[1]],
        zoom: 10
    }, {searchControlProvider: 'yandex#search'});


    buildLocationMap.events.add('click', function (e) {
        var coords = e.get('coords');

        buildPlacemark.geometry.setCoordinates(coords);
        inputCoors.val(coords);
    });
    buildPlacemark = new ymaps.GeoObject({
        geometry: {type: "Point", coordinates: [$coors[0], $coors[1]]},
    }, {
        preset: 'islands#blackStretchyIcon', draggable: true
    });
    buildLocationMap.geoObjects.add(buildPlacemark);
    buildPlacemark.events.add('dragend', function (ev) {

        curcoords = ev.get('target').geometry.getCoordinates();
        inputCoors.val(curcoords);
    });

}

$(function(){

    $('#extra-img').change(function(){
        var data = new FormData(),
            id = $(this).data('side');

        if (!confirm('Загрузить выбранное доп. изображение?')) return;

        data.append(0, this.files[0]);

        $.ajax({
            url: '/adm/files/uploadExtraImg/'+id+'/',
            type: 'POST',
            data: data,
            cache: false,
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            success: function(res){
                console.log(res);
                if (!res) {
                    alert('Ошибка загрузки файла');
                    return;
                }

                res = JSON.parse(res);
                $('#extra-img-wrap').append(
                    '<div style="background-image: url('+res['small']+')" data-id="'+res['image_id']+'">' +
                        '<div class="delete"></div>' +
                    '</div>'
                );

            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log('Ошибка загрузки файла: ' + textStatus );
            }
        });
    });


    $(document).on('click', '#extra-img-wrap .delete', function(){
        var id = $(this).parent().data('id'),
            img = $(this).parent();

        if (!confirm('Вы уверены что хотите удалить дополнительное изображение?')) return;

        $.post('/adm/files/deleteExtraImg/', {id: id}, function(res){
            console.log(res);

            if (res) img.remove();
            else alert('Во время удаления возникла ошибка');
        });
    });

});
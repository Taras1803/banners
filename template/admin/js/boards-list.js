$('.upload_xlsx').click(function(){

    $('#xlsx').val('').click();

});

    
$('.data-table').dataTable({

    //order: false,
    //bSort : false,

});

function import_log(msg, error){

    var log = $('.import_modal .log');

    var msg = $('<div class="msg"><span class="arrow"> › &#160; </span>' + msg + '</div>').appendTo(log);

    if( error ){

        msg.addClass('error');

    }

    log.scrollTop( log[0].scrollHeight );

}

var boards, importing, uploading, stop_import = 0;

$('#xlsx').change(function(e){

    var data = new FormData( document.forms['import'] );

    if( !uploading ){

        uploading = 1;

        import_log('Загрузка файла...');

        $.ajax( {

            url: '/adm/boards/upload_xlsx/',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(r){

              import_log('Загрузка завершена');

              uploading = 0;

              if( !r.error ){

                  import_log('Найдено рекламных конструкций: ' + r.boards);

                  boards = r.boards;

              } else {

                  import_log(r.error, 1);

              }

            }, 
            error: function(){

                uploading = 0;

                import_log('Произошла ошибка сервера', 1);

            }

        } );

    }

});

var import_errors = 0;

$('.start_import').click(function(){

    if( !importing && boards ){
        
        import_errors = 0;

        stop_import = 0;

        importing = 1;

        index = 1;

        import_images = $('#import_images').prop('checked') | 0;

        xlsx_import(index, import_images);

    } else if( !boards ){

        import_log('Загрузите файл в формате .xlsx');

    }

});

function xlsx_import(index, import_images){

    if( index <= boards && !stop_import ){

        $.ajax( {

            url: '/adm/boards/import/' + index + '/',
            type: 'POST',
            data: {
                import_image: import_images
            },
            dataType: 'json',
            success: function(r){

                import_log('Конструкция ' + r.name + ' импортирована');

                index++;

                xlsx_import(index, import_images);

            },
            error: function(){

                import_log('Произошла ошибка сервера', 1);
                
                import_errors++;

                index++;

                xlsx_import(index, import_images);

            }

        });

    } else {

        if(!stop_import){
            
            if( import_errors > 0 ){
                
                import_log('Ошибки импорта: ' + import_errors, 1);
                
            }

            import_log('Импорт завершен, обновите страницу');

        } else {

            import_log('Импорт остановлен');

            stop_import = 0;

        }

        importing = 0;
        boards = 0;

        index = 1;

    }

}

$('.cancel_import').click(function(){

    stop_import = 1;

    importing = 0;

    index = 1;

});
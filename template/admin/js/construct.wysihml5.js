$('.wysihtml5').each(function(){
    
    var textarea_height = $(this).css('height');
    
    var toolbar_layout = '<ul class="wysihtml5-toolbar">' +
    
        '<li class="dropdown">' +
            '<span class="btn dropdown-toggle"><span class="current-value">Обычный</span><i class="fa fa-caret-down"></i></span>' +
            '<ul class="dropdown-menu hidden">' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="div">Обычный</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">Заголовок 1</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">Заголовок 2</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3">Заголовок 3</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4">Заголовок 4</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h5">Заголовок 5</span></li>' +
                '<li><span data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h6">Заголовок 6</span></li>' +
            '</ul>' +
        '</li>' +
        '<li>' +
            '<div class="btn-group">' +
                '<span class="btn" data-wysihtml5-command="bold" title="CTRL+B"><strong>Bold</strong></span>' +
                '<span class="btn" data-wysihtml5-command="italic" title="CTRL+I"><i>Italic</i></span>' +
                '<span class="btn" data-wysihtml5-command="underline" title="CTRL+U"><u>Underline</u></span>' +
            '</div>' +
        '</li>' +
        '<li>' +
            '<div class="btn-group">' +
                '<span class="btn" data-wysihtml5-command="insertUnorderedList" title="Unordered list"><i class="fa fa-list"></i></span>' +
                '<span class="btn default" data-wysihtml5-command="insertOrderedList" title="Ordered list"><i class="fa fa-th-list"></i></span>' +
                '<span class="btn default" data-wysihtml5-command="Outdent" title="Outdent"><i class="fa fa-outdent"></i></span>' +
                '<span class="btn default" data-wysihtml5-command="Indent" title="Indent"><i class="fa fa-indent"></i></span>' +
            '</div>' +
        '</li>' +
        '<li>' +
            '<div class="btn-group"><span class="btn" data-wysihtml5-action="change_view" title="Edit HTML"><i class="fa fa-pencil"></i></span></div>' +
        '</li>' +
        '<li>' +
            '<div data-wysihtml5-dialog="createLink" class="wysihtml5-dialog" style="display: none">' +
                '<label>Ссылка</label><input data-wysihtml5-dialog-field="href" class="form-control input-sm" value="http://">' +
                '<a class="btn save" data-wysihtml5-dialog-action="save">Вставить</a>' +
                '<a class="btn" data-wysihtml5-dialog-action="cancel">Отмена</a>' +
            '</div>' +
            '<a class="btn default" data-wysihtml5-command="createLink" title="Insert link"><i class="fa fa-share"></i></a>' +
        '</li>' +
        '<li>' +
            '<div data-wysihtml5-dialog="insertImage" class="wysihtml5-dialog" style="display: none">' +
                '<label>Ссылка на изображение</label><input data-wysihtml5-dialog-field="src" class="form-control input-sm" value="http://">' +
                '<a class="btn save" data-wysihtml5-dialog-action="save">Вставить</a>' +
                '<a class="btn" data-wysihtml5-dialog-action="cancel">Отмена</a>' +
            '</div>' +
            '<a class="btn default" data-wysihtml5-command="insertImage" title="Insert image"><i class="fa fa-picture-o"></i></a>' +
        '</li>' +

    '</ul>';
    
    var toolbar = $(toolbar_layout).insertBefore(this);

    var editor = new wysihtml5.Editor(this, {
        
        toolbar: toolbar[0],
        parser: function(html){
            
            return html;   
            
        }
        
    });
    
    editor.on('load', function(){
        
        $(editor.composer.iframe).height(textarea_height).css('margin-bottom', 0);
    
        toolbar.find('.dropdown-toggle').click(function(e){

            if( toolbar.hasClass('wysihtml5-commands-disabled') ) return false;

            var menu = $(this).next('.dropdown-menu').toggleClass('hidden');

        });

        toolbar.find('.dropdown-menu span').click(function(){

            var active = $(this).html();

            $(this).closest('.dropdown').find('.current-value').html(active);

        });

        editor.on('focus', function(){

            $('.dropdown-menu').addClass('hidden');

        });
        
    });

});

$(document).click(function(e){

    if( $(e.target).closest('.dropdown').length == 0){

        $('.dropdown-menu').addClass('hidden');

    }

});
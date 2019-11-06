var closeModal = function(modal) {
    
    $('.modal-bg, .modal').addClass('hidden');
    
    $('.site').removeClass('fixed');
    
    $(window).scrollTop(scrollTop);
    
}

function modal(el){
    
    var modal = $(el);

    modal.removeClass('hidden');
    
    $('.modal-bg').removeClass('hidden').one('click', closeModal);
    
    scrollTop = $(window).scrollTop();
    
    $('.site').addClass('fixed').css('top', -scrollTop);
    
    modal.find('.close-modal').one('click', closeModal);

}

$(function(){

    $('.page-sidebar-menu .open-menu').click(function(){

        var menu = $(this).next('.sub-menu');
        
        if( menu.css('display') == 'none'){
            
            menu.css('display', 'block');
            
        } else {
            
            menu.css('display', 'none');
            
        }

    });
    
    $('.date-picker').datepicker({

        dateFormat: "dd-mm-yy",
        prevText: "‹",
        nextText: "›",

    });
    
    $(document).on('click', '.bulb', function(){
        
        $(this).toggleClass('on');
        
        id  = $(this).attr('item-id');
        col = $(this).attr('toggle-val');
        
        checked = $(this).hasClass('on');
        
        $.post('/adm/boards/toggle/', {id: id, checked: checked, col: col});
        
    });

    $('[data-tab]').click(function(e){

        e.preventDefault();

        $('.tab-pane').removeClass('active');

        tab_id = $(this).attr('href');

        $(tab_id).addClass('active');

        $('[data-tab]').parent().removeClass('active');

        $(this).parent().addClass('active');

        window.location.hash = tab_id;

        $('#redirect-tab').val(tab_id);

        $(window).scrollTop(0);

    });

    var hash = window.location.hash;

    if( hash ){

        $('a[href="' + hash + '"]').click();

    } else {
        
        $('[data-tab]:first').click();
        
    }

});
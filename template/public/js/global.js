
var siteScroll = 0,
    menu_was_closed,
    modalOpen;

function fixSite(stage){
    
    if( !stage ){
        
        $('.site').removeClass('fixed');
        
        $(window).scrollTop(siteScroll);
        
        siteScroll = 0;
        
    } else {
        
        siteScroll = $(window).scrollTop();

        $('.site').addClass('fixed').css('top', -siteScroll);
        
    }
    
}


function modal(id){
    
    modalOpen = 1;
    
    fixSite(1);
    
    $('.modal-bg, #' + id).removeClass('hidden');
    
    $('#' + id + ' .close, .modal-bg').one('click', closeModal);
    
}

function closeModal(){
    
    $('.modal-bg, .modal, .success-modal').addClass('hidden');
    
    modalOpen = 0;
            
    fixSite(0);
    
}

function successModal(mes){
    
    $('.modal-bg, .success-modal').removeClass('hidden').find('.message').html(mes);
    
    fixSite(1);
    
}

function callback(action, id){
    
    var title = $('#callback-modal .header-text');
    
    switch ( action ){
    
        case 'quickorder' :

            $('<input name="side_id" type="hidden">').prependTo('#callback-modal form').val(id);

            title.html('Быстрый заказ');

        break;

        case 'order':

            title.html('Заказ конструкций');

        break;

        case 'work':

            title.html('Работайте у нас');

        break;
            
        default:
            
            title.html('Заказать звонок');
            
        break;
            
    }
    
    $('#callback-modal form').attr('action', '/email/' + action + '/');

    modal('callback-modal');
    
    $('#callback-modal input:first').focus();

}

function addFavorite(id){
    
    $.post('/favorites/add/', $.param({id: id}), function(r){
        
        if(r){
        
            $('.fav-list').html(r.header);

            $('.favorites .count').html(r.total);

            modal('favorites');
            
        }
        
    }, 'json');
    
}

$(function(){

    $('.menu-button').click(function(){

        $('.menu-bg').removeClass('hidden');

        $('.top-menu').addClass('open');

        fixSite(1);

        $('.top-menu .close, .menu-bg').one('click', function(){

            $('.menu-bg').addClass('hidden');

            $('.top-menu').removeClass('open');

            fixSite(0);

            menu_was_closed = true;

        });

    });

    $(window).resize(function(e){

        if( $(this).width() > 992 ){

            $('.menu-bg').addClass('hidden');

            $('header').removeClass('hidden');

            $('.top-menu').removeClass('open');

            fixSite(0);

        }


    });

    scroll = 0;

    docHeight = $(window).outerHeight();

    var delay;

    $(document).scroll(function(e){

        /* нужно что бы избежать скачков в Safari, которая вызывает изменяет размер окна и вызывает
        доп. scroll envent */

        newDocHeight = $(window).outerHeight();

        if( newDocHeight != docHeight ){

            docHeight = newDocHeight;

            return false;

        }

        if( $(this).width() < 992 ){

            var new_scroll = $(this).scrollTop();

            if( new_scroll < scroll || new_scroll <= 0 || menu_was_closed ){

                $('header').removeClass('hidden');

                menu_was_closed = false;

            } else if(new_scroll > 65 && new_scroll < $('body').innerHeight() ) {

                $('header').addClass('hidden');

            }

            scroll = new_scroll;

        }

    });

    $('.modal form').submit(function(e){

        e.preventDefault();

        var name = $(this).find('input[name=name]');

        var phone = $(this).find('input[name=phone]');

        var form = $(this);

        var action = form.attr('action');

        var data = form.serialize();

        if (action != '/email/subscribe/'){

          if (!name.val() || name.val().length < 2) { alert('Имя должно быть не меньше 2 символов.'); return; }

          if (!phone.val() || phone.val().length < 5 || isNaN(phone.val())) { alert('Введите корректный номер телефона.'); return; }

        }


        $.post(action, data, function(r){

            form.find('input').val('');

            if (action == '/email/callme/') {
              gtag('event', 'zvonok_up');
              yaCounter34928630.reachGoal('zvonok_up');
            }

            if (action == '/email/order/') {
              gtag('event', 'order_done');
              yaCounter34928630.reachGoal('order_done');
            }

            closeModal();
            
            successModal(r);

        });

    });
    
    $('.success-modal .close-modal').click( closeModal );


    $('#about-menu div').click(function(){
        $(this).addClass('active').
            siblings().removeClass('active');

        $(this).parent().siblings('#about-content').
            find('div').
            removeClass('active').
            eq($(this).index()).addClass('active');
    });

    $('.share').click(function(){
        $(this).toggleClass('active');
    });
    
});
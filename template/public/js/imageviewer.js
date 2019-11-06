$.fn.imageViewer = function(options){

    var options = $.extend({arrows: 0}, options);

    $(this).on('click', function(e){

        e.preventDefault();

        var siteScroll = $(window).scrollTop();

        $('body').css('position', 'fixed').css('width', '100%').css('top', -siteScroll);

        var link = $(this);

        var src = link.attr('href');

        var modal = $('<div class="image-modal"><div class="style"><div class="inner"></div></div></div>').appendTo('body');

        var content = modal.find('.inner');
        var style = modal.find('.style').css('display', 'none');

        var img = $('<img src="' + src + '">').appendTo(content).on('load', function(){
            
            style.css('display', 'block');

            //центрует изображение и задаём размер, что бы умеещалось на экране

            var resize = function(){

                var winH = $(window).height() - 80;
                var winW = $(window).width() - 80;

                if( winW * imgScale > winH ){

                    if( imgH < winH ) winH = imgH;

                    var newH = winH;
                    var newW = winH / imgScale;


                } else {

                    if( imgW < winW ) winW = imgW;

                    var newH = winW * imgScale;
                    var newW = winW;

                }

                content.css('height', newH);
                content.css('width', newW);

                //центруем

                winH = $(window).height();
                winW = $(window).width();

                style.css('top', (winH - newH) / 2 );
                style.css('left', (winW - newW) / 2 );

            }

            var imgH = img[0].naturalHeight;
            var imgW = img[0].naturalWidth;

            var imgScale = imgH / imgW;

            resize();

            $(window).on('resize orientationchange', resize);

            var close = $('<div class="close"></div>').appendTo(style).click(function(){

               $(modal).remove(); 

               $('body').removeAttr('style');

               $(window).scrollTop(siteScroll);

            });

            if( options.arrows ){

                if( link.prev().length > 0 ){

                    $('<div class="control prev">‹</div>').appendTo(style).click( function() {

                        close.click();

                        link.prev().click();

                    } );

                }

                if( link.next().length > 0 ){

                    $('<div class="control next">›</div>').appendTo(style).click( function() {

                        close.click();

                        link.next().click();

                    } );

                }

            }
                                                                                 
        });

    });

}
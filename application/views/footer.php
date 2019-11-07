        <footer>

            <div class="container">
                
                <div class="open-callback hidden-sm" onclick="callback('callme')">
                    
                    <img src="/<?=TEMPLATE_DIR?>/img/icons/phone-call.svg" alt="phone-call">
                    Обратный звонок
                    
                </div>

                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <h4>Наш офис:</h4>

                        <p>
                            <?= get_option('address') ?><br><?= get_option('phone') ?><a href="mailto:<?= get_option('email') ?>"><?= get_option('email') ?></a>
                        </p>

                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <h4>Информация:</h4>

                        <a href="/docs/Vostok_Media_v8.pdf">Смотреть презентацию</a>
                        <a href="javascript:void(0)" onclick="callback('work')">Работайте у нас</a>
                        <a href="javascript:void(0)" onclick="modal('requisites')">Реквизиты</a>
                        <a href="/docs/trebovaniya_k_maketam.pdf">Требования к макетам</a>
                        <a href="/db/">База объектов</a>

                    </div>

                </div>

            </div>

        </footer>
        
        <div class="modal favorites-modal hidden" id="favorites">
        
            <div class="modal-header">
                
                <span class="header-text">Избранное</span>
                            
                <div class="close"></div>
                
            </div>
            
            <div class="modal-content">
            
                <p>Конструкция добавлена в избранное</p>
                
                <br>

                <a href="/favorites/" class="yellow-btn">Просмотреть</a>
            
            </div>
        
        </div>
        
        <div class="modal hidden" id="requisites">
        
            <div class="modal-header">
                
                <span class="header-text">Реквизиты</span>
                            
                <div class="close"></div>
                
            </div>
            
            <div class="modal-content">
            
                <p>Юридический адрес: 117105, г. Москва, Варшавское шоссе, д. 1, стр. 17, этаж 3, офис 309В</p>
                тел. (495)728-11-55<br>
                ИНН 7703642861/ КПП 772601001<br>
                ОГРН 1077759367542<br>
                <br>
                <p>Акционерное общество «ЮниКредит Банк», г. Москва</p>
                р/с 40702810000014815560<br>
                к/с № 30101810300000000545<br>
                БИК 044525545<br>
            
            </div>
        
        </div>
        
        <div class="modal hidden" id="callback-modal">
            
            <div class="modal-header">
                
                <span class="header-text">Заказать звонок</span>
                            
                <div class="close"></div>
                
            </div>

            <div class="modal-form">
                
                <form action="/email/callback/" method="POST">
            
                    <div class="field-name">Ваше имя</div>
                    <input type="text" name="name" autocomplete="off"/>
                    
                    <div class="field-name">Номер телефона</div>
                    <input type="text" name="phone" autocomplete="off"/>


                    <button class="yellow-btn block">Отправить</button>
                    
                </form>
            
            </div>

        </div>

        <a href="tel:+7(495)2669024"><div class="receiver"></div></a><!-- onclick="callback('callme')" -->

        <div class="success-modal hidden">
           
            <div class="title">Спасибо!</div>
            
            <div class="message"></div>
            <div class="close-modal">&#10005;</div>
            
        </div>
        
        <div class="modal-bg hidden"></div>
        
        <script>
        
            var clients = $('.clients .track').children().length;
            
            $('.clients .track').width( clients * 200 );
        
        </script>
    
    </div>

<!-- Yandex.Metrika counter -->
<script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34928630 = new Ya.Metrika({
                    id:34928630,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34928630" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-72440853-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-72440853-1');
</script>


<!-- calltouch -->
<script src="https://mod.calltouch.ru/init.js?id=v2y4ltc4"></script>
<!-- /calltouch -->

<script>
/* <![CDATA[ */
var google_conversion_id = 934033922;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/934033922/?guid=ON&script=0"/>
</div>
</noscript>

<!-- Yandex Chat Widget -->
<script type='text/javascript'>
(function () {
    window['yandexChatWidgetCallback'] = function() {
        try {
            window.yandexChatWidget = new Ya.ChatWidget({
                guid: '27db6d66-54c3-46f8-b5d1-4710592f483e',
                buttonText: '',
                title: 'Чат',
                theme: 'light',
                collapsedDesktop: 'never',
                collapsedTouch: 'never'
            });
        } catch(e) { }
    };
    var n = document.getElementsByTagName('script')[0],
        s = document.createElement('script');
    s.async = true;
    s.charset = 'UTF-8';
    s.src = 'https://chat.s3.yandex.net/widget.js';
    n.parentNode.insertBefore(s, n);
})();
</script>
</body>
</html>
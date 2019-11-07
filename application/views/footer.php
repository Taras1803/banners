        <footer>

            <div class="container">
                

                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <h4>Наш офис:</h4>

                        <p>
                            <?= get_option('address') ?><br>
                            <?= get_option('phone') ?>
                            <a href="mailto:<?= get_option('email') ?>"><?= get_option('email') ?></a>
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

                <div class="open-callback hidden-xs" >
                    <div class="callback__text" onclick="callback('callme')">
                        <!-- <img src="/<?=TEMPLATE_DIR?>/img/icons/phone-call.svg" alt="phone-call"> -->
                        Заказать звонок
                    </div>

                    <div onclick="callback('emailme')">Написать нам</div>

                    <div class="footer-socials">

                        <a href="https://www.facebook.com/people/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D0%BA-%D0%9C%D0%B5%D0%B4%D0%B8%D0%B0/100011182897474" class="footer-socials-link">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><image width="32" height="32" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAABE5JREFUWEetl2msXWMUhp8bIiRmIooIyVmpUDQ1FSX8IRFCQ2JITNWrlZhD0WrdFiWmGGOoGGoOgj8S/giKGtNSgpeQmGKMofFDyJX3Zu2Tffbd++6T037/zvm+/X3vWutd71praHR0lH5WRGwDHAccDuwF7Apsmt+uBb4CPgReAZ6X9Gs/9w61AYgIP3YFcDywYT7yDvAF8Fs+sjXQAfZPcP8CzwLXSTKoxtUIICI2A24A5gA/AHcAyyV9P9GFEbEDcBpwHjAJuBeYJ+mvuu9qAUTEHnYjsCOwBLhF0j/9uLQ4ExEbARcDi4DvHD5JH1fvGAcgIqYDLwG29IS6j+qARMQmwFbAWkl/loDYmGcAe+ZISSvL3/cASMvfBD4FjmojUkTsDFwCHJ2kLO42s38CPgduBV4FXgR2Aw4qG9UFkDH/ADCBZvTx+GzgLsCxfRJ4D/gd2BjYMi2+CLhZ0khm0Yok8rSCE2UAdwOnA/u1uT0iTgKeAB4D5kpyGo5bEfE18JABeDM9/C7wsKRz/N8YgEy1VcB8Sde3sNyx/gZwLI+R1CgkVQAJ4nJgKTDVKVoAsDWHOo5tbI+Is4D7gMmSrAWNqwGAs8Oi9Zqkk4c6nY4Vznm+qM36tMDx7kjat/pyREwGZiYPvH2hSViEoJQZ9oLTe5IB2KJlwE5tIpMArIKrJQ2XAUSEGW4SOyQ/l/YMwJnQXSlW3wLDBvAoMEXS1H6EJiK+BJ6WZCvKl14GLLB4Nale5bw5t8YArNUrJZ3dJ4AeZpfcuthZJGmXPu8xj6YbgPP4aknW/bpUOgUwcYp1E3BnTVydauemMJXvWSXJ1vasiJgHLDQAx2xY0v0NACwuW1T2FjcAuKrmjjmSbG0VgIVsWQFglqQHJwAwUiVSm5sjYs8s3YdJshRXAZwJPGAAfwN+oCkE9sAgANw/uAhtL+nHhhCMGMAa4PVCGmsODgrgSvNBkutCHbcs/YcUabi7pGnrOQTLUy0PaLjXmvGJAcwCTMBaIYoIe8Cl9OXSReOYHRHWkbKWzAfekuQCV42/ewML0WwD2C5/LJB0Y0MIBs2ChZKuqbnzUuBaG10Uo6eAA1PjJ2y96gqMH4gI68AZbUKUrZqLmL1zYgHAKbM6m0cLTeNaDwDcQTnj9pb0UbkhuQc4FdhHkluy2rUuALJgvQ88ImmuHygDcJy96RC4bzP56tKnqRZMGIKIcDq637Ss28g/egBkHKcAb2RTekRxqIxiEA9EhI1zFrlkHyzJ2jO26tpy560Pu5efKemzdQGQTcpzOWPYqLfL9zUNJvaEBxPnqwvMbUWr1q8Hku0XAC7TnjE8mHQtb/RAsRERmydb3SdYNG4HHs84djvd0vkxDpg/gEv4+c7z7B89mnWHlVYPVFzu4dSq5uKyQe4taSjHHsO8/svhdOnAw2mV/hGxLXBsjucrJDltuysinFYzcjx/QdIv9Ync++//tpNQ1h40E2sAAAAASUVORK5CYII="/></svg>
                        </a>

                        <a href="javascript:void(0)" class="footer-socials-link">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33" height="33" viewBox="0 0 33 33"><image width="33" height="33" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAhCAYAAABX5MJvAAAABHNCSVQICAgIfAhkiAAAAz5JREFUWEfNmFuIzVEUxn9D8UAuuUYZNIvw5GEKD64l4cH9Fhq5TUiuRW4x1AiRkGuEYpA8ICm5PKDmwZuRT25F7rd4IIzWtEfH9p85Zzg69ut/77N/e61vfWvvk1dZWUkmw8zqAf2BwUAvoAvQGqgPfANeAHeBm8BF4Iqk75n8dl46CDNrAswB5gHtgefANaACeAp8BhoC7YBuQF+gDfAE2AHskvShNphaIcxsCrAFaAYcBg5IupHudGbWG5gOTAXeAYslHalpXSKEmTXyDYHxwClgiaRH6TaPv5tZPrAZGAOUOZikT/G83yDMrBVwDugOzJB0vK6bJ8BMAPYDt4Fhkl6mzvkFIkTgMtAJGCqp/G8BqtebWSFwHngADEiNSAzhpx4eJmUNIALxQ56V5NGpGj8hgghdfBOTUmBmXo5DQwU0BxokROkL8Aa446eW5GX7yzAz3/yYi7ZarFUQoQzvAVcljU1YuAQoCRvfBz4C7xMgmgKNgc6AA62S5MKMQU4C/YACL99qiGXAOsDiKjAzB9gEbAM2SHqVTidm1hJYASwAlsYgoWoErJZUmldQUOBO+Bi4IGlG6gYhBV6auyUtzGDzFgHYo7AaWA4UA/lxaszMq2UI0MEhBgKXgD6xEZlZUfCLNhlGYCcwKdi4+8vK4LDuD4eiA7qhXQcGOUQpUCSpbULuNgKjJFm6KPh3M9sOuMv6KJNUbGautVOSPOWxNp4BhxziijcfSeMSJu0FCiX1TPg2OZzUG5k3rvXB5FxbnmLP92szuwWUS5qV8BsnvAk6hDehfZLWJEzyEHaU5N3z5zAzB/BecAbwuh8AjPAoSDoazfVDPpTkqY0jsRaY6RBfgbmS9tQBwn2gQtLI6jVmdhroIalrHSBmAzsdwi8U02LhhBzXFAkHXyTJNVA1zGy+l7EkT0Vq1GqLhEfn4H8TiWxowjXjqfljTWSjOtz9SmJRhjRlVB21+YR/G52pT8TCDhAZ+UTWHDOhuryH+J00rWNmrXckQGzNqHeEVp7bLvrf3CeCgLzxZONm9Ta8Sep2s0pxvdzeMUM0/L2R29t2AMntuyMlLbl9gUUdMHdv0Qgkt6/yCOaf/T/xA12ZWFsM+fOnAAAAAElFTkSuQmCC"/></svg>
                        </a>


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

        <div class="modal hidden" id="callback-modalemail">
            <div class="modal-header">
                <span class="header-text">Отправить письмо</span>
                <div class="close"></div>
            </div>
            <div class="modal-form">
                <form action="/email/callback/" method="POST">
                    <div class="field-name">Ваше имя</div>
                    <input type="text" name="name" autocomplete="off"/>
                    <div class="field-name">Ваш email</div>
                    <input type="text" name="email" autocomplete="off"/>
                    <div class="field-name">Ваш вопрос</div>
                    <textarea name="text" id="" rows="5"></textarea>
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
                guid: '52a721aa-c01f-4102-8246-e8d0f3077796',
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
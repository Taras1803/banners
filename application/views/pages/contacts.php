
<div class="contacts">

    <div class="addresses">

        <h1 class="hidden-xs">Контакты</h1>

        <div class="track">

            <div class="address" onclick="setMapCenter([55.7915529,37.5148146])">

                <div class="name">Наш офис</div>

                <p class="address__bold">г. Москва, 3-я Песчаная улица, д. 2А</p>

                <p class="address__grey">8 (495) 266-90-24</p>
                <p><a href="mailto:hello@vmoutdoor.ru"><span class="address__mail">hello@vmoutdoor.ru</span></a></p>

            </div>

            <div class="address" onclick="setMapCenter([55.543802, 37.761379])">

                <div class="name orange-marker">Наш склад</div>

                <p class="address__bold">г. Видное, Белокаменное шоссе, вл18</p>

                <!--<p>г. Видное,<br> Белокаменное шоссе</p>
                <p>ул. 8-линия ГСК "Медик" гараж 261</p>-->

                <p class="address__grey">+7 (925) 301-81-08 (Артём)</p>

            </div>

        </div>

    </div>

    <div class="map" id="map"></div>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<!--    https://api-maps.yandex.ru/2.1/?apikey=<ваш API-ключ>&lang=ru_RU-->

    <script src="/<?=TEMPLATE_DIR?>/js/contacts.js"></script>

</div>
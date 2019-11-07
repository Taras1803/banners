
<div class="contacts">

    <div class="addresses">

        <h1 class="hidden-xs">Контакты</h1>

        <div class="track">

            <div class="address" onclick="setMapCenter([55.7915529,37.5148146])">

                <div class="name">Наш офис</div>

                <p>г. Москва,<br>3-я Песчаная улица, д. 2А</p>

                <p>8 (495) 266-90-24</p>
                <p><a href="mailto:hello@vmoutdoor.ru">hello@vmoutdoor.ru</a></p>

            </div>

            <div class="address" onclick="setMapCenter([55.543802, 37.761379])">

                <div class="name orange-marker">Наш склад</div>

                <p>г. Видное,<br>Белокаменное шоссе, вл18</p>

                <!--<p>г. Видное,<br> Белокаменное шоссе</p>
                <p>ул. 8-линия ГСК "Медик" гараж 261</p>-->

                <p>+7 (925) 301-81-08 (Артём)</p>

            </div>

        </div>

    </div>

    <div class="map" id="map"></div>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

    <script src="/<?=TEMPLATE_DIR?>/js/contacts.js"></script>

</div>
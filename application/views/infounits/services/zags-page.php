<div class="white-bg" id="zags-page">

    <div class="container">

        <?php if( $cat ): ?>

            <a class="back" href="/services/<?= $cat->url ?>/">‹ &#160; <?= $cat->name ?></a>

        <?php else: ?>

            <br>

        <?php endif; ?>


        <div class="row">

            <div class="col-sm-6">
                <h1><?= $item->name ?></h1>

                <?= $item->content ?>

            </div>

            <div class="col-sm-5 col-sm-offset-1 hidden-xs">

                <img src="/<?= TEMPLATE_DIR ?>/img/zags-shit.png" class="col-image" style="margin: 25px auto 50px; display: block">

            </div>

        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-5" style="margin-bottom: 30px;">
                <p style="margin-bottom: 20px;">Журнал «Свадьба в деталях» получают в подарок пары, подавшие заявление на регистрацию брака.</p>

                <p><b>Ближайший выпуск:</b> Ноябрь 2018 года</p>
                <p><b>Период распространения:</b> 6 месяцев</p>
                <p><b>Тираж:</b> 40 000 экз.</p>
                <p><b>Отдел размещения рекламы:</b></p>
                <p>tel: 8-999-983-15-63</p>
                <p>e-mail: a.razbakova@yandex.ru</p>
            </div>
            <div class="col-sm-7">
                <img src="/<?= TEMPLATE_DIR ?>/img/zags-img1.jpg" class="col-image" style="margin: 0 auto 50px; display: block">
            </div>
        </div>

    </div>

</div>


<script>

    $('.services-tabs').click(function(){

        $(this).toggleClass('active');

    });

</script>
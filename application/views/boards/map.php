<link rel="stylesheet" type="text/css" href="/template/public/lightbox/css/lightbox.min.css">
<script src="/template/public/lightbox/js/lightbox.min.js"></script>

<link rel="stylesheet" type="text/css" href="/template/public/owl/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="/template/public/owl/owl.theme.default.min.css">
<script src="/template/public/owl/owl.carousel.min.js"></script>

<div class="boards">

    <div class="boards-filters">

        <div class="close"></div>
        
        <form id="filters-form">

            <div class="search-field">
                <img src="/<?= TEMPLATE_DIR ?>/img/lupa.png" alt="lupa">
                <input type="text" autocomplete="off" placeholder="Номер или адрес" id="map-search">
                <input type="hidden" name="keyword" id="keyword">
                <ul id="hints"></ul>
            </div>

            <div class="filters-tabs">
            
                <div class="tab first-tab">

                    <div class="tab-title">Типы конструкций <div class="quantity hidden"><span class="num">0</span><img src="/<?= TEMPLATE_DIR ?>/img/times-small.png" class="clear" alt="times-small"></div></div>

                    <div class="tab-content">

                        <div class="padding">

                            <?php foreach ($types as $type) : ?>

                                <a href="/boards/?type=<?= $type->code ?>">
                                    <label class="option" style="color: <?= $type->color ?>" for="type_<?= $type->id ?>">
                                        <div class="name"><?= $type->name ?></div>
                                        <div class="quantity"><?= $type->count ?></div>
                                        <input type="checkbox" id="type_<?= $type->id ?>" name="type[]" value="<?= $type->code ?>">
                                        <div class="ellipse"></div>
                                    </label>
                                </a>

                            <?php endforeach; ?>

                        </div>

                    </div>


                </div>

                <?php if( !empty( $roads ) ): ?>

                    <div class="tab">

                        <div class="tab-title">Шоссе <div class="quantity hidden"><span class="num">0</span><img src="/<?= TEMPLATE_DIR ?>/img/times-small.png" class="clear" alt="times-small"></div></div>

                        <div class="tab-content">

                            <div class="padding">

                                <?php foreach( $roads as $road ): ?>

                                 <a href="/boards/?road=<?= $road->code ?>">
                                     <label class="option" for="road_<?= $road->id ?>">
                                        <?= $road->name ?>
                                        <input type="checkbox" id="road_<?= $road->id ?>" name="road[]" value="<?= $road->code ?>">
                                        <div class="ellipse"></div>
                                     </label>
                                 </a>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <?php if( !empty( $districts ) ): ?>

                    <div class="tab">

                        <div class="tab-title">Районы <div class="quantity hidden"><span class="num">0</span><img src="/<?= TEMPLATE_DIR ?>/img/times-small.png" class="clear" alt="times-small"></div></div>

                        <div class="tab-content">

                            <div class="padding">

                                <?php foreach( $districts as $district ): ?>

                                    <a href="/boards/?district=<?= $district->code ?>">
                                        <label class="option" for="district_<?= $district->id ?>">
                                            <?= $district->name ?>
                                            <input type="checkbox" id="district_<?= $district->id ?>" name="district[]" value="<?= $district->code ?>">
                                            <div class="ellipse"></div>
                                        </label>
                                    </a>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <?php if( !empty( $towns ) ): ?>

                    <div class="tab">

                        <div class="tab-title">Города <div class="quantity hidden"><span class="num">0</span><img src="/<?= TEMPLATE_DIR ?>/img/times-small.png" class="clear" alt="times-small"></div></div>

                        <div class="tab-content">

                            <div class="padding">

                                <?php foreach( $towns as $town ): ?>

                                    <a href="/boards/?town=<?= $town->code ?>">
                                        <label class="option" for="town_<?= $town->id ?>">
                                            <?= $town->name ?>
                                            <input type="checkbox" id="town_<?= $town->id ?>" name="town[]" value="<?= $town->code ?>">
                                            <div class="ellipse"></div>
                                        </label>
                                    </a>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

            <div class="clear-all"><img src="/<?= TEMPLATE_DIR ?>/img/times-small.png" alt="times-small">Очистить все</div>
        
        </form>

    </div>

    <div class="boards-map">

        <div class="map-wrap">

            <div id="empty-map">
                <div id="empty-map-table">
                    <div id="empty-map-cell">
                        <p>Нет объектов соответствующих вашему фильтру.</p>
                    </div>
                </div>
            </div>

            <div class="header">
                <img src="/<?= TEMPLATE_DIR ?>/img/show-filters.png" class="show_filters" alt="show-filters">
                <h1><?= $h1 ?></h1>
                <div class="yellow-btn subscribe-btn">Подписаться</div>
            </div>

            <div class="yandex-map" id="map"></div>


        </div>

    </div>

</div>

<div class="container" id="map_seo">
    <div class="row">
        <div class="col-xs-12" id="map-seo-text">
            <?php if (strlen($text) > 1): ?>
                <div>
                    <?= $text ?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="container" id="extra-links">

    <?php if(!empty($seo_links)): ?>
        <div class="row">
        <?php foreach($seo_links['types'] as $type):?>
            <div class="col-md-4">
                <a href="/boards/?type=<?= $type->b_code ?>&<?= $seo_links['where_key'].'='.$type->t_code; ?>" class="extra-link">
                    <?= $type->b_name?> <?=$type->t_name ?>
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script src="https://api-maps.yandex.ru/2.1.56/?lang=ru_RU"></script>

<script src="/<?= TEMPLATE_DIR ?>/js/boards.js"></script>



<div class="modal subscribe hidden map_update" id="subscribe">

    <div class="modal-header">

        <span class="header-text">Подписаться на обновление адресной программы</span>

        <div class="close"></div>

    </div>

    <div class="modal-form">

        <form action="/email/subscribe/" method="POST">

            <input type="text" name="email" autocomplete="off" placeholder="E-mail"/>

            <input type="hidden" name="goal" value="map_update">

            <button class="yellow-btn">Отправить</button>

        </form>

    </div>

</div>

<script>

    $('.subscribe-btn').click(function(){

        modal('subscribe');

    });

</script>

<div class="container no-padding">

    <div class="white-bg object-page">

        <a class="back" href="<?= $back_link ?>">‹ &#160; Адресная программа</a>

        <div class="row">

        <div class="col-sm-6 col-md-7 hidden-xs"></div>

        <div class="col-sm-6 col-md-5">

        <h1><?= $type->name ?>, номер #<?= $GID ?></h1>

        </div>

        </div>

        <div class="row">

            <div class="col-sm-5 col-md-7">

                <div class="img-wrap">
                   
                    <?php if( !empty( $image ) ): ?>

                        <link rel="stylesheet" type="text/css" href="/template/public/lightbox/css/lightbox.min.css">
                        <script src="/template/public/lightbox/js/lightbox.min.js"></script>

                        <?php if (is_array($image)): ?>

                            <link rel="stylesheet" type="text/css" href="/template/public/owl/owl.carousel.min.css">
                            <link rel="stylesheet" type="text/css" href="/template/public/owl/owl.theme.default.min.css">
                            <script src="/template/public/owl/owl.carousel.min.js"></script>

                            <div class="owl-carousel owl-theme">
                                <?php foreach ($image as $img): ?>
                                    <a href="<?= $img ?>" data-lightbox="image-1">
                                        <img src="<?= $img ?>" data-large="<?= $image ?>" class="my-foto">
                                    </a>
                                <?php endforeach; ?>
                            </div>

                            <script>
                                $('.owl-carousel').owlCarousel({ nav:false, items: 1, dots: true});
                            </script>

                        <?php else: ?>
                            <a href="<?= $image ?>" data-lightbox="image-1">
                                <img src="<?= $image ?>" data-large="<?= $image ?>" class="my-foto">
                            </a>
                        <?php endif; ?>

                        
                    <?php else: ?>
                       
                       <img src="/template/public/img/no-image.jpg">
                        
                    <?php endif; ?>
                
                </div>

            </div>

            <div class="col-sm-7 col-md-5">

                <div class="sides">
                    
                    <?php foreach( $sides as $side ): ?>

                        <a <?php if($code == $side->code) echo 'class="active"' ?> href="/boards/detail/<?= $GID ?>/<?= $side->code ?>/">Сторона <?= $side->code ?></a>
                    
                    <?php endforeach; ?>

                </div>

                <div class="properties">

                    <div class="prop">

                        <div class="name">

                            <span class="hide-dots">Формат:</span>

                        </div>

                        <div class="value">

                            <?= $type->name ?>

                        </div>

                    </div>

                    <div class="prop">

                        <div class="name">

                            <span class="hide-dots">Расположение:</span>

                        </div>

                        <div class="value">

                            <?= $address ?>

                        </div>

                    </div>
                    
                    <div class="prop">

                        <div class="name">

                            <span class="hide-dots">Широта:</span>

                        </div>

                        <div class="value">

                            <?= $coords_out[0] ?>

                        </div>

                    </div>

                    <div class="prop">

                        <div class="name">

                            <span class="hide-dots">Долгота:</span>

                        </div>

                        <div class="value">

                            <?= $coords_out[1] ?>

                        </div>

                    </div>
                    
                    <div class="prop">

                        <div class="name">

                            <span class="hide-dots">Направление:</span>

                        </div>

                        <div class="value">

                            <?= ($direction == 1) ? "Из Москвы" : "В Москву" ?>

                        </div>

                    </div>
                    
                    <?php foreach ( $props as $prop ): ?>
                    
                        <div class="prop">

                            <div class="name">

                                <span class="hide-dots"><?= $prop->name ?></span>

                            </div>

                            <div class="value">

                                <?= $prop->value ?>

                            </div>

                        </div>
                    
                    <?php endforeach; ?>

                </div>

                <div class="yellow-btn" onclick="callback('quickorder', <?= $side_id ?>)">Заказать</div>

                <div class="add-favorite" onclick="addFavorite(<?= $side_id ?>)">В избранное</div>

                <div class="share">
                    <div class="share-wrap">

                        <a onclick="Share.vkontakte('<?= $share['url'] ?>', '<?= $share['title'] ?>', '<?=$share['img'] ?>', '<?= $share['desc'] ?>')"></a>
                        <a onclick="Share.facebook('<?= $share['url'] ?>', '<?= $share['title'] ?>', '<?= $share['img'] ?>', '<?= $share['desc'] ?>')"></a>
                        <a onclick="Share.twitter('<?= $share['url'] ?>', '<?= $share['title'] ?>',)"></a>
                        <a onclick="Share.mailru('<?= $share['url'] ?>', '<?= $share['title'] ?>', '<?= $share['img'] ?>', '<?= $share['desc'] ?>')"></a>
                        <a onclick="Share.odnoklassniki('<?= $share['url'] ?>', '<?= $share['desc'] ?>')"></a>

                        <script src="/<?= TEMPLATE_DIR ?>/js/soc-share.js" async></script>

                    </div>
                </div>

                <?php if ($road_id || $district_id || $town_id || $type->code):?>

                    <div id="detail_parent_urls">
                        <?php $not_first = false; ?>
                        <?php if ($t_code): ?>
                            <a target="_blank" href="/boards/?town=<?= $t_code ?>"><?= $t_name ?></a>
                            <?php $not_first = true; ?>
                        <?php endif; ?>

                        <?php if ($d_code): ?>
                            <?php if ($not_first): ?> | <?php endif; ?>
                            <a target="_blank" href="/boards/?district=<?= $d_code ?>"><?= $d_name ?></a>
                            <?php $not_first = true; ?>
                        <?php endif; ?>

                        <?php if ($r_code): ?>
                            <?php if ($not_first): ?> | <?php endif; ?>
                            <a target="_blank" href="/boards/?road=<?= $r_code ?>"><?= $r_name ?></a>
                            <?php $not_first = true; ?>
                        <?php endif; ?>

                        <?php if ($type->code): ?>
                            <?php if ($not_first): ?> | <?php endif; ?>
                            <a target="_blank" href="/boards/?type=<?= $type->code ?>"><?= $type->name ?></a>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

            </div>


        </div>

    </div>
    
    <script>
        
        var marker_color = '<?= $type->color ?>';
        var coordinates  = '<?= $coordinates ?>';
        
        var GID  = '<?= $GID ?>';
        
    </script>

    <div class="object-map" id="ymap"></div>

    <?php if (!empty($extra_objs)): ?>
        <div id="detail_extra">
            <h2>Объекты рядом:</h2>
            <div class="row">
                <?php foreach($extra_objs as $ext): ?>
                    <div>
                        <a href="/boards/detail/<?= $ext->GID ?>/">
                            <div class="detail-extra-img" style="background-image: url(<?= $ext->medium ?>)"></div>
                            <p><b><?= $ext->name ?>, номер #<?= $ext->GID ?></b></p>
                            <p>Формат: <?= $ext->name ?></p>
                            <p>Адрес: <?= $ext->address ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endif; ?>


</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<script src="/<?= TEMPLATE_DIR ?>/js/board_detail.js"></script>
<script src="/<?= TEMPLATE_DIR ?>/js/zoomsl-3.0.min.js"></script>

<script>
    $(function(){
        if ($(window).width() > 1000) {
            $(".my-foto").imagezoomsl({
                zoomrange: [1, 12],
                magnifiersize: [400, 300],
                scrollspeedanimate: 3,
                loopspeedanimate: 3,
                magnifiereffectanimate: "fadeIn"
            });
        }
    });
</script>
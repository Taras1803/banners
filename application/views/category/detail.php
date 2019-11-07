<link rel="stylesheet" type="text/css" href="/template/public/lightbox/css/lightbox.min.css">
<script src="/template/public/lightbox/js/lightbox.min.js"></script>

<link rel="stylesheet" type="text/css" href="/template/public/owl/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="/template/public/owl/owl.theme.default.min.css">
<script src="/template/public/owl/owl.carousel.min.js"></script>

<div id="category">
    <div class="container">
        <div class="breadcrumbs">
            <a href="/">Главная</a>
            —
            <span>Категории</span>
        </div>
        <h1><?=$category->h1?></h1>
    </div>

    <script>
        var boards = <?= json_encode($category->items) ?>;
    </script>
    <div id="map"></div>

    <div id="boards" class="container">
        <div id="sort">
            <b>Сортировка</b>
            <div id="sort-items">
                <? $isset = isset($_GET['sort']) && isset($_GET['sort_type']); ?>
                <div>
                    <?if($isset && $_GET['sort'] === 'popularity' && $_GET['sort_type'] === 'asc'):?>
                        <span class="asc">По популярности</span>
                    <?endif;?>
                    <?if($isset && $_GET['sort'] === 'popularity' && $_GET['sort_type'] === 'desc'):?>
                        <span class="desc">По популярности</span>
                    <?endif;?>
                    <?if(!isset($_GET['sort']) || $_GET['sort'] !== 'popularity'):?>
                        <span>По популярности</span>
                    <?endif;?>
                    <div class="options">
                        <?if(!$isset || $isset && $_GET['sort'] === 'popularity' && $_GET['sort_type'] === 'asc'):?>
                            <a href="./?sort=popularity&sort_type=desc#boards">по убыванию</a>
                        <?endif;?>
                        <?if(!$isset || $isset && $_GET['sort'] === 'popularity' && $_GET['sort_type'] === 'desc'):?>
                            <a href="./?sort=popularity&sort_type=asc#boards">по возрастанию</a>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div id="catalog-items-list">
            <?foreach ($pagable_items as $item):?>
                <div class="item">
                    <a href="/boards/detail/<?=$item->GID?>/">
                        <div class="img"
                             style="background-image: url(<?= $item->file ? $item->file : '/template/public/img/no-image.jpg'?>)">
                        </div>
                        <div class="content">
                            <b><?=$item->single_name?>, номер #<?=$item->GID?></b>
                            <p>Формат: <?=$item->single_name?></p>
                            <?if($item->address):?><p>Адрес: <?=$item->address?></p><?endif;?>
                        </div>
                    </a>
                </div>
            <?endforeach;?>
        </div>
        <div id="pager">
            <?
            $pInterval = 4;
            $maxPage = ceil(count($category->items) / $perPage);
            ?>
            <?if ($page - $pInterval > 1):?>
                <span>...</span>
            <?endif;?>
            <?for ($i = 1; $i <= $maxPage; $i++):?>
                <?
                    if ($i > $page + $pInterval) continue;
                    if ($i < $page - $pInterval) continue;
                ?>
                <?if ($page === $i):?>
                    <span class="active"><?=$i?></span>
                <?else:?>
                    <a href="./?p=<?=$i?>#boards"><?=$i?></a>
                <?endif;?>
            <?endfor;?>
            <?if ($page + $pInterval < $maxPage):?>
                <span>...</span>
            <?endif;?>
        </div>
        <div id="seo-table-wrap">
            <div class="tabs">
                <?foreach (['Типы конструкций', 'Шоссе', 'Районы', 'Города'] as $key => $val):?>
                    <div class="tab <?if($key==0):?>active<?endif;?>"><?=$val?></div>
                <?endforeach;?>
            </div>
            <div id="seo-table">
                <?$i = 0;?>
                <?foreach ($seo_links as $key => $val):?>
                    <div <?if($i++ === 0):?>class="active"<?endif;?>>
                        <?foreach ($val as $seo_link):?>
                            <div class="seo-link">
                                <a href="/boards/?<?=$key?><?=$seo_link->code?>"><?=$seo_link->name?></a>
                            </div>
                        <?endforeach;?>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>

    <script>
        $('#seo-table-wrap .tab').click(function() {
            var index = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $('#seo-table > div').eq(index).addClass('active').siblings().removeClass('active');
        });

        $('#category #sort-items > div').click(function(){
            $(this).toggleClass('active');
        });
    </script>

    <div class="container">
        <div id="seo-text">
            <?=$category->seo?>
        </div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1.56/?lang=ru_RU"></script>

<script src="/template/public/js/category-boards.js"></script>

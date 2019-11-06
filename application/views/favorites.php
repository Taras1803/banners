<div class="container">

    <div class="white-bg">

        <div class="favorites-page">

            <a class="back" href="/boards/">‹ &nbsp; Вернуться на карту</a>

            <div class="title">Вы выбрали (<?= count($favorites) ?>):</div>

            <div class="items-table">
                
                <?php if(!empty( $favorites ) ): ?>
                
                    <?php foreach( $favorites as $item ): ?>

                        <div class="item">

                            <div class="row">

                                <div class="col-md-3">

                                    <a target="_blank" href="/boards/detail/<?= $item->GID ?>/<?= $item->code ?>/">
                                        <img src="<?= $item->small ?>">
                                    </a>

                                </div>

                                <div class="col-md-2">

                                    <div class="name"><div class="ellipse"></div>1. <?= $item->type ?></div>

                                </div>

                                <div class="col-md-7">

                                    <a target="_blank" href="/boards/detail/<?= $item->GID ?>/<?= $item->code ?>/">
                                        # <?= $item->GID ?>_<?= $item->code ?> &#160; <?= $item->address ?>
                                    </a>

                                </div>


                            </div>

                            <div class="remove-item" onclick="remove(this, <?= $item->id ?>)">×</div>

                        </div>
                        
                    <?php endforeach; ?>
                    
                <?php else: ?>
                   
                    <div class="empty-favorites">В избранном нет ни одной конструкции</div>
                    
                <?php endif; ?>

            </div>
            
            <?php if(!empty( $favorites ) ): ?>

                <br>

                <div class="row">

                    <div class="col-sm-7">
                        <div class="download">
                            <a href="/favorites/export/">Скачать .xslx</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-md-right">
                        <div class="yellow-btn" onclick="callback('order')">Заказать</div>
                        <img class="share" src="/<?=TEMPLATE_DIR?>/img/share.svg">
                    </div>

                </div>
            
            <?php endif; ?>

             <div id="sp-map" class="pdf-ignore fav-top"></div>

        </div>

    </div>

</div>
        <script>
            var objects = <?=json_encode($mapObjs)?>;
           // console.log(objects);
        </script>
        <script src="https://api-maps.yandex.ru/2.1.56/?lang=ru_RU" type="text/javascript"></script>
        <script src="/template/public/js/special-offer-map.js"></script>
<script>
    
    function remove(el, id){
        
        $.getJSON('/favorites/remove/' + id, function(r){
            
            if(r.total == 0) {
                
                window.location.reload();
            
            } else {

                $(el).closest('.item').remove();

                $('.fav-list').html(r.header);

                $('.favorites .count').html(r.total);
                //console.log(id);
                if(id && objects) {
                    objects.forEach(function(item){
                        if(item.id==id){
                            delete item.coordinates;
                            console.log(item);
                        }
                    });
                    updateMap(objects);
                }
                
            }
            
        });
        
    }

</script>

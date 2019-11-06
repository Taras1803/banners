<div class="grey-bg">
    <div class="container">

        <h1><?= $cat->name ?></h1>

    </div>
</div>

<div class="white-bg">
    
    <div class="container">
    
        <div class="row">
        
            <div class="col-sm-7">
    
                <ul class="services-list">
                    <?php foreach( $items as $item ): ?>
                       
                        <?php if( empty( $item->content ) ): ?>
                           
                            <li><?= $item->name ?></li>
                            
                        <?php else: ?>
                           
                           <li><a href="/services/<?= $cat->url ?>/<?= $item->url ?>/"><?= $item->name ?></a></li>
                            
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                </ul>

                <div class="services-about">
                    Наружная реклама — это мощный маркетинговый инструмент, позволяющий продвигать продукцию среди широкой аудитории. 
                    Стоимость наружной рекламы относительно невысока, что позволяет использовать ее при проведении масштабных рекламных кампаний. 
                    Хорошее агентство наружной рекламы всегда готово предоставить несколько форматов рекламы, позволяющих охватить 
                    широкую аудиторию. Один билборд за сутки могут увидеть сотни и даже тысячи человек.
                </div>

            </div>
            
            <div class="col-sm-5 hidden-xs">
                
                <img src="/<?= TEMPLATE_DIR ?>/img/services-bb.png" class="col-image" style="margin: 50px 0">
                
            </div>

        </div>
        
    </div>
    
</div>

<script src="/js/services.js"></script>
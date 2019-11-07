<div class="grey-bg">

    <div class="container">
        
        <br>

        <h1>Портфолио</h1>

        <div class="row">

            <? foreach( $portfolio as $item ): ?>

                <a href="<?= $item->image_full ?>" class="show-portfolio">
                    <div class="col-xs-12 col-sm-6 col-lg-4">

                        <div class="portfolio-item" style="background-image: url(<?= $item->image_large ?>); <? if( isset($item->props['position'])) echo "background-position: " . $item->props['position'];  ?>"></div>

                    </div>
                </a>

            <? endforeach; ?>

        </div>
        
        <br>

    </div>
    
</div>

<script src="/template/public/js/imageviewer.js"></script>

<script> 

    $('.show-portfolio').imageViewer({arrows: 1});

</script>
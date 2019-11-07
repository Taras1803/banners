<div class="grey-bg">

    <div class="container" id="charity">
        
        <br>

        <h1>Благотворительность</h1>

        <div class="row">
            <?php logger($items)?>

            <?php foreach( $items as $item ): ?>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <a target="_blank" href="<?= isset($item->props['href']) ? $item->props['href'] : '#' ?>">
                        <div class="partner">
                            <img src="<?= $item->image ?>">
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>

        </div>
        
        <br>

    </div>
    
</div>
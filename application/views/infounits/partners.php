<div class="grey-bg">

    <div class="container" id="partners">
        
        <br>

        <h1>Партнёрства</h1>

        <div class="row">

            <?php foreach( $partners as $partner ): ?>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="partner">
                        <img src="<?= $partner->image ?>">
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
        
        <br>

    </div>
    
</div>
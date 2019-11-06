<div class="grey-bg">

    <div class="container">
        
        <br>

        <h1>Благодарности</h1>

        <div class="row">

            <?php foreach( $thanks as $scan ): ?>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <a class="thanks" href="<?= $scan->image_full ?>">
                        <img src="<?= $scan->image ?>">
                    </a>
                </div>

            <?php endforeach; ?>

        </div>
        
        <br>

    </div>
    
</div>

<script src="/template/public/js/imageviewer.js"></script>

<script> 

    $('.thanks').imageViewer({arrows: 1});

</script>
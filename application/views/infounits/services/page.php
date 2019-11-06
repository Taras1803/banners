<div class="white-bg">
    
    <div class="container">
    
        <?php if( $cat ): ?>
    
            <a class="back" href="/services/<?= $cat->url ?>/">‹ &#160; <?= $cat->name ?></a>
            
        <?php else: ?>
        
            <br>
        
        <?php endif; ?>
       
        <h1><?= $item->name ?></h1>
    
        <div class="row">
        
            <div class="col-sm-7">
    
                <?= $item->content ?>

            </div>
            
            <div class="col-sm-5 hidden-xs">
                
                <img src="/<?=TEMPLATE_DIR?>/img/services-bb.png" class="col-image" style="margin: 0 0 50px">
                
            </div>

        </div>
        
    </div>
    
</div>


<script>

    $('.services-tabs').click(function(){
        
       $(this).toggleClass('active'); 
        
    });

</script>
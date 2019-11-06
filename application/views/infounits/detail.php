<div class="white-bg">
    
    <div class="container" id="news-detail">
    
        <a class="back" href="/news/">‹ &#160; Новости</a>
            
       
        <h1><?= $name ?></h1>
    
    
        <?= $content ?>

        <div style="height: 50px"></div>
        
    </div>
    
</div>


<script>

    $('.services-tabs').click(function(){
        
       $(this).toggleClass('active'); 
        
    });

</script>
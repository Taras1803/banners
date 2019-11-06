
<div class="white-bg">

    <div class="container">

        <h1>Новости</h1>

        <div class="yellow-btn xs-block subscribe-btn">Подписаться</div>

        <div class="news-list">
            
            <?php foreach( $news as $post ): ?>

                <div class="news-item">

                    <div class="date"><?php rus_date($post->date_created) ?></div>

                    <h2><?= $post->name ?></h2>

                    <?php if($post->image): ?>

                        <img class="news-item-image" src="<?= $post->image ?>">

                    <?php endif; ?>

                    <?= $post->content ?>

                </div>
            
            <?php endforeach; ?>

        </div>
        
        <div class="pagination">

            <?php

            if( $total_pages > 1 ) {
                
                    $url = '/news';

                    $start = ( ($current_page - 1) > 1) ? $current_page - 1 : 1 ;

                    $stop = ( ($current_page + 1) <= $total_pages ) ? $current_page + 1 : $total_pages;


                    if($current_page > 1){

                        $prev = $current_page - 1;

                        echo "<a href='$url/page-$prev/' class='arrow'>‹</a>";

                    }

                    if($current_page > 2){

                        echo "<a href='$url/'>1</a>";
                        
                    }
                        
                    if($current_page > 3){
                        
                        echo "<span>...</span>";

                    }

                    for($i = $start; $i <= $stop; $i++) {

                        if( $current_page != $i){

                            echo "<a href='$url/page-$i/'>$i</a>";

                        } else {

                            echo "<span class='current'>$i</span>";
                        }

                    }
                
                    if($current_page < $total_pages - 2){

                        echo "<span>...</span>";

                    }

                    if($current_page < $total_pages - 1){

                        echo "<a href='$url/page-$total_pages/'>$total_pages</a>";

                    }

                    if($current_page < $total_pages){

                        $next = $current_page + 1;

                        echo " <a href='$url/page-$next/' class='arrow'>›</a> ";

                    }

                } 

            ?>

        </div>

    </div>
    
    <div class="modal subscribe hidden" id="subscribe">

        <div class="modal-header">

            <span class="header-text">Подписаться на новости</span>

            <div class="close"></div>

        </div>

        <div class="modal-form">

            <form action="/email/subscribe/" method="POST">

                <input type="text" name="email" autocomplete="off" placeholder="E-mail"/>

                <input type="hidden" name="goal" value="news_update">

                <button class="yellow-btn">Отправить</button>

            </form>

        </div>

    </div>
    
    <script>
    
        $('.subscribe-btn').click(function(){
            
            modal('subscribe');
            
        });
    
    </script>

</div>
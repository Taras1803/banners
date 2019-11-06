
<?php if( !empty( $favorites ) ): ?>

    <div class="title">Вы выбрали:</div>

    <?php foreach ($favorites as $name => $count ): ?>

        <div class="item">
           <div class="name"><?= $name ?></div>
           <div class="quantity">
               <?= $count ?>
           </div> 
        </div>

    <?php endforeach; ?>

    <a href="/favorites/">Посмотреть все</a>
    
<?php else: ?>

    У вас нет избранных конструкций

<?php endif; ?>
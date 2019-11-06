<div class="container">
    <div class="portlet">
        <div class="portlet-title">

            <div class="buttons-set">
                <a href="/saler/offer_list/" class="btn">< Назад</a>
            </div>
            <div class="buttons-set pull-right">
                <a target="_blank" href="/saler/specialoffer/<?=$offer->id?>/" class="btn save">Ссылка для клиента</a>
            </div>

        </div>
        <div class="portlet-body">
            <h3>Предложение #<?=$offer->id?></h3>

            <?php if ($offer->offerData && count($offer->offerData)): ?>
                <table class="table table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Код</th>
                            <th>Ссылка</th>
                        </tr>
                    </thead>
                    <?php foreach($offer->offerData as $item): ?>
                        <tr>
                            <td><?= $item->id ?></td>
                            <td>#<?= $item->GID.' '.$item->code ?></td>
                            <td><a class="btn" target="_blank" href="/boards/detail/<?= $item->GID.'/'.$item->code ?>/">#<?= $item->GID.' '.$item->code ?></a></td>
                        </tr>
                    <?php  endforeach;?>
                </table>

            <?php else:?>
                <br>
                <p>Предложение не содержит объектов</p>
            <?php endif;?>

            <br>
            <h4 style="text-align:center;">Обновить предложение объектами находящимися в избранном?</h4>
            <?php if ($fav && count($fav)): ?>
                <p style="text-align:center;">Объекты в избранном:</p>
                <table class="table table-striped" style="text-align: center;">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Код</th>
                        <th>Ссылка</th>
                    </tr>
                    </thead>
                    <?php foreach($fav as $item):?>
                        <tr>
                            <td><?=$item->id?></td>
                            <td>#<?=$item->GID.' '.$item->code?></td>
                            <td><a class="btn" target="_blank" href="/boards/detail/<?=$item->GID.'/'.$item->code?>/">#<?=$item->GID.' '.$item->code?></a></td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <form action="/saler/offerUpdate/" method="post">
                    <input type="hidden" name="id" value="<?=$offer->id?>">
                    <input type="hidden" name="data" value="<?=$fav_string?>">
                    <button class="btn save">Обновить</button>
                </form>
            <?php else:?>
                <p>
                    <b>В избранном нет объектов</b>
                    , добавить объекты в избранное &nbsp;&nbsp;—&nbsp;&nbsp;
                    <a class="btn save" target="_blank" href="/boards/">Карта</a>
                </p>
            <?php endif;?>
        </div>
    </div>
</div>
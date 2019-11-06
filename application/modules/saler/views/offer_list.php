<div class="container">
    <div class="portlet">
        <div class="portlet-title">

            <div class="buttons-set pull-right">
                <a href="/saler/add/" class="btn save">Добавить новое предложение</a>
            </div>

        </div>

        <div class="portlet-body">
            <h3>Список ваших предложений</h3>

            <?php if (count($objs)): ?>
            <table class="table table-striped" style="text-align: center;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>id объектов</th>
                        <th>Дата создания</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach($objs as $obj):?>
                <tr>
                    <td><?= $obj->id ?></td>
                    <td><?= $obj->data ? $obj->data : 'Пусто' ?></td>
                    <td><?= $obj->create_date ?></td>
                    <td><a class="btn save" href="/saler/offer/<?=$obj->id?>/">Перейти</a></td>
                    <td><a class="btn delete" href="/saler/offerDel/<?=$obj->id?>/">Удалить</a></td>
                </tr>
                <?php endforeach;?>
            </table>

            <?php else:?>
            <p>У вас нет созданных предложений</p>
            <?php endif;?>
        </div>
    </div>
</div>
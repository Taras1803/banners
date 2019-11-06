<div class="portlet">
    <div class="portlet-title">

        <div class="caption">
            <span><?= $infounit->name ?></span>
        </div>

        <div class="buttons-set pull-right">

            <a href="<?= ADMIN_PAGE_PATH ?>infounits/add_item/<?= $infounit->id ?>/" class="btn save">Добавить</a>
            <a href="<?= ADMIN_PAGE_PATH ?>infounits/settings/<?= $infounit->id ?>/#tab_categories" class="btn">Категории</a>
            <a href="<?= ADMIN_PAGE_PATH ?>infounits/settings/<?= $infounit->id ?>/" class="btn">Настройки</a>

        </div>

    </div>
    <div class="portlet-body">

        <? if( !empty($categories) ): ?>

            <div class="infounits-filters">

                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="GET" name="filters">

                    <select class="form-control input-sm input-inline" name="category" onchange="document.forms['filters'].submit() ">

                        <option value="0">Все категории</option>

                        <? foreach( $categories as $cat): ?>

                            <option <?= set_selected_val($cat->id, $current_category) ?> value="<?= $cat->id ?>">

                                <?= str_repeat('&nbsp;', $cat->level * 3) . $cat->name ?>

                            </option>

                        <? endforeach; ?>

                    </select>

                    <input type="hidden" name="infounit_id" value="<?= $infounit->id ?>"/>

                </form>

            </div>

        <? endif; ?>

        <? if ( !empty($items) ) : ?>

            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        <th style="width: 30px"> ID </th>
                        <th style="width: 100px"> Дата</th>
                        <th style="width: 120px"> Время</th>
                        <th style="text-align: left"> Название </th>
                        <th style="width: 200px; text-align: left"> Категория </th>
                        <th style="width: 30px"></th>
                        <th style="width: 30px"></th>
                    </tr>
                </thead>
                <tbody>

                    <? foreach ($items as $item): ?>
                        <tr>
                            <td class="text-center"><?= $item->id ?></td>
                            <td class="text-center"><?= date('d.m.Y', strtotime($item->date_created)) ?></td>
                            <td class="text-center"><?= date('H:i', strtotime($item->date_created)) ?></td>
                            <td><?= $item->name ?></td>
                            <td>
                                <? if( $item->category_name ): ?>

                                    <a href="<?= ADMIN_PAGE_PATH ?>infounits/?infounit_id=<?= $infounit->id ?>&category=<?= $item->category ?>"><?= $item->category_name ?></a>

                                <? else: ?>

                                    Нет

                                <? endif; ?>
                            </td>
                            <td>
                                <a href="<?= ADMIN_PAGE_PATH ?>infounits/edit_item/<?= $item->id ?>/" class="table-btn"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td>
                                <a href="<?= ADMIN_PAGE_PATH ?>infounits/delete/<?= $item->id ?>/" class="table-btn delete"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                </tbody>

            </table>

        <? else : ?>

           <div class="alert alert-info">В этой категории нет элементов</div>

        <? endif; ?>

    </div>
</div>

<script src="/libraries/admin/js/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/libraries/admin/js/datatables/datatables.bootstrap.js" type="text/javascript"></script>
<script>
    
    $('.data-table').dataTable({
        
        "order": []
        
    });
    
</script>
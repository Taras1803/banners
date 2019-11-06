<div class="page-content" id="category-page">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                Настройка категорий
            </div>
            <div class="buttons-set pull-right">
                <a href="./add" class="btn save">Добавить</a>
            </div>
        </div>

        <div class="portlet-body">
            <div id="seo-table">
                <table class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th class="text-left">CODE</th>
                            <th class="text-left">H1</th>
                            <th class="text-left">SEO</th>
                            <th class="text-left" width="30"></th>
                            <th class="text-left" width="30"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($items as $item): ?>
                            <tr class="category-row">
                                <td><?=$item->id?></td>
                                <td><?=$item->code?></td>
                                <td><?=$item->h1?></td>
                                <td>
                                    <? $item->seo = trim($item->seo); ?>
                                    <? if (strlen($item->seo) < 120): ?>
                                        <?= $item->seo; ?>
                                    <? else: ?>
                                        <?= mb_strimwidth($item->seo, 0, 120, '...');?>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <a href="./edit/<?=$item->id?>" class="table-btn">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="table-btn delete"><i class="fa fa-times" data-id="<?=$item->id?>"></i></td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="/libraries/admin/js/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/libraries/admin/js/datatables/datatables.bootstrap.js" type="text/javascript"></script>
    <script>
        $('.data-table').dataTable();

        $('#seo-table .delete i').click(function(){
            var id = $(this).data('id'),
                that = $(this);

            if (!confirm('Вы уверены что хотите удалить категорию?')) return;

            $.post('./removeAjax/', { category_id: id }, function(res){
                that.parents('tr').remove();
            });
        });
    </script>
</div>
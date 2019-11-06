<div class="portlet">
    <div class="portlet-title">

        <div class="caption">
            <a href="/boards/" target="_blank">Рекламные конструкции</a>
        </div>

        <div class="buttons-set pull-right">

            <a href="/adm/boards/add/" class="btn save">Добавить</a>
            <span class="btn"  onclick="modal('.import_modal')">Импорт</span>
            <span class="btn" onclick="modal('.export_modal')">Экспорт</span>
            <a href="/adm/boards/props/" class="btn">Свойства</a>
            <a href="/adm/boards/types/" class="btn">Типы</a>

        </div>

    </div>

    <div class="portlet-body">

        <? if ( empty($boards) ): ?>

            <div class="alert alert-info">Рекламные конструкции отсутствуют</div>

        <? else: ?>

        <table class="table table-striped data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Тип</th>
                    <th class="text-left">Расположение</th>
                    <th style="width: 30px"></th>
                    <th style="width: 30px"></th>
                    <th style="width: 30px"></th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($boards as $board): ?>
                    <tr>
                        <td class="text-center">
                        <?= empty($board->GID) ? "0" : $board->GID ?>
                        </td>
                        <td>
                            <?= $board->type ?>
                        </td>
                        <td>
                            <?= empty($board->address) ? "Адрес не указан" : $board->address ?>
                        </td>
                        <td>
                            <a href="/adm/boards/edit/<?= $board->id ?>/" class="table-btn"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td class="text-center"> 
                            <span class="table-btn bulb <? if( $board->active ): ?> on <? endif; ?>" toggle-val="active" item-id="<?= $board->id ?>">
                                <i class="fa fa-lightbulb-o"></i>
                            </span>
                        </td>
                        <td>
                            <a href="/adm/boards/remove/board/<?= $board->id ?>/" class="table-btn delete"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        <?php  endif;?>
    </div>
</div>

<div class="modal import_modal hidden">

    <div class="close-modal">&#9587;</div>

    <h4>Импорт конструкций из Excel</h4>

    <br/>

    <div class="log"></div>

    <form action="/adm/buildings/import/" name="import" enctype="multipart/form-data" method="post">

        <input type="file" id="xlsx" name="xlsx" class="file-input"/>

        <div class="import_status hidden">Ипортировано <span class="import_progress">0</span> из <span class="import_total">0</span> объектов</div>

        <br/>

        <div class="upload_xlsx btn save">Загрузить</div>
        <div class="start_import btn dark">Импорт</div>
        <div class="cancel_import btn dark">Стоп</div>

        <div class="checkbox-control btn-height pull-right">
            <input type="checkbox" name="import_images" id="import_images"><label for="import_images">импорт фото</label>
        </div>

    </form>


</div>

<div class="modal export_modal hidden">
    
    <div class="close-modal">&#9587;</div>

    <h4>Экспорт конструкций в Excel</h4>

    <form action="/adm/boards/export/" name="export" method="post">

        <h5>Компании</h5>
        <div class="row">

            <? foreach( $companies as $company ) : ?>

                <div class="col-md-6">
                    <div class="checkbox-control">
                        <input type="checkbox" id="company-<?= $company->id ?>" name="company[]" checked value="<?= $company->id ?>"/>
                        <label for="company-<?= $company->name ?>"><?= $company->name ?></label>
                    </div>
                </div>

            <? endforeach; ?>

        </div>

        <h5>Типы конструкций</h5>
        <div class="row">

            <? foreach( $types as $type ) : ?>

                <div class="col-md-6">
                    <div class="checkbox-control">
                        <input type="checkbox" id="type-<?= $type->id ?>" name="type[]" checked value="<?= $type->id ?>"/>
                        <label for="type-<?= $type->name ?>"><?= $type->name ?></label>
                    </div>
                </div>

            <? endforeach; ?>

        </div>

        <br/>

        <button class="btn save">Экспортировать</button>

    </form>
</div>

<script src="/libraries/admin/js/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/libraries/admin/js/datatables/datatables.bootstrap.js" type="text/javascript"></script>

<script src="/template/admin/js/boards-list.js"></script>
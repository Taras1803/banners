<div class="page-content"><div class="portlet">
        <div class="portlet-title">

            <div class="caption">
                Загрузка SEO текста для карты
            </div>

        </div>


        <div class="portlet-body">

            <?php if (isset($res)): ?>
                <p style="margin: 20px 0; color: #dd1144bd;"><?= $res ?></p>
            <?php endif; ?>

            <p>Каждый элемент с новой строки. Формат: <span style="font-style: italic;">Table|Code|h1|title|description|text</span></p>
            <p>Возможные названия таблиц: <span style="font-style: italic;">board_types, roads, towns, districts</span></p>
            <p>Примеры значений поля CODE: <span style="font-style: italic;">Schit_5x12, Vnukovskoe_shosse</span></p>
            <p><b>Незаполненные поля будут перезаписаны  пустой строкой</b></p>

            <form action="" method="post">
                <textarea cols="150" rows="20" style="resize:none;font-size:13px;" name="seo"></textarea>
                <p>
                    Пример вносимых данных:<br>
                    towns<b>|</b>Bronnicy<b>|</b>Наружная реклама в Бронницах<b>|</b>Наружная реклама в Бронницах<b>|</b>Description для страницы /boards/?town=Bronnicy<b>|</b>&lt;b&gt;html seo-текст&lt;/b&gt;
                </p>
                <br>
                <input type="submit" class="btn save" value="Отправить">
            </form>
            <!--
            <?//Не выводится так как пока не доделано и не нужно, но может понадобиться?>
            <div id="seo-table">
                <table class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th class="text-left">Таблица</th>
                            <th class="text-left">CODE</th>
                            <th class="text-left">H1</th>
                            <th class="text-left">Title</th>
                            <th class="text-left">Description</th>
                            <th class="text-left">Text</th>
                            <th style="width: 30px"></th>
                            <th style="width: 30px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tables = ['board_types', 'roads', 'towns', 'districts']; ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <?= $item->id ?>
                                </td>
                                <td>
                                    <select>
                                        <?php foreach ($tables as $table): ?>
                                            <option value="<?= $table ?>" <?php if($table === $item->linked_table): ?>selected<?php endif; ?>><?= $table ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <textarea><?= $item->code ?></textarea>
                                </td>
                                <td>
                                    <textarea><?= $item->h1 ?></textarea>
                                </td>
                                <td>
                                    <textarea><?= $item->title ?></textarea>
                                </td>
                                <td>
                                    <textarea><?= $item->description ?></textarea>
                                </td>
                                <td>
                                    <textarea><?= $item->text ?></textarea>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            -->
        </div>
</div>
<script src="/libraries/admin/js/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/libraries/admin/js/datatables/datatables.bootstrap.js" type="text/javascript"></script>
<script>$('.data-table').dataTable();</script>
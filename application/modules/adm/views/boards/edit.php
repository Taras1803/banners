<div class="row">
    <div class="col-md-12">
       
        <form action="/adm/boards/save/<?= $board->id ?>/" enctype="multipart/form-data" method="post">
        
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-pencil"></i>
                    <a href="/boards/detail/<?= $board->id ?>/" target="_blank">
                    
                    	<? if( !empty($board->GID) ) : ?>
                    	
                    	      Конструкция #<?= $board->GID ?>
                    	      
                        <? else : ?>
                        
                            GID не указан
                        
                        <? endif; ?>
                    	
                    </a>
                </div>
                <div class="buttons-set pull-right">
                    <button class="btn save">Сохранить</button>
                    <a class="btn" href="/adm/boards/" type="button">Вернуться</a>
                    <a href="/adm/boards/addside/<?= $board->id ?>/" class="btn default pull-right">Добавить сторону</a>
                </div>
            </div>
            
            <ul class="form-tabs">

                <li class="active">
                    <a href="#tab_general" data-tab> Общее </a>
                </li>

                <? foreach( $sides as $side ): ?>

                    <li>
                        <a href="#tab_side_<?= $side->id ?>" data-tab> 
                            <?= !empty($side->code) ? "Сторона $side->code" : 'Новая сторона' ?> 
                        </a>
                    </li>

                <? endforeach; ?>

            </ul>
            
            <div class="portlet-body">
   
                <div class="tab-content">
                   
                    <div class="tab-pane active" id="tab_general">
                       
                        <div class="form-body">

                            <div class="form-group">

                                <div class="col-xs-2">
                                   
                                    <label>Номер</label>

                                    <input class="form-control" type="text" name="board[GID]" value="<?= set_value('GID', $board->GID) ?>">
                                    
                                </div>
                                    
                                <div class="col-xs-3">

                                    <label>Собственник</label>

                                    <select class="form-control" name="board[owner]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($companies as $company): ?>

                                            <option <?= set_selected_val($company->id, $board->owner) ?> value="<?= $company->id ?>"><?= $company->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-xs-3">

                                    <label>Тип конструкции</label>

                                    <select class="form-control" name="board[region_id]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($types as $type): ?>

                                            <option <?= set_selected_val($type->id, $board->type) ?> value="<?= $type->id ?>"><?= $type->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                </div>

                            </div>

                            <br>

                            <h4>Расположение</h4>

                            <hr>

                            <br>

                            <div class="form-group">

                                <div class="col-xs-12">

                                    <label>Полный адрес</label>

                                    <textarea class="form-control" name="board[address]"><?= set_value('address', $board->address) ?></textarea>

                                </div>	

                            </div>

                            <div class="form-group">

                                <div class="col-xs-4">

                                    <label class="">Регион</label>

                                    <select class="form-control" name="board[region_id]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($regions as $region): ?>

                                            <option <?= set_selected_val($region->id, $board->region_id) ?> value="<?= $region->id ?>"><?= $region->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                    <br>
                                    
                                </div>
                                    
                                <div class="col-xs-4">

                                    <label>Район</label>

                                    <select class="form-control" name="board[district_id]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($districts as $district): ?>

                                            <option <?= set_selected_val($district->id, $board->district_id) ?> value="<?= $district->id ?>" ><?= $district->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-xs-4">

                                    <label>Город</label>

                                    <select class="form-control" name="board[town_id]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($towns as $town): ?>

                                            <option <?= set_selected_val($town->id, $board->town_id) ?> value="<?= $town->id ?>" ><?= $town->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                    <br>
                                    
                                </div>
                                    
                                <div class="col-xs-4">

                                    <label>Шоссе</label>

                                    <select class="form-control" name="board[road_id]">

                                        <option value="0">Не указан</option>

                                        <? foreach ($roads as $road): ?>

                                            <option <?= set_selected_val($road->id, $board->road_id) ?> value="<?= $road->id ?>" ><?= $road->name ?></option>

                                        <? endforeach; ?>

                                    </select>

                                </div>

                            </div>

                            <br>

                            <div class="form-group">
                                <div class="col-xs-12">

                                    <div class="form-map" id="ymap"></div>

                                    <input class="form-control" id="mapcoors" name="board[coordinates]" type="hidden" value="<?= $board->coordinates ?>"/>

                                </div>
                            </div>

                            <br>

                            <h4>Характеристики</h4>

                            <hr>

                            <br>
                            
                            <div class="form-group">

                                <? foreach ($props as $i => $prop): ?>

                                    <div class="col-xs-4">
                                       
                                       <label><?= $prop->name ?></label>
                                       
                                        <input class="form-control" name="props[<?= $prop->code ?>]" value="<?= isset($board->props[$prop->code]) ? $board->props[$prop->code] : '' ?>" />
                                   
                                     </div>

                                <? endforeach; ?>
                            
                            </div>

                        </div>
                    </div>

                    <? foreach( $sides as $side ) : ?>

                        <div class="tab-pane" id="tab_side_<?= $side->id ?>">

                            <div class="form-body form-horizontal">

                                <div class="form-group">

                                    <label class="col-xs-2 control-label">
                                        Код стороны
                                    </label>

                                    <div class="col-xs-5">

                                        <input class="form-control" name="sides[<?= $side->id ?>][code]" value="<?= $side->code ?>">

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-xs-2 control-label">
                                        Статус
                                    </label>

                                    <div class="col-xs-5">

                                        <select class="form-control" name="sides[<?= $side->id ?>][status]">

                                            <option <?= $side->status == 0 ? 'selected' : '' ?> value="0">Не установлен</option>
                                            <option <?= $side->status == 1 ? 'selected' : '' ?> value="1">Установлен</option>
                                            <option <?= $side->status == 2 ? 'selected' : '' ?> value="2">Ремонт</option>

                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-2">Фотография</label>
                                    <div class="col-xs-10">
                                        <div class="fileinput <?php if(empty($side->image_path)):?>fileinput-new<?php  else:?>fileinput-exists<?php endif;?>" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput">

                                                <?php if ( !empty($side->image_path) ):?>

                                                    <img src="<?= $side->image_path ?>" class="form-image"/>

                                                <?php endif;?>

                                            </div>
                                            <div>
                                                <span class="btn btn-file">
                                                    <span class="fileinput-new"> Выбрать изображение </span>
                                                    <span class="fileinput-exists"> Изменить </span>
                                                    <input type="file" name="sides[<?= $side->id ?>][image_id]"> 
                                                </span>
                                                <a href="javascript:;" class="btn delete fileinput-exists" data-dismiss="fileinput"> Удалить </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group">

                                    <label class="col-xs-2 control-label">
                                        Стоимость
                                    </label>

                                    <div class="col-xs-5">

                                        <input class="form-control" name="sides[<?= $side->id ?>][price]" value="<?= $side->price ?>">

                                    </div>

                                </div>

                                <br>

                                <div class="form-group">

                                    <label class="col-xs-2 control-label">
                                        Направление
                                    </label>

                                    <div class="col-xs-5">

                                        <select class="form-control" name="sides[<?= $side->id ?>][direction]">

                                            <option <?= $side->direction == 0 ? 'selected' : '' ?> value="0">Не указано</option>
                                            <option <?= $side->direction == 1 ? 'selected' : '' ?> value="1">Из Москвы</option>
                                            <option <?= $side->direction == 2 ? 'selected' : '' ?> value="2">В Москву</option>

                                        </select>
                                    </div>

                                </div>

                                <br>

                                <div class="form-group">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-10">
                                        <a href="/adm/boards/remove/side/<?= $side->id ?>/" class="btn delete">Удалить сторону</a>
                                    </div>
                                </div>


                            </div>

                        </div>

                    <? endforeach; ?>

                </div>
                
            </div>
            
            <div class="buttons-set bottom">
                <button class="btn save save">Сохранить</button>
                <button class="btn btn-secondary-outline" onclick="/adm/buildings/" type="button">Вернуться</button>
            </div>
            
        </div>
        <?= form_close() ?>
    </div>
</div>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<script src="/libraries/admin/js/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="/template/admin/js/boards-edit.js" type="text/javascript"></script>

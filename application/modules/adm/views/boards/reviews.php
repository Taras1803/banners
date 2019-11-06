
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
           
           <form action="" method="post">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="caption-subject bold uppercase">Отзывы</span>
                    </div>
                    
                    <a href="/adm/buildings/" style="line-height: 50px;"><i class="fa fa-angle-left"></i> Назад</a>

                    <!--<button class="btn purple pull-right" style="margin: 0 0 0 20px" >Сохранить</button>
                    <span class="btn blue pull-right add-prop">Добавить свойство</span>--> 

                </div>


                <div class="portlet-body">
                    <?php if (empty($reviews)):?>
                    <div class="alert alert-info">Пока нет ни одного отзыва</div>
                    <?php else:?>
                    <table class="table table-striped table-bordered table-hover" id="prop_list">
                        <thead>
                            <tr>
                                <th style="width: 200px"> Объект </th>
                                <th style="width: 130px"> Имя </th>
                                <th> Отзыв </th>
                                <th style="width: 100px"> Дата </th>
                                <th style="width: 30px"> А</th>
                                <th style="width: 45px"></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php foreach ($reviews as $review): ?>
  
                                <tr>
                                    <td> 
                                        <a href="<?= BUILDINGS_PATH ?>/detail/<?= $review->building_id ?>/" target="_blank"><?= $review->building_name ?></a>
                                    </td>
                                    <td>
                                        <?= $review->name ?>
                                    </td>
                                    <td class="show_review">
                                       
                                        <? echo mb_substr( $review->review, 0, 200, 'utf-8' ); ?>
                                        
                                        <div class="popup review_modal"><?= $review->review ?></div>
                                        
                                    </td>
                                    <td>
                                        <? echo date('d-m-Y', strtotime($review->date) ); ?>
                                    </td>
                                    <td>
                                        <input type="checkbox" <? if($review->active) echo 'checked'; ?> toggle-val="active" item-id="<?= $review->id ?>"/>
                                    </td>
                                    <td>
                                        <span class="btn default red" onclick="delete_review(<?= $review->id ?>, this)"><i class="fa fa-times"></i></span>
                                    </td>
                                </tr>
                                
                            <?php endforeach; ?>
                            
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    
                    <div class="popup review_modal">
                    </div>
                    
                    <?php endif;?>
                    
                </div>
            
            </form>
            
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>

<script>
    
    $(document).on('click', '[toggle-val]', function(){

        id  = $(this).attr('item-id');
        col = $(this).attr('toggle-val');

        checked = $(this).prop('checked');

        $.post('/adm/buildings/active_review/', {id: id, checked: checked, col: col});

    });
    
    $('.show_review').click(function(){
        
         $('.bg').fadeIn(300);
         $(this).find('.review_modal').fadeIn(300);
        
    });
    
     function delete_review( id, e ){
         
         $.post('/adm/buildings/remove_review/' + id);

         $(e).closest('tr').remove();
         
     }
    
</script>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet">
           
           <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="portlet-title">
                    <div class="caption">
                        <span>Типы конструкций</span>
                    </div>
                    
                    <div class="buttons-set pull-right">

                        <button class="btn save">Сохранить</button>
                        <a href="javascript:void()" class="btn add-type">Добавить тип</a>
                        <a href="/adm/boards/types/?recount=1" class="btn add-type">Пересчитать</a>
                        <a href="/adm/boards/" class="btn">Назад</a>
                    
                    </div>

                </div>


                <div class="portlet-body">
                  
                    <table class="table all-borders" id="type_list">
                        <thead>
                            <tr>
                                <th> Имя </th>
                                <th width="200"> Цвет </th>
                                <th width="150"> Количество </th>
                                <th width="45"></th>
                            </tr>
                        </thead>
                        <tbody>
                   
                            <?php if (empty($types)):?>

                                <tr class="type">
                                    <td>
                                        <input type="text" name="type[new][name]" value="" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="color" name="type[new][color]" value="" class="form-control"/>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="type[new][count]"/>
                                    </td>
                                    <td class="text-center">
                                        <span class="btn default red" onclick="delete_type(this)"><i class="fa fa-times"></i></span>
                                    </td>
                                </tr>

                            <?php else:?>
                    
                                <?php foreach ($types as $type): ?>

                                    <tr class="type">
                                       
                                        <td>
                                            <input type="text"   name="type[<?= $type->id ?>][name]" value="<?= $type->name ?>" class="form-control"/>
                                            <input type="hidden" name="type[<?= $type->id ?>][id]" value="<?= $type->id ?>" class="type_id"/>
                                        </td>
                                        <td>
                                            <input type="color" value="<?= $type->color ?>" class="form-control"/>
                                            <input type="text" class="form-control color-value" value="<?= $type->color ?>" name="type[<?= $type->id ?>][color]">
                                        </td>
                                        <td>
                                            <input type="text" name="type[<?= $type->id ?>][count]" value="<?= $type->count ?>" class="form-control"/>
                                        </td>
                                        <td class="text-center">
                                            <span class="table-btn delete" onclick="delete_type(this)"><i class="fa fa-times"></i></span>
                                        </td>
                                        
                                    </tr>

                                <?php endforeach; ?>
                            
                            <?php endif;?>
                    
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    
                </div>
                
                <div class="buttons-set bottom">
                    <button class="btn save">Сохранить</button>
                    <a href="javascript:void()" class="btn add-type">Добавить тип</a>
                    <a href="/adm/boards/types/?recount=1" class="btn add-type">Пересчитать</a>
                    <a href="/adm/boards/" class="btn">Назад</a>
                </div>
            
            </form>
            
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>

<script>
    
    i = 1;
    
    $('.add-type').click(function(){
         
         type = $('#type_list tbody tr:first').clone().appendTo('#type_list tbody');
         
         type.find('.type_id').remove();
         
         type.find('input, select').each(function(){
             
             $(this).val('').attr("name", $(this).attr("name").replace( $(this).attr("name").match(/\[(.+?)\]/g)[0], "[new_" + i + "]") );
             
             $(this).next('.color-value').html('#000000');
         
         });
             
         i++;
         
     });
    
     $('input[type="color"]').on('input', function(){
         
        var color = this.value;
         
        $(this).next().val(color);
         
     });
    
     $('.color-value').on('keyup', function(){
         
        var color = this.value;
         
        $(this).prev().val(color);
         
     });
    
     function delete_type(e){
         
         var tr = $(e).closest('tr');
         
         var id = tr.find('.type_id').val();
         
         if( id ){
             
             $.post('/adm/boards/remove_type/' + id);
             
         }
         
         if( $('#type_list .type').length > 1 ){
         
            tr.remove();
         
         } else {
           
             tr.find('input, select').val('');
             
         }
         
     }
    
</script>
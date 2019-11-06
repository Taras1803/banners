<html>
   
    <head>

       <style>

            body{

               font-family: sans-serif;
               font-size: 14px;

            }
           
            table{

                border-collapse: collapse;

            }
           
            h1{
            
                font-size: 24px;
                
            }
           
            td,th{

                border: 1px solid #eee;
                padding: 10px 20px;

            }

       </style>

    </head>

    <body>

        <h1>vmoutdoor.ru заказ конструкции</h1>

        <p>Имя: <?= $name ?></p>
        <p>Телефон: <?= $phone ?></p>
        
        <br>

        <table>

            <thead>
                <tr>
                    <th>Код</th>
                    <th>Адрес</th>
                </tr>
            </thead>

            <tbody>

               <?php foreach ($boards as $board): ?>

                   <tr>
                       <td>#<?= $board->GID ?>_<?= $board->code ?></td>
                       <td><?= $board->address ?></td>
                   </tr>

               <?php endforeach; ?>

            </tbody>

        </table>

    </body>
    
</html>
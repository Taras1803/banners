<!DOCTYPE html>

<html lang="ru">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VM Special Offer</title>

    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,600&amp;subset=cyrillic" rel="stylesheet">
    <link href="/libraries/admin/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/template/public/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/template/public/css/special-offer.css" rel="stylesheet" type="text/css"/>

    <script src="/libraries/public/js/jquery/jquery-3.2.1.min.js"></script>
<body>
    <div class="container-fluid" id="sp">
        <div class="pdf-ignore"><a href="/"><img src="/template/public/img/vm_logo.svg" id="sp-logo"></a></div>
        <h1>Специальное предложение для Вас</h1>

        <?php if ($offer->email || $offer->phone): ?>
            <h2>Связаться с менеджером</h2>
            <div id="sp-contacts">
                <?php if ($offer->email): ?>
                    <div class="col-xs-6">Телефон</div>
                    <div class="col-xs-6"><a href="tel:<?= $offer->phone ?>"><?= $offer->phone ?></a></div>
                <?php endif; ?>
                <?php if ($offer->email): ?>
                    <div class="col-xs-6">E-mail</div>
                    <div class="col-xs-6"><a href="mailto:<?= $offer->email ?>"><?= $offer->email ?></a></div>
                <?php endif;?>
            </div>
        <?php endif;?>
        <div id="btnPrint" class="btn save pdf-ignore">Скачать в pdf</div>

        <div id="sp-map" class="pdf-ignore"></div>

        <div id="sp-tables">
            <?php foreach($offer->offerData as $item): ?>
                <div class="col-sm-6">
                    <h3><?= $item->name ?>, #<?= $item->GID.' '.$item->code ?></h3>
                    <img src="<?= $item->medium ?>" alt="">
                    <table class="table table-striped">
                        <tr>
                            <td>GID</td>
                            <td><?= $item->GID ?></td>
                        </tr>
                        <tr>
                            <td>Тип конструкции</td>
                            <td><?= $item->name ?></td>
                        </tr>
                        <tr>
                            <td>Сторона</td>
                            <td><?= $item->code ?></td>
                        </tr>
                        <tr>
                            <td>Адрес</td>
                            <td><?= $item->address ?></td>
                        </tr>
                        <tr class="pdf-ignore">
                            <td>Детальная страница</td>
                            <td><a target="_blank" href="/boards/detail/<?= $item->GID ?>/" class="btn save">Ссылка</a></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            var objects = <?= json_encode($mapObjs) ?>;
        </script>
        <script src="https://api-maps.yandex.ru/2.1.56/?lang=ru_RU" type="text/javascript"></script>
        <script src="/template/public/js/special-offer-map.js"></script>
        <script src="/template/public/js/html2canvas.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>-->
        <script src="/template/public/js/jspdf.min.js"></script>
        <script>
            $('#btnPrint').click(function(){
                var sp = $('#sp');
                $('.pdf-ignore').css('display', 'none');
                sp.css({width: '1300px', margin: '0 auto'});

                html2canvas(sp[0], {
                    onrendered:function(canvas) {

                        var contentWidth = canvas.width;
                        var contentHeight = canvas.height;

                        //The height of the canvas which one pdf page can show;
                        var pageHeight = contentWidth / 592.28 * 841.89;
                        //the height of canvas that haven't render to pdf
                        var leftHeight = contentHeight;
                        //addImage y-axial offset
                        var position = 0;
                        //a4 format [595.28,841.89]
                        var imgWidth = 595.28;
                        var imgHeight = 592.28/contentWidth * contentHeight;

                        var pageData = canvas.toDataURL('image/jpeg', 1.0);

                        var pdf = new jsPDF('', 'pt', 'a4');

                        if (leftHeight < pageHeight) {
                            pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight );
                        } else {
                            while(leftHeight > 0) {
                                pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                                leftHeight -= pageHeight;
                                position -= 841.89;
                                //avoid blank page
                                if(leftHeight > 0) {
                                    pdf.addPage();
                                }
                            }
                        }

                        pdf.save('content.pdf');
                        $('.pdf-ignore').css('display', 'block');
                        $('tr.pdf-ignore').css('display', 'table-row');
                        sp.css({width: 'auto', margin: 'auto'});
                    }
                });
            });
        </script>
        <br>
        <br>
    </div>
</body>
</html>
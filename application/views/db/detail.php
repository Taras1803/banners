<div id="db">
    <div class="container">
        <div class="row">
            <h1 class="col-md-12"><?= $h1 ?></h1>

            <?php if(!empty($breadcrumbs)): ?>
                <?php $i=1; ?>
                <div id="db-breadcrumbs" class="col-md-12">
                    <?php foreach($breadcrumbs as $b => $val): ?>

                        <?php if ($i != count($breadcrumbs)): ?>
                            <a href="<?= $val ?>"><?= $b ?></a> <span class="sep"></span>
                        <?php else: ?>
                            <span><?= $b ?></span>
                        <?php endif; ?>
                        <?php $i++; ?>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="col-md-12 col-lg-9">

                <?php if (!empty($objs)): ?>

                    <?php foreach($objs as $key => $obj):?>
                        <h2><?= $key ?></h2>
                        <div class="row">
                            <?php foreach($obj as $item): ?>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <p>
                                        <a href="/boards/detail/<?= $item->GID ?>/" target="_blank">
                                            <?= $key ?>, номер #<?= $item->GID ?>
                                        </a>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>

            </div>
            <div class="col-lg-3 hidden-md hidden-xs hidden-sm">
                <img src="/template/public/img/services-bb.png" id="db-image">
            </div>
        </div>
    </div>
</div>
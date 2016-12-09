<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use xz1mefx\adminlte\helpers\Html;
use xz1mefx\adminlte\web\AdminLteAsset;
use xz1mefx\adminlte\widgets\Alert;
use xz1mefx\adminlte\widgets\ContentHeader;

AppAsset::register($this);
AdminLteAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head(); ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody(); ?>

        <div class="wrapper">

            <?= $this->render('@app/views/layouts/_header') ?>

            <?= $this->render('@app/views/layouts/_left_sidebar') ?>

            <div class="content-wrapper">
                <?= ContentHeader::widget([
                    'title' => 'Yii2 AdminLTE',
                    'titleSmall' => '@xZ1mEFx',
                    'breadcrumbsConfig' => [
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ],
                ]) ?>

                <section class="content">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </section>
            </div>

            <?= $this->render('@app/views/layouts/_footer') ?>

            <?= $this->render('@app/views/layouts/_right_sidebar') ?>

        </div>

        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
